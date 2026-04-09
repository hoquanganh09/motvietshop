<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Actions\Admin\Order\UpdateOrderStatusAction;
use App\Actions\Admin\Order\DeleteOrderAction;

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

    public function update(Request $request, Order $order, UpdateOrderStatusAction $updateAction)
    {
        $request->validate([
            'status' => ['required', \Illuminate\Validation\Rule::in(array_column(\App\Enums\OrderStatus::cases(), 'value'))],
        ]);

        $success = $updateAction->handle($order, $request->input('status'));

        return redirect()->back()->with($success ? 'success' : 'error', $success ? 'Cập nhật trạng thái đơn hàng thành công' : 'Cập nhật thất bại');
    }

    public function destroy(Order $order, DeleteOrderAction $deleteAction)
    {
        $success = $deleteAction->handle($order);

        if ($success) {
            return response()->json([
                'message' => 'Đã xóa đơn hàng thành công',
            ]);
        }
        
        return response()->json(['message' => 'Xóa thất bại'], 400);
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

    public function exportAll()
    {
        $orders = Order::query()
            ->with(['user', 'orderDetails'])
            ->orderBy('id', 'desc')
            ->get();

        $filename = 'don-hang-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Mã đơn', 'Khách hàng', 'SĐT', 'Địa chỉ', 'Tổng tiền', 'Thanh toán', 'Trạng thái', 'Ngày đặt']);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->code,
                    $order->user?->fullname ?? $order->fullname,
                    $order->phone_number,
                    $order->address,
                    $order->total,
                    $order->getPaymentMethodLabel(),
                    $order->getStatusLabel(),
                    $order->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
