@if ($order->canCancel())
    <a class="btn-cancel-order btn btn-lg btn-danger w-100" href="{{ route('client.order.cancel', $order->id) }}">
        Hủy
    </a>
@elseif ($order->canShipped())
    <a href="{{ route('client.order.shipped', $order->id) }}" class="btn-shipped-order btn btn-lg btn-success w-100">Đã
        nhận được hàng</a>
@elseif ($order->canReview('web'))
    <a href="{{ route('client.order.showNeedReviews', $order->id) }}" class="btn-show-review btn btn-lg btn-success w-100">Đánh giá</a>
@else
    <button disabled class="btn btn-lg btn-secondary w-100">Hủy</button>
@endif
