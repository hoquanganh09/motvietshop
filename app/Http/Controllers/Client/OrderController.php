<?php

namespace App\Http\Controllers\Client;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
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
        // Fix #4: Chỉ chủ nhân đơn hàng mới được xem
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền thực hiện'], 403);
        }

        $order->load(['orderDetails', 'orderDetails.product', 'orderDetails.product.images', 'orderDetails.color', 'orderDetails.size']);

        return response()->json([
            'header' => view('client.modal.common.order_detail_header', compact('order'))->render(),
            'body' => view('client.modal.common.order_detail_body', compact('order'))->render(),
            'footer' => view('client.modal.common.order_detail_footer', compact('order'))->render(),
        ]);
    }

    public function cancel(Order $order)
    {
        // Fix #4: Chỉ chủ nhân đơn hàng mới được hủy
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền thực hiện'], 403);
        }

        if (!$order->canCancel()) {
            return response()->json([
                'message' => 'Không thể hủy đơn hàng',
            ], 400); 
        }

        // C11: Restore stock for all order items on cancel
        $order->load('orderDetails');

        DB::transaction(function () use ($order) {
            $order->status = OrderStatus::CANCEL->value;
            $order->save();

            foreach ($order->orderDetails as $detail) {
                Product::where('id', $detail->product_id)->increment('stock', $detail->quantity);
            }
        });

        return response()->json([
            'message' => 'Hủy đơn hàng thành công',
            'header' => view('client.modal.common.order_detail_header', compact('order'))->render(),
            'footer' => view('client.modal.common.order_detail_footer', compact('order'))->render(),
        ]);
    }

    public function shipped(Order $order)
    {
        // Fix #4: Chỉ chủ nhân đơn hàng mới được xác nhận nhận hàng
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền thực hiện'], 403);
        }

        if (!$order->canReview('web')) {
            return response()->json([
                'message' => 'Không thể đổi trạng thái đơn hàng',
            ], 400); 
        }

        $order->status = OrderStatus::SHIPPED->value;
        $order->is_paid = 1;
        $order->save();

        return response()->json([
            'message' => 'Đổi trạng thái đơn hàng thành công',
            'header' => view('client.modal.common.order_detail_header', compact('order'))->render(),
            'footer' => view('client.modal.common.order_detail_footer', compact('order'))->render(),
        ]);
    }

    public function showNeedReviews(Order $order)
    {
        // Fix #4: Chỉ chủ nhân được xem danh sách cần đánh giá
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền thực hiện'], 403);
        }

        $order->load(['orderDetails', 'reviews', 'orderDetails.product', 'orderDetails.product.images', 'orderDetails.product.kind']);

        return response()->view('client.modal.common.product_review_body', compact('order'));
    }
}
