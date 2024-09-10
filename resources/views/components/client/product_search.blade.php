@props(['product'])
<div class="col-md-6 mb-2">
    <div>
        <div class="d-flex align-items-center">
            <a class="position-relative flex-shrink-0" href="{{ route('client.home.productDetail', $product->id) }}">
                @if ($product->isSale())
                    <span
                        class="badge text-bg-danger position-absolute top-0 start-0">{{ $product->getDiscount() }}%</span>
                @endif
                <img src="{{ $product->getThumbnail() }}" width="110" alt="{{ $product->name }}">
            </a>
            <div class="w-100 min-w-0 ps-2 ps-xl-3">
                <h5 class="d-flex animate-underline mb-2">
                    <a class=" d-block fs-sm fw-medium text-truncate animate-target"
                        href="{{ route('client.home.productDetail', $product->id) }}">
                        {{ $product->name }}
                    </a>
                </h5>
                <ul class=" list-unstyled gap-1 fs-xs mb-0">
                    <li>
                        <span class="text-body-secondary">Màu:</span>
                        <span>
                            @foreach ($product->colors as $item)
                                <span class="btn btn-color fs-base" style="color: {{ $item->color->name }}">
                                </span>
                            @endforeach
                        </span>
                    </li>
                    <li>
                        <span class="text-body-secondary">Size:</span>
                        <span>
                            @foreach ($product->sizes as $item)
                                <span class="text-dark-emphasis fw-medium">{{ $item->size->name }}
                                </span>
                            @endforeach
                        </span>
                    </li>
                    <li>
                        <span class="text-body-secondary">
                            Giá tiền:
                        </span>
                        <span class="text-dark-emphasis fw-medium">{{ formatMoney($product->price) }}</span>
                        @if ($product->isSale())
                            <del class="text-body-tertiary fw-normal">{{ formatMoney($product->old_price) }}</del>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
