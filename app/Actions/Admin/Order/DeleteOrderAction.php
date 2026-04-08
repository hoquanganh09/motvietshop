<?php

namespace App\Actions\Admin\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteOrderAction
{
    public function handle(Order $order): bool
    {
        DB::beginTransaction();

        try {
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
