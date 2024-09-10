@if ($order->canCancel())
    <a class="btn-cancel-order btn btn-lg btn-danger w-100" href="{{ route('client.order.cancel', $order->id) }}">
        Hủy
    </a>
@else
    <button disabled class="btn btn-lg btn-secondary w-100">Hủy</button>
@endif
