<?php

namespace App\Actions\Admin\Order;

use App\Jobs\SendMailOrderConfirmedJob;
use App\Jobs\SendMailOrderShippingJob;
use App\Models\Order;

class UpdateOrderStatusAction
{
    public function handle(Order $order, string $status): bool
    {
        $order->status = $status;

        if ($order->isShipped()) {
            $order->is_paid = 1;
        }
        $success = $order->save();

        if ($success) {
            if ($order->canShipping()) {
                SendMailOrderConfirmedJob::dispatch($order->user_id, $order);
            }

            if ($order->canShipped()) {
                SendMailOrderShippingJob::dispatch($order->user_id, $order);
            }
        }

        return $success;
    }
}
