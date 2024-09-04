<?php

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CreateCouponAction
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
    public function handle(array $data)
    {
        $data['code'] = strtoupper($data['code']);
        Coupon::create($data);
    }
}