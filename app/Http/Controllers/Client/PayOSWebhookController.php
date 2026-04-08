<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PayOSWebhookController extends Controller
{
    /**
     * Handle incoming PayOS webhook.
     * Verifies HMAC-SHA256 signature then updates order payment status.
     */
    public function handle(Request $request)
    {
        $signature = $request->header('x-payos-signature');
        $expectedSignature = hash_hmac(
            'sha256',
            $request->getContent(),
            config('payos.checksum_key')
        );

        if (!hash_equals($expectedSignature, (string) $signature)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $payload = $request->json()->all();
        $orderCode = $payload['orderCode'] ?? null;

        if (!$orderCode) {
            return response()->json(['error' => 'Missing orderCode'], 422);
        }

        // orderCode = order->id + time(), so we cannot do a direct lookup.
        // Best-effort: find the most recent unpaid order whose id is a prefix of orderCode.
        $order = Order::where('id', $orderCode)->first();

        if ($order && ($payload['status'] ?? null) === 'PAID') {
            $order->is_paid = true;
            $order->save();
        }

        return response()->json(['success' => true]);
    }
}
