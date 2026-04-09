<?php

namespace App\Http\Controllers\Client;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Color;
use App\Models\Kind;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\ShippingAddress;
use App\Models\Size;
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
        $category = $request->input('category');

        $query = Product::query()
            ->active()
            ->with([
                'colors',
                'colors.color',
                'sizes',
                'sizes.size',
                'images',
            ])
            ->when($category, function ($query) use ($category) {
                $query->whereHas('kind.category', function ($query) use ($category) {
                    $query->where('id', $category);
                });
            });

        $products = $query->paginate($limit, ['*'], 'page', $page);

        if ($request->ajax()) {
            $html = "";
            foreach ($products as $item) {
                $html .= Blade::render('<x-client.product :product="$product" />', ['product' => $item]);
            }
            return response()->json($html);
        }

        $categories = Category::query()->with('kinds')->get();
        $banners = Banner::query()->get();
        $reviews = Review::query()
            ->with([
                'user',
                'product',
                'product.images',
            ])
            ->orderBy('id', 'desc')->limit(6)
            ->get();

        return view('client.home.index', [
            'categories' => $categories,
            'banners' => $banners,
            'products' => $products,
            'canViewMore' => $products->hasMorePages(),
            'category' => $category,
            'reviews' => $reviews,
        ]);
    }

    public function productDetail(Product $product)
    {
        $maximumRelatedProduct = 10;
        $product->load(Product::getProductRelations());
        // Eager-load reviews separately to avoid N+1 when blade calls $product->reviews->avg()
        $product->load('reviews');
        $reviews = Review::query()
            ->with([
                'user',
            ])
            ->where('product_id', $product->id)
            ->paginate();

        $arrProductViewed = Session::get('productViewed', []);

        if (!in_array($product->id, $arrProductViewed)) {
            $arrProductViewed[] = $product->id;
            $arrProductViewed = array_slice(array_unique($arrProductViewed), 0, 20);
            Session::put('productViewed', $arrProductViewed);
        }

        // Similar products: same kind + price within ±40% range for better relevance
        $priceMin = $product->price * 0.6;
        $priceMax = $product->price * 1.4;
        $productVieweds = Product::query()
            ->whereHas('kind', fn($q) => $q->where('id', $product->kind_id))
            ->where('id', '!=', $product->id)
            ->whereBetween('price', [$priceMin, $priceMax])
            ->active()
            ->with(Product::getProductRelations())
            ->limit($maximumRelatedProduct)
            ->get();

        // Fallback: if fewer than 4 similar products, fill with any from same kind
        if ($productVieweds->count() < 4) {
            $existingIds = $productVieweds->pluck('id')->push($product->id);
            $fallbacks = Product::query()
                ->whereHas('kind', fn($q) => $q->where('id', $product->kind_id))
                ->whereNotIn('id', $existingIds)
                ->active()
                ->with(Product::getProductRelations())
                ->limit($maximumRelatedProduct - $productVieweds->count())
                ->get();
            $productVieweds = $productVieweds->concat($fallbacks);
        }

        $arrProductViewedIds = Session::get('productViewed', []);
        $recentlyVieweds = Product::query()
            ->whereIn('id', $arrProductViewedIds)
            ->where('id', '!=', $product->id)
            ->active()
            ->with(Product::getProductRelations())
            ->limit(10)
            ->get();

        // Build rating distribution from already-loaded reviews (no extra query)
        $totalReviews = $product->reviews->count();
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $product->reviews->where('rating', $i)->count();
        }

        return view('client.product.detail', compact('product', 'productVieweds', 'reviews', 'recentlyVieweds', 'ratingDistribution', 'totalReviews'));
    }

    public function wishlist()
    {
        $wishlists = Wishlist::query()
            ->with(['product', 'product.images'])
            ->where('user_id', Auth::id())
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
        $cart = session()->get('cart', []);

        $result = app()->make(\App\Actions\Client\Checkout\CalculateCartQuantityAction::class)->handle($cart);
        $cart = $result['cart'];
        $products = $result['products'];
        $errorQuantity = $result['errorQuantity'];

        session()->put('cart', $cart);
        session()->put('final_cart', $cart);

        return view('client.home.checkout', compact('shippingAddress', 'products', 'errorQuantity'));
    }

    public function orderSuccess()
    {
        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('payos_order_code', request()->input('orderCode'))
            ->first();

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
            ->with(['orderDetails', 'orderDetails.product', 'orderDetails.product.images', 'reviews'])
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

    public function shop(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort', 'name:asc');
        $isSale = $request->boolean('is_sale', false);

        $kinds = Kind::query()
            ->with([
                'products'
            ])
            ->get();

        $sizes = Size::query()
            ->get();

        $colors = Color::query()
            ->get();

        $filters = [
            "min_price" => $request->input('min_price', 0),
            "max_price" => $request->input('max_price', 500000),
            'kind' => $request->input('kinds', $kinds->pluck('id')->toArray()),
            'size' => $request->input('sizes', $sizes->pluck('id')->toArray()),
            'color' => $request->input('colors', $colors->pluck('id')->toArray()),
        ];

        if (request()->ajax()) {
            $filters = [
                ...$filters,
                'kind' => $request->input('kinds', []),
                'size' => $request->input('sizes', []),
                'color' => $request->input('colors', []),
            ];
        }

        $products = app()->make(\App\Actions\Client\Product\GetShopProductsAction::class)->handle(
            filters: $filters,
            keyword: $keyword,
            sort: $sort,
            isSale: $isSale
        );

        if (request()->ajax()) {
            return response()->view('client.home.common.shop_product_grid', compact('products', 'sort'));
        }

        return view('client.home.shop', compact('products', 'kinds', 'sizes', 'colors', 'sort'));
    }

    public function tracking()
    {
        return view('client.home.tracking');
    }

    public function postTracking(Request $request)
    {
        $request->validate([
            'order_code' => 'required|integer',
            'phone' => 'required|string'
        ]);

        // Fix #2: Query trực tiếp phone_number trên bảng orders thay vì whereHas('shippingAddress')
        // Relationship shippingAddress() dùng Builder::raw() không resolve được trong whereHas
        $order = Order::query()
            ->where('id', $request->order_code)
            ->where('phone_number', $request->phone)
            ->with(['orderDetails.product', 'orderDetails.product.images'])
            ->first();

        return view('client.home.tracking', compact('order'))->with('searched', true);
    }
}
