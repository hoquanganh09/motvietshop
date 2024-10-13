<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailOrderConfirmedJob;
use App\Jobs\SendMailOrderShippingJob;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $search = request()->input('search', '');
        $paymentMethod = request()->input('payment_method', '');
        $status = request()->input('status', '');

        $orders = Order::search($search)
            ->orderBy('id', 'desc')
            ->with(['user', 'orderDetails'])
            ->when($paymentMethod, function ($query) use ($paymentMethod) {
                $query->where('payment_method', $paymentMethod);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->paginate();

        if (request()->ajax()) {
            return view('admin.order.table_list', compact('orders'));
        }

        $filters = [
            [
                'name' => 'status',
                'label' => 'Trạng thái',
                'data' => [
                    OrderStatus::CANCEL->value => 'Đã hủy',
                    OrderStatus::PENDING->value => 'Chờ xác nhận',
                    OrderStatus::PROCESSING->value => 'Đang xử lý',
                    OrderStatus::SHIPPING->value => 'Đang giao hàng',
                    OrderStatus::SHIPPED->value => 'Đã giao hàng',
                ],
            ],
            [
                'name' => 'payment_method',
                'label' => 'Hình thức thanh toán',
                'data' => [
                    PaymentMethod::Cod->value => 'Thanh toán khi nhận hàng',
                    PaymentMethod::Online->value => 'Thanh toán Online',
                ],
            ]
        ];

        return view('admin.order.index', compact('orders', 'filters'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails.product', 'orderDetails.product.images', 'orderDetails.size', 'orderDetails.color']);

        return view('admin.order.view', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->status = $request->input('status');

        if ($order->isShipped()) {
            $order->is_paid = 1;
        }
        $order->save();

        if ($order->canShipping()) {
            SendMailOrderConfirmedJob::dispatch($order->user_id, $order);
        }

        if ($order->canShipped()) {
            SendMailOrderShippingJob::dispatch($order->user_id, $order);
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    public function destroy(Order $order)
    {
        DB::beginTransaction();

        try {
            $order->orderDetails()->delete();
            $order->delete();

            DB::commit();

            return response()->json([
                'message' => 'Đã xóa đơn hàng thành công',
            ]);
        } catch (\Exception $exception) {
            log($exception->getMessage());
            DB::rollBack();
        }
    }

    public function export(Order $order)
    {
        $order->load([
            'orderDetails',
            'orderDetails.product',
            'orderDetails.color',
            'orderDetails.size',
        ]);

        return (new OrderExport())->handle($order);
    }
}
