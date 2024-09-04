<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ProductImage\DeleteProductImageAction;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $productImage)
    {
        $success = app()->make(DeleteProductImageAction::class)->handle($productImage);

        if (request()->ajax()) {

            return response()->json([
                'message' => 'Xóa ảnh sản phẩm thành công.'
            ]);
        }

        return redirect()->back();
    }
}
