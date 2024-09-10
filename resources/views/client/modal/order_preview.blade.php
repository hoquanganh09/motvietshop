<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="orderPreview" tabindex="-1" aria-labelledby="orderPreviewLabel"
    style="width: 500px">
    <div class="offcanvas-header py-3 pt-lg-4">
        <h4 class="offcanvas-title" id="orderPreviewLabel">Your order</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column gap-3 py-2">

        @foreach (getCart(\App\Enums\CartStatus::NotDisabled) as $item)
            <div class="d-flex align-items-center">
                <a class="position-relative flex-shrink-0" href="{{ route('client.home.productDetail', $item['id']) }}">
                    @if ($item['is_sale'])
                        <span class="badge text-bg-danger position-absolute top-0 start-0">-{{ $item['discount'] }}%</span>
                    @endif
                    <img src="{{ $item['thumbnail'] }}" width="110" alt="san pham">
                </a>
                <div class="w-100 min-w-0 ps-2 ps-sm-3">
                    <h5 class="d-flex animate-underline mb-2">
                        <a class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif d-block fs-sm fw-medium text-truncate animate-target"
                            href="{{ route('client.home.productDetail', $item['id']) }}">{{ $item['name'] }}</a>
                    </h5>
                    <div class="h6 mb-0 @if ($item['disabled'] ?? false) text-decoration-line-through @endif">{{ formatMoney($item['price']) }}
                        @if ($item['is_sale'])
                            <del class="text-body-tertiary fs-xs fw-normal">{{ formatMoney($item['old_price']) }}</del>
                        @endif
                    </div>
                    <div class="fs-xs pt-2 @if ($item['disabled'] ?? false) text-decoration-line-through @endif">Màu sắc: {{ $item['color_label'] }}</div>
                    <div class="fs-xs pt-2 @if ($item['disabled'] ?? false) text-decoration-line-through @endif">Size: {{ $item['size_name'] }}</div>
                    <div class="fs-xs pt-2 @if ($item['disabled'] ?? false) text-decoration-line-through @endif">Số lượng: {{ $item['quantity'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="offcanvas-header">
        <a class="btn btn-lg btn-outline-secondary w-100" href="{{ route('client.cart.showCart') }}">Chỉnh sửa giỏ
            hàng</a>
    </div>
</div>
