<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Coupon\CreateCouponAction;
use App\Actions\Admin\Coupon\DestroyCouponAction;
use App\Actions\Admin\Coupon\GetListCouponAction;
use App\Actions\Admin\Coupon\UpdateCouponAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\CreateCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = app()->make(GetListCouponAction::class)->handle();

        if (request()->ajax()) {
            return response()->view('admin.coupon.table_list', compact('coupons'));
        }

        return view('admin.coupon.index', compact('coupons'));
    }

    public function store(CreateCouponRequest $request)
    {
        $validated = $request->validated();

        app()->make(CreateCouponAction::class)->handle($validated);

        return response()->json([
            'message' => 'Thêm mới mã giảm giá thành công.',
        ]);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $validated = $request->validated();

        app()->make(UpdateCouponAction::class)->handle($validated, $coupon);

        return response()->json([
            'message' => 'Cập nhật mã giảm giá thành công.',
        ]);
    }

    public function edit(Coupon $coupon)
    {
        return response()->view('admin.coupon.modals.edit', compact('coupon'));
    }

    public function destroy(Coupon $coupon)
    {
        app()->make(DestroyCouponAction::class)->handle($coupon);

        return response()->json([
            'message' => 'Xóa mã giảm giá thành công.',
        ]);
    }
}
