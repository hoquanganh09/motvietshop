@foreach (session()->get('cart', []) as $item)
    <div class="d-flex align-items-center cart-item" data-key="{{ $item['key'] }}">
        <a class="flex-shrink-0" href="{{ route('client.home.productDetail', $item['id']) }}">
            <img src="{{ $item['thumbnail'] }}" class="bg-body-tertiary rounded" width="110"
                alt="Thumbnail">
        </a>
        <div class="w-100 min-w-0 ps-3">
            <h5 class="d-flex animate-underline mb-2">
                <a class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif d-block fs-sm fw-medium text-truncate animate-target"
                    href="{{ route('client.home.productDetail', $item['id']) }}">
                    {{ $item['name'] }}
                </a>
            </h5>
            <div class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif h6 pb-0 mb-0">{{ formatMoney($item['price']) }}
                @if ($item['is_sale'])
                    <del class="text-body-tertiary fs-xs fw-normal">{{ formatMoney($item['old_price']) }}</del>
                @endif
            </div>
            <div class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif h6 pb-0 mb-0 fs-xs fw-normal">
                <span class="text-body-tertiary">Màu:</span>
                <span>{{ $item['color_label'] }}</span>
            </div>
            <div class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif h6 pb-1 mb-2 fs-xs fw-normal">
                <span class="text-body-tertiary">Size:</span>
                <span>{{ $item['size_name'] }}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="count-input rounded-2">
                    <button data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="button" class="btn-decrement btn btn-icon btn-sm"
                        aria-label="Decrement quantity">
                        <i class="ci-minus"></i>
                    </button>
                    <input data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="number" class="input-quantity-cart form-control form-control-sm" value="{{ $item['quantity'] }}">
                    <button data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="button" class="btn-increment btn btn-icon btn-sm"
                        aria-label="Increment quantity">
                        <i class="ci-plus"></i>
                    </button>
                </div>
                <button data-url="{{ route('client.cart.removeItem', $item['key']) }}" type="button" class="btn-remove-product btn-close fs-sm" data-bs-toggle="tooltip"
                    data-bs-custom-class="tooltip-sm"></button>
            </div>
        </div>
    </div>
@endforeach