<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnRequestController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền thực hiện'], 403);
        }

        if (!$order->canReturn()) {
            return response()->json(['message' => 'Đơn hàng không đủ điều kiện yêu cầu đổi/trả'], 400);
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        ReturnRequest::create([
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'reason'   => $request->input('reason'),
            'status'   => 'pending',
        ]);

        return response()->json(['message' => 'Đã gửi yêu cầu đổi/trả thành công']);
    }
}
