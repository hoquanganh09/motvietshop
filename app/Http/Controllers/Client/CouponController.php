<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $code = $request->input('code');
        session()->put('discount', null);
        $coupon = Coupon::query()
            ->where('code', $code)
            ->active()
            ->first();

        if (!$coupon) {
            return response()->json([
                'message' => 'Mã giảm giá không tồn tại.',
                'order_summary' => view('client.home.common.order_summary')->render(),
            ], 404);
        }
        
        if ($coupon->isExpired()) {
            return response()->json([
                'message' => 'Mã đã hết hạn.',
                'order_summary' => view('client.home.common.order_summary')->render(),
            ], 400);
        }

        if ($coupon->amount <= 0) {
            return response()->json([
                'message' => 'Mã đã hết lượt sử dụng.',
                'order_summary' => view('client.home.common.order_summary')->render(),
            ], 400);
        }

        session()->put('discount', $coupon->toArray());

        return response()->json([
            'message' => 'Áp dụng mã thành công',
            'order_summary' => view('client.home.common.order_summary')->render(),
        ]);
    }
}
