<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request, Product $product)
    {
        // Fix #5: Kiểm tra tồn kho trước khi thêm vào giỏ
        if (!$product->isInStock()) {
            return response()->json([
                'message' => 'Sản phẩm này đã hết hàng.',
            ], 422);
        }

        $carts = Session::get('cart', []);
        $key = $product->id . '-' . $request->input('color') . '-' . $request->input('size');
        $color = Color::findOrFail($request->input('color'));
        $size = Size::findOrFail($request->input('size'));

        $currentQuantity = ($carts[$key]['quantity'] ?? 0) + $request->input('quantity', 1);

        if ($currentQuantity > $product->stock) {
            return response()->json([
                'message' => 'Số lượng vượt quá tồn kho (còn lại: ' . $product->stock . ').',
            ], 422);
        }

        $carts[$key] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'old_price' => $product->old_price,
            'is_sale' => $product->isSale(),
            'thumbnail' => $product->getThumbnail(),
            'color_name' => $color->name,
            'color_label' => $color->label,
            'size_name' => $size->name,
            'quantity' => $currentQuantity,
            'color' => $color->id,
            'size' => $size->id,
            'key' => $key,
            'discount' => $product->getDiscount(),
            'disabled' => false,
        ];

        Session::put('cart', $carts);

        return response()->json([
            'body' => view('client.modal.common.shopping_cart_body')->render(),
            'footer' => view('client.modal.common.shopping_cart_footer')->render(),
            'count' => count($carts),
            'message' => 'Thêm vào giỏ hàng thành công.',
        ]);
    }

    public function removeItem(string $key)
    {
        $carts = Session::get('cart', []);
        unset($carts[$key]);

        Session::put('cart', $carts);

        return response()->json([
            'footer' => view('client.modal.common.shopping_cart_footer')->render(),
            'cart_summary' => view('client.home.common.cart_summary')->render(),
            'cart_items' => view('client.home.common.cart_item')->render(),
            'count' => count($carts),
        ]);
    }

    public function updateQuantity(Request $request, string $key)
    {
        $carts = Session::get('cart', []);

        $carts[$key]['quantity'] = $request->input('quantity');

        Session::put('cart', $carts);

        return response()->json([
            'footer' => view('client.modal.common.shopping_cart_footer')->render(),
            'cart_summary' => view('client.home.common.cart_summary')->render(),
            'cart_items' => view('client.home.common.cart_item')->render(),
        ]);
    }

    public function showCart()
    {
        return view('client.home.shopping_cart');
    }
    
    public function clearCart()
    {
        Session::put('cart', []);

        return response()->json([
            'footer' => view('client.modal.common.shopping_cart_footer')->render(),
            'cart_summary' => view('client.home.common.cart_summary')->render(),
            'count' => 0,
        ]);
    }
}
