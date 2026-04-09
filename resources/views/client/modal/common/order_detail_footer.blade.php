@if ($order->canCancel())
    <a class="btn-cancel-order btn btn-lg btn-danger w-100" href="{{ route('client.order.cancel', $order->id) }}">
        Hủy
    </a>
@elseif ($order->canShipped())
    <a href="{{ route('client.order.shipped', $order->id) }}" class="btn-shipped-order btn btn-lg btn-success w-100">Đã
        nhận được hàng</a>
@elseif ($order->canReview('web'))
    <div class="d-flex gap-2 w-100">
        <a href="{{ route('client.order.showNeedReviews', $order->id) }}" class="btn-show-review btn btn-lg btn-success flex-grow-1">Đánh giá</a>
    </div>
@elseif ($order->canReturn())
    <button type="button" class="btn btn-lg btn-warning w-100 btn-show-return-form"
        data-order-id="{{ $order->id }}"
        data-url="{{ route('client.returnRequest.store', $order->id) }}">
        <i class="ci-return me-2"></i>Yêu cầu đổi/trả
    </button>
@else
    <button disabled class="btn btn-lg btn-secondary w-100">Hủy</button>
@endif
