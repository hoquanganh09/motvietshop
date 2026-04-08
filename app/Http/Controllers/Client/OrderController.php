<?php

namespace App\Http\Controllers\Client;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Order\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PayOS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        try {
            $order = $orderService->placeOrder($request->validated());
        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage());
        }

        if (PaymentMethod::Cod->value == $request->input('payment_method')) {
            return to_route('client.home.orderSuccess', [
                'orderCode' => $order->id,
            ]);
        }

        if (PaymentMethod::Online->value == $request->input('payment_method')) {
            $payos = new PayOS();
            $res = $payos->createOrder($order);

            if ($res['code'] == '00') {
                return redirect($res['data']['checkoutUrl']);
            }

            return abort(500);
        }
    }

    public function show(Order $order)
    {
        $order->load(['orderDetails', 'orderDetails.product', 'orderDetails.product.images', 'orderDetails.color', 'orderDetails.size']);

        return response()->json([
            'header' => view('client.modal.common.order_detail_header', compact('order'))->render(),
            'body' => view('client.modal.common.order_detail_body', compact('order'))->render(),
            'footer' => view('client.modal.common.order_detail_footer', compact('order'))->render(),
        ]);
    }

    public function cancel(Order $order)
    {
        if (!$order->canCancel()) {
            return response()->json([
                'message' => 'Không thể hủy đơn hàng',
            ], 400); 
        }

        $order->status = OrderStatus::CANCEL->value;
        $order->save();

        return response()->json([
            'message' => 'Hủy đơn hàng thành công',
            'header' => view('client.modal.common.order_detail_header', compact('order'))->render(),
            'footer' => view('client.modal.common.order_detail_footer', compact('order'))->render(),
        ]);
    }

    public function shipped(Order $order)
    {
        if (!$order->canReview('web')) {
            return response()->json([
                'message' => 'Không thể đổi trạng thái đơn hàng',
            ], 400); 
        }

        $order->status = OrderStatus::SHIPPED->value;
        $order->is_paid = 1;
        $order->save();

        return response()->json([
            'message' => 'Đổi trạng thái đơn hàng thành công',
            'header' => view('client.modal.common.order_detail_header', compact('order'))->render(),
            'footer' => view('client.modal.common.order_detail_footer', compact('order'))->render(),
        ]);
    }

    public function showNeedReviews(Order $order)
    {
        $order->load(['orderDetails', 'reviews', 'orderDetails.product', 'orderDetails.product.images', 'orderDetails.product.kind']);

        return response()->view('client.modal.common.product_review_body', compact('order'));
    }
}
