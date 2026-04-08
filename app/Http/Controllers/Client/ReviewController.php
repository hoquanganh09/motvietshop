<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $arr = $request->input('arr', []);

        if (empty($arr) || !is_array($arr)) {
            return response()->json(['message' => 'Dữ liệu đánh giá không hợp lệ.'], 422);
        }

        $userId = Auth::guard('web')->id();

        DB::beginTransaction();
        try {
            foreach ($arr as $item) {
                // Fix #1: Validate từng item
                if (empty($item['product_id']) || empty($item['order_id']) || !isset($item['rating'])) {
                    continue;
                }

                $rating = (int) $item['rating'];
                if ($rating < 1 || $rating > 5) {
                    continue;
                }

                // Fix #1: Kiểm tra user đã thực sự mua sản phẩm trong đơn hàng đó
                $validOrder = Order::where('id', $item['order_id'])
                    ->where('user_id', $userId)
                    ->whereIn('status', [OrderStatus::SHIPPED->value, OrderStatus::SHIPPING->value, OrderStatus::COMPLETED->value])
                    ->whereHas('orderDetails', function ($q) use ($item) {
                        $q->where('product_id', $item['product_id']);
                    })
                    ->exists();

                if (!$validOrder) {
                    continue; // Bỏ qua review gian lận
                }

                // Tránh review trùng (1 sản phẩm / 1 đơn hàng)
                $alreadyReviewed = Review::where('user_id', $userId)
                    ->where('product_id', $item['product_id'])
                    ->where('order_id', $item['order_id'])
                    ->exists();

                if ($alreadyReviewed) {
                    continue;
                }

                Review::create([
                    'user_id'    => $userId,
                    'product_id' => $item['product_id'],
                    'order_id'   => $item['order_id'],
                    'rating'     => $rating,
                    'note'       => $item['note'] ?? null,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Đánh giá sản phẩm thành công',
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
