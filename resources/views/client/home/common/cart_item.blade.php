@foreach (getCart() as $item)
    <tr class="cart-item" data-key="{{ $item['key'] }}">
        <td class="py-3 ps-0">
            <div class="d-flex align-items-center">
                <a class="position-relative flex-shrink-0" href="{{ route('client.home.productDetail', $item['id']) }}">
                    @if ($item['is_sale'])
                        <span
                            class="badge text-bg-danger position-absolute top-0 start-0">{{ $item['discount'] }}%</span>
                    @endif
                    <img src="{{ $item['thumbnail'] }}" width="110" alt="iPad Pro">
                </a>
                <div class="w-100 min-w-0 ps-2 ps-xl-3">
                    <h5 class="d-flex animate-underline mb-2">
                        <a class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif d-block fs-sm fw-medium text-truncate animate-target"
                            href="{{ route('client.home.productDetail', $item['id']) }}">
                            {{ $item['name'] }}
                        </a>
                    </h5>
                    <ul class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif list-unstyled gap-1 fs-xs mb-0">
                        <li><span class="text-body-secondary">Màu:</span> <span
                                class="text-dark-emphasis fw-medium">{{ $item['color_label'] }}</span>
                        </li>
                        <li><span class="text-body-secondary">Size:</span> <span
                                class="text-dark-emphasis fw-medium">{{ $item['size_name'] }}</span>
                        </li>
                        <li class="d-xl-none"><span class="text-body-secondary">Giá
                                tiền:</span>
                            <span class="text-dark-emphasis fw-medium">{{ formatMoney($item['price']) }}</span>
                            @if ($item['is_sale'])
                                <del class="text-body-tertiary fw-normal">{{ formatMoney($item['old_price']) }}</del>
                            @endif
                            </span>
                        </li>
                    </ul>
                    <div class="count-input rounded-2 d-md-none mt-3">
                        <button data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="button"
                            class="btn-decrement btn btn-sm btn-icon" aria-label="Decrement quantity">
                            <i class="ci-minus"></i>
                        </button>
                        <input data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="number" class="input-quantity-cart form-control form-control-sm" value="{{ $item['quantity'] }}">
                        <button data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="button"
                            class="btn-increment btn btn-sm btn-icon" aria-label="Increment quantity">
                            <i class="ci-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </td>
        <td class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif h6 py-3 d-none d-xl-table-cell">{{ formatMoney($item['price']) }}
            @if ($item['is_sale'])
                <del class="text-body-tertiary fs-xs fw-normal">{{ formatMoney($item['old_price']) }}</del>
            @endif
        </td>
        <td class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif py-3 d-none d-md-table-cell">
            <div class="count-input">
                <button data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="button"
                    class="btn-decrement btn btn-icon" aria-label="Decrement quantity">
                    <i class="ci-minus"></i>
                </button>
                <input data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="number" class="input-quantity-cart form-control" value="{{ $item['quantity'] }}">
                <button data-url="{{ route('client.cart.updateQuantity', $item['key']) }}" type="button"
                    class="btn-increment btn btn-icon" aria-label="Increment quantity">
                    <i class="ci-plus"></i>
                </button>
            </div>
        </td>
        <td class="@if ($item['disabled'] ?? false) text-decoration-line-through @endif h6 py-3 d-none d-md-table-cell">
            {{ formatMoney($item['price'] * $item['quantity']) }}
        </td>
        <td class="text-end py-3 px-0">
            <button data-url="{{ route('client.cart.removeItem', $item['key']) }}" type="button"
                class="btn-remove-product btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm"
                data-bs-title="Remove" aria-label="Remove from cart"></button>
        </td>
    </tr>
@endforeach
@push('js')
    <script>
        $(() => {
            $(document).on('input', '.input-quantity-cart', function() {
                // const url = $(this).attr('data-url');

                // updateQuantity(url, $(this));
            });
        });
    </script>
@endpush