<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->active()
            ->with([
                'colors',
                'colors.color',
                'sizes',
                'sizes.size',
                'images',
            ])
            // ->limit(4)
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
}
