<?php

namespace App\Exports;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderExport
{
    public function handle(Order $order)
    {
        $pdf = Pdf::loadView('admin.exports.order_export', compact('order'));

        $filename = now()->format('Y_m_d') . '_order_' . $order->code . '.pdf';

        return  $pdf->stream($filename);
    }
}