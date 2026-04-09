<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $status = request()->input('status', '');

        $returns = ReturnRequest::query()
            ->with(['order', 'order.orderDetails', 'user'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.return_request.index', compact('returns', 'status'));
    }

    public function update(Request $request, ReturnRequest $returnRequest)
    {
        $request->validate([
            'status'     => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        if (!$returnRequest->isPending()) {
            return back()->with('error', 'Yêu cầu này đã được xử lý rồi');
        }

        DB::transaction(function () use ($request, $returnRequest) {
            $returnRequest->update([
                'status'     => $request->input('status'),
                'admin_note' => $request->input('admin_note'),
            ]);

            if ($request->input('status') === 'approved') {
                $order = $returnRequest->order->load('orderDetails');

                // Restore stock for every item in the order
                foreach ($order->orderDetails as $detail) {
                    Product::where('id', $detail->product_id)->increment('stock', $detail->quantity);
                }

            }
        });

        return back()->with('success', 'Đã cập nhật trạng thái yêu cầu đổi/trả');
    }
}
