<?php

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;
use Illuminate\Http\Request;

class DestroyCouponAction
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the action.
     */
    public function handle(Coupon $coupon)
    {
        return $coupon->delete();
    }
}