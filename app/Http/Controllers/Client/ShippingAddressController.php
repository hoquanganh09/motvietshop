<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\ShippingAddress\StoreShippingAddressAction;
use App\Actions\Client\ShippingAddress\UpdateShippingAddressAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ShippingAddress\StoreShippingAddressRequest;
use App\Http\Requests\Client\ShippingAddress\UpdateShippingAddressRequest;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    public function store(StoreShippingAddressRequest $request)
    {
        app()->make(StoreShippingAddressAction::class)->handle($request->validated());

        return response()->json([
            'message' => 'Thêm địa chỉ giao hàng thành công.'
        ]);
    }

    public function update(UpdateShippingAddressRequest $request, ShippingAddress $shippingAddress)
    {
        app()->make(UpdateShippingAddressAction::class)->handle($request->validated(), $shippingAddress);

        return redirect()->back()->with('success', 'Cập nhật địa chỉ giao hàng thành công.');
    }

    public function destroy(ShippingAddress $shippingAddress)
    {
        if ($shippingAddress->isDefault()) {
            ShippingAddress::where('user_id', $shippingAddress->user_id)
                ->where('id', '!=', $shippingAddress->id)
                ->limit(1)
                ->update(['is_default' => 1]);
        }

        $shippingAddress->delete();

        return redirect()->back()->with('success', 'Xóa địa chỉ giao hàng thành công.');
    }
}
