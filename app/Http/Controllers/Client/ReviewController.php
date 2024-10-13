<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Review\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $arr = $request->input('arr', []);

        DB::beginTransaction();
        try {
            foreach ($arr as $item) {
                Review::create([
                    'user_id' => Auth::guard('web')->id(),
                    'product_id' => $item['product_id'],
                    'order_id' => $item['order_id'],
                    'rating' => $item['rating'],
                    'note' => $item['note'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Đánh giá sản phẩm thành công',
            ]);
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
            ], 500);
        }
    }
}
