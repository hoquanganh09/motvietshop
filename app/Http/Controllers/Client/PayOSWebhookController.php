<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PayOSWebhookController extends Controller
{
    /**
     * Handle incoming PayOS webhook.
     * PayOS signs the webhook body using the same canonical key=value format as outgoing requests.
     * Ref: PayOS documentation — signature covers the `data` object fields sorted alphabetically.
     */
    public function handle(Request $request)
    {
        $payload = $request->json()->all();
        $data = $payload['data'] ?? $payload;

        // Build canonical signature string: sorted key=value pairs (same format PayOS uses)
        $sigFields = ['amount', 'cancelUrl', 'description', 'orderCode', 'returnUrl', 'status'];
        $parts = [];
        foreach ($sigFields as $key) {
            if (isset($data[$key])) {
                $parts[] = $key . '=' . $data[$key];
            }
        }
        $sigString = implode('&', $parts);

        $expectedSignature = hash_hmac('sha256', $sigString, config('payos.checksum_key'));
        $receivedSignature = $payload['signature'] ?? $request->header('x-payos-signature', '');

        if (!hash_equals($expectedSignature, (string) $receivedSignature)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $orderCode = $data['orderCode'] ?? null;
        if (!$orderCode) {
            return response()->json(['error' => 'Missing orderCode'], 422);
        }

        $order = Order::where('payos_order_code', $orderCode)->first();

        if ($order && ($data['status'] ?? null) === 'PAID') {
            $order->is_paid = true;
            $order->save();
        }

        return response()->json(['success' => true]);
    }
}
