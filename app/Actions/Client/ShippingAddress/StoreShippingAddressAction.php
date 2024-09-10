<?php

namespace App\Actions\Client\ShippingAddress;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreShippingAddressAction
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
        $data['user_id'] = Auth::id();

        if (isset($data['is_default'])) {
            ShippingAddress::where('user_id', $data['user_id'])->update(['is_default' => 0]);
        }

        return ShippingAddress::create($data);
    }
}