<!-- Items -->
<div class="d-flex flex-column gap-3">
    @foreach ($order->orderDetails as $item)
        <div class="d-flex align-items-center">
            <a class="flex-shrink-0" href="{{ route('client.home.productDetail', $item->product->id) }}">
                <img src="{{ $item->product->getThumbnail() }}" width="110" alt="product">
            </a>
            <div class="w-100 min-w-0 ps-2 ps-sm-3">
                <h5 class="d-flex animate-underline mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target"
                        href="{{ route('client.home.productDetail', $item->product->id) }}">{{ $item->product->name }}</a>
                </h5>
                <div class="h6 mb-2">{{ formatMoney($item->price) }}</div>
                <div class="fs-xs">Size: {{ $item->size->name }}</div>
                <div class="fs-xs">Màu sắc: {{ $item->color->label }}</div>
                <div class="fs-xs">Số lượng: {{ $item->quantity }}</div>
            </div>
        </div>
    @endforeach
</div>


<!-- Delivery + Payment info -->
<div class="border-top pt-4">
    <h6>Giao hàng</h6>
    <ul class="list-unstyled fs-sm mb-4">
        <li class="d-flex justify-content-between mb-1">
            Họ và tên:
            <span class="text-body-emphasis fw-medium text-end ms-2">{{ $order->fullname }}</span>
        </li>
        <li class="d-flex justify-content-between mb-1">
            Số điện thoại:
            <span class="text-body-emphasis fw-medium text-end ms-2">{{ $order->phone_number }}</span>
        </li>
        <li class="d-flex justify-content-between">
            Địa chỉ nhận hàng:
            <span class="text-body-emphasis fw-medium text-end ms-2">{{ $order->address }}
        </li>
    </ul>
    <h6>Thanh toán</h6>
    <ul class="list-unstyled fs-sm m-0">
        <li class="d-flex justify-content-between mb-1">
            Phương thức thanh toán:
            <span class="text-body-emphasis fw-medium text-end ms-2">{{ $order->getPaymentMethodLabel() }}</span>
        </li>
        <li class="d-flex justify-content-between mb-1">
            Mã giảm giá: {{ $order->discount_code }}
            <span class="text-body-emphasis fw-medium text-end ms-2">-{{ formatMoney($order->discount ?? 0) }}</span>
        </li>
        <li class="d-flex justify-content-between">
            Vận chuyển:
            <span class="text-body-emphasis fw-medium text-end ms-2">{{ formatMoney(0) }}</span>
        </li>
    </ul>
</div>

<!-- Total -->
<div class="d-flex align-items-center justify-content-between fs-sm border-top pt-4">
    Thành tiền:
    <span class="h5 text-end ms-2 mb-0">{{ formatMoney($order->total) }}</span>
</div>
