<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        return view('client.home.wishlist');
    }

    public function store(string|int $product)
    {
        $wishlist = Wishlist::query()
            ->where('user_id', auth()->user()->id)
            ->where('product_id', $product)->first();

        if (!$wishlist) {
            Wishlist::create([
                'user_id' => auth()->user()->id,
                'product_id' => $product
            ]);
        }

        return response()->json([
            'message' => 'Thêm vào sản phẩm yêu thích thành công.'
        ]);
    }

    public function destroy(Request $request)
    {
        $productIds = $request->input('product_id');

        Wishlist::query()
            ->whereIn('product_id', $productIds)
            ->delete();

        return response()->json([
            'message' => 'Xóa sản phẩm yêu thích thành công.'
        ]);
    }
}
