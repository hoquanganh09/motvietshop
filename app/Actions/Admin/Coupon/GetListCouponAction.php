<?php

namespace App\Actions\Admin\Coupon;

use App\Models\Coupon;
use Illuminate\Http\Request;

class GetListCouponAction
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
    public function handle(bool $hasPaginate = true)
    {
        $query = Coupon::query();

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}