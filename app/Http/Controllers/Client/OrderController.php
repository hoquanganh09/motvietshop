<?php

namespace App\Http\Controllers\Client;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailOrderCreated;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Services\PayOS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = getCart(CartStatus::NotDisabled, 'final_cart');

        if (count($cart) == 0) {
            return back()->with('message', 'Không thể đặt hàng khi không có sản phẩm');
        }

        $discount = getDiscount();
        $data = [
            'user_id' => Auth::id(),
            'fullname' => $request->input('fullname'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'payment_method' => $request->input('payment_method'),
            'note' => $request->input('note'),
            'status' => OrderStatus::PENDING->value,
            'total' => getCartDiscountTotal(CartStatus::NotDisabled, 'final_cart'),
            'code' => Order::generateCode(),
        ];

        DB::beginTransaction();
        try {
            if ($discount) {
                $data = [
                    ...$data,
                    'discount' => getCartDiscount(CartStatus::NotDisabled, 'final_cart'),
                    'discount_code' => $discount['code'],
                ];
                Coupon::query()->where('id', $discount['id'])->limit(1)->decrement('amount');
            }

            $order = Order::create($data);

            foreach ($cart as $item) {
                Product::query()->where('id', $item['id'])->decrement('stock', $item['quantity']);
                $order->orderDetails()->create([
                    'product_id' => $item['id'],
                    'color_id' => $item['color'],
                    'size_id' => $item['size'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            SendMailOrderCreated::dispatch($order->user_id, $order);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        session()->put('cart', []);
        session()->put('final_cart', []);

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
