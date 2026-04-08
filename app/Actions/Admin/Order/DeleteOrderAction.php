<?php

namespace App\Actions\Admin\Order;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteOrderAction
{
    public function handle(Order $order): bool
    {
        DB::beginTransaction();

        try {
            // C11: Restore product stock before deleting order details
            $order->load('orderDetails');
            foreach ($order->orderDetails as $detail) {
                Product::where('id', $detail->product_id)->increment('stock', $detail->quantity);
            }

            $order->orderDetails()->delete();
            $order->delete();

            DB::commit();
            
            return true;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            
            return false;
        }
    }
}
