<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use PharIo\Manifest\Url;

class PayOS
{
    private PendingRequest $request;
    const BASE_URL = 'https://api-merchant.payos.vn';

    public function __construct()
    {
        $this->request = Http::baseUrl(self::BASE_URL)->withHeaders([
            'x-client-id' => config('payos.client_id'),
            'x-api-key' => config('payos.api_key'),
        ]);
    }
    public function createOrder(Order $order)
    {
        $orderCode = $order->id + time();
        $cancelUrl = route('client.home.index');
        $des = $order->code;
        $returnUrl = route('client.home.orderSuccess');
        $expiredAt = time() + 86400;
        $sig = "amount=" . $order->total . "&cancelUrl=" . $cancelUrl . "&description=" . $des . "&orderCode=" . $orderCode . "&returnUrl=" . $returnUrl;
        $body = [
            'orderCode' => $orderCode,
            'amount' => $order->total,
            'description' => $des,
            "buyerName" => $order->fullname,
            "buyerPhone" => $order->phone_number,
            "buyerAddress" => $order->address,
            "cancelUrl" => $cancelUrl,
            "returnUrl" => $returnUrl,
            "expiredAt" => $expiredAt,
            "signature" => hash_hmac('sha256', $sig, config('payos.checksum_key')),
        ];

        $result =  $this->request->post('v2/payment-requests', $body)->json();
        \Illuminate\Support\Facades\Log::info(json_encode($result));

        return $result;
    }

    public function getPaymentStatus(string|int $code)
    {
        return $this->request->get('v2/payment-requests/' . $code)->json();
    }
}
