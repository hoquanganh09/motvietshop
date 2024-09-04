<?php

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;
use Illuminate\Http\Request;

class UpdateCouponAction
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
    public function handle(array $data, Coupon $coupon)
    {
        return $coupon->update($data);
    }
}