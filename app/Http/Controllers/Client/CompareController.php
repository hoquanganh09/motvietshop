<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    public function add(Product $product)
    {
        $compare = Session::get('compare', []);

        if (in_array($product->id, $compare)) {
            return response()->json([
                'message' => 'Sản phẩm đã có trong danh sách so sánh',
                'count' => count($compare),
                'success' => false,
            ]);
        }

        if (count($compare) >= 3) {
            return response()->json([
                'message' => 'Chỉ có thể so sánh tối đa 3 sản phẩm',
                'count' => count($compare),
                'success' => false,
            ], 422);
        }

        $compare[] = $product->id;
        Session::put('compare', $compare);

        return response()->json([
            'message' => 'Đã thêm vào danh sách so sánh',
            'count' => count($compare),
            'success' => true,
        ]);
    }

    public function remove(Product $product)
    {
        $compare = Session::get('compare', []);
        $compare = array_values(array_filter($compare, fn($id) => $id !== $product->id));
        Session::put('compare', $compare);

        return response()->json([
            'message' => 'Đã xóa khỏi danh sách so sánh',
            'count' => count($compare),
            'success' => true,
        ]);
    }

    public function clear()
    {
        Session::forget('compare');

        return response()->json([
            'message' => 'Đã xóa danh sách so sánh',
            'count' => 0,
            'success' => true,
        ]);
    }

    public function index()
    {
        $ids = Session::get('compare', []);
        $products = Product::whereIn('id', $ids)
            ->with(Product::getProductRelations())
            ->get();

        return view('client.compare.index', compact('products'));
    }
}
