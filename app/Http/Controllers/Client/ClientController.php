<?php

namespace App\Http\Controllers\Client;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\Wishlist;
use App\Services\PayOS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $limit = 8;
        $page = $request->input('page', 1);

        $products = Product::query()
            ->active()
            ->with([
                'colors',
                'colors.color',
                'sizes',
                'sizes.size',
                'images',
            ])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->get();

        if ($request->ajax()) {
            $html = "";
            foreach ($products as $item) {
                $html .= Blade::render('<x-client.product :product="$product" />', ['product' => $item]);
            }
            return response()->json($html);
        }

        $categories = Category::query()->with('kinds')->get();
        $banners = Banner::query()->get();

        return view('client.home.index', [
            'categories' => $categories,
            'banners' => $banners,
            'products' => $products,
            'canViewMore' => $products->count() > $limit,
        ]);
    }

    public function productDetail(Product $product)
    {
        $product->load(Product::getProductRelations());

        $arrProductViewed = Session::get('productViewed', []);

        if (!in_array($product->id, $arrProductViewed)) {
            $arrProductViewed[] = $product->id;
            Session::put('productViewed', $arrProductViewed);
        }

        $productVieweds = Product::getProducts(
            ids: $arrProductViewed,
            exceptId: $product->id,
            limit: 16
        );

        if ($productVieweds->count() < 16) {
            $need = 16 - $productVieweds->count();

            $append = Product::getProducts(
                ids: $arrProductViewed,
                exceptId: $product->id,
                limit: $need,
                buider: true
            )->where('kind_id', $product->kind_id)->get();

            $productVieweds->merge($append);
        }
        // dd($productVieweds->toArray());
        return view('client.product.detail', compact('product', 'productVieweds'));
    }

    public function wishlist()
    {
        $wishlists = Wishlist::query()
            ->with(['product', 'product.images'])
            ->paginate();

        return view('client.home.wishlist', compact('wishlists'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('client.home.personal_info', compact('user'));
    }

    public function addresses()
    {
        $user = Auth::user();
        $user->load('addresses');

        return view('client.home.addresses', compact('user'));
    }

    public function notification()
    {
        $user = Auth::user();

        $notis = [
            [
                'id' => 1,
                'attr' => 'has_send_email_order',
                'label' => 'Xử lý đơn hàng',
                'des' => 'Thông báo qua email sau khi đặt hàng, xử lý đơn hàng.',
            ],
            [
                'id' => 1,
                'attr' => 'has_send_email_shipping',
                'label' => 'Vận chuyển đơn hàng',
                'des' => 'Thông báo qua email sau khi đặt hàng, xử lý đơn hàng',
            ],
        ];

        return view('client.home.notification', compact('user', 'notis'));
    }

    public function checkout()
    {
        $shippingAddress = ShippingAddress::query()
            ->where('user_id', Auth::id())
            ->where('is_default', 1)
            ->first();

        session()->put('discount', null);
        $errorQuantity = false;
        $cart = session()->get('cart', []);
        $products = collect($cart);
        $productIds = array_values($products->map(fn($item) => $item['id'])->toArray());
        $productsGroup = $products->groupBy('id');
        $orderProductQuantity = [];
        $productAppendQuantity = [];

        foreach ($productsGroup as $key => $item) {
            $orderProductQuantity[$key] = [
                'id' => $key,
                'quantity' => $item->sum('quantity'),
            ];
        }

        $productAvaiables = Product::query()
            ->whereIn('id', $productIds)
            ->get();

        foreach ($productAvaiables as $item) {
            $productAppendQuantity[$item->id] = 0;

            if ($item->stock < $orderProductQuantity[$item->id]['quantity']) {
                $errorQuantity = true;
                $productAppendQuantity[$item->id] = $orderProductQuantity[$item->id]['quantity'] - $item->stock;
            }
        }

        $cart = array_reverse($cart);
        $cart = array_map(function ($item) use (&$productAppendQuantity) {
            $item['disabled'] = false;
            if ($productAppendQuantity[$item['id']] > 0) {
                $item['disabled'] = true;
                $productAppendQuantity[$item['id']] -= $item['quantity'];
            }
            return $item;
        }, $cart);

        $cart = array_reverse($cart);

        session()->put('cart', $cart);
        session()->put('final_cart', $cart);

        return view('client.home.checkout', compact('shippingAddress', 'products', 'errorQuantity'));
    }

    public function orderSuccess()
    {
        $order = Order::query()->find(request()->input('orderCode'));

        if (!$order) {
            return abort(404);
        }

        if ($order->payment_method === PaymentMethod::Online->value) {
            $check = (new PayOS())->getPaymentStatus($order->id);

            if ($check['code'] == '00' && $check['data']['status'] == 'PAID') {
                $order->is_paid = true;
                $order->save();
            }
        }

        return view('client.home.order_success', compact('order'));
    }

    public function orderHistory()
    {
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with(['orderDetails', 'orderDetails.product', 'orderDetails.product.images'])
            ->orderBy('id', 'desc')
            ->paginate(5);

        if (request()->ajax()) {
            return response()->view('client.home.common.table_list_order', compact('orders'));
        }

        return view('client.home.order_history', compact('orders'));
    }

    public function productSearch(Request $request)
    {
        $keyword = $request->input('keyword');

        if (empty($keyword)) {
            return response()->json([
                'html' => '',
                'count' => 0,
            ]);
        }

        $products = Product::search($keyword)
            ->active()
            ->with([
                'images',
                'sizes',
                'sizes.size',
                'colors',
                'colors.color',
            ])
            ->get();

        $html = "";
        foreach ($products as $item) {
            $html .= Blade::render('<x-client.product_search :product="$product" />', ['product' => $item]);
        }
        return response()->json([
            'html' => $html,
            'count' => $products->count(),
        ]);
    }

    public function shop()
    {
        return view('client.home.shop');
    }
}
