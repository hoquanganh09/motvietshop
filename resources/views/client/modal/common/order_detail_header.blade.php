<div>
    <h4 class="offcanvas-title mb-1" id="orderDetailsLabel">Đơn hàng #{{ $order->code }}</h4>
    <span class="d-flex align-items-center fs-sm fw-medium text-body-emphasis">
        <span style="background: {{ $order->getStatusColor() }}" class="rounded-circle p-1 me-2"></span>
        {{ $order->getStatusLabel() }}
    </span>
</div>
<button type="button" class="btn-close mt-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
