@props([
    'class' => 'col mb-2 mb-sm-3 mb-md-0',
    'product',
])
<div class="{{ $class }}">
    <div class="animate-underline hover-effect-opacity">
        <div class="position-relative mb-3">
            @if ($product->isSale())
                <span
                    class="badge text-bg-danger position-absolute top-0 start-0 z-2 mt-2 mt-sm-3 ms-2 ms-sm-3">-{{ $product->getDiscount() }}%</span>
            @endif
            <button type="button" data-url="{{ route('client.wishlist.store', $product->id) }}"
                class="btn-add-to-wishlist btn btn-icon btn-secondary animate-pulse fs-base bg-transparent border-0 position-absolute top-0 end-0 z-2 mt-1 mt-sm-2 me-1 me-sm-2"
                aria-label="Add to Wishlist">
                <i class="ci-heart animate-target"></i>
            </button>
            <a class="d-flex bg-body-tertiary rounded p-3" href="{{ route('client.home.productDetail', $product->id) }}">
                <div class="ratio" style="--cz-aspect-ratio: calc(308 / 274 * 100%)">
                    <img loading="lazy" src="{{ $product->getThumbnail() }}" alt="Image">
                </div>
            </a>
            <div
                class="hover-effect-target position-absolute start-0 bottom-0 w-100 z-2 opacity-0 pb-2 pb-sm-3 px-2 px-sm-3">
                <div class="d-flex align-items-center justify-content-center gap-2 gap-xl-3 bg-body rounded-2 p-2">
                    @for ($i = 0; $i < $product->sizes->count() && $i < 4; $i++)
                        <span class="fs-xs fw-medium text-secondary-emphasis py-1 px-sm-2">
                            {{ $product->sizes[$i]->size->name }}
                        </span>
                    @endfor
                    @if ($product->sizes->count() > 4)
                        <div class="nav">
                            <a class="nav-link fs-xs text-body-tertiary py-1 px-2"
                                href="{{ route('client.home.productDetail', $product->id) }}">
                                +{{ $product->sizes->count() - 4 }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="nav mb-2">
            <a class="nav-link animate-target min-w-0 text-dark-emphasis p-0"
                href="{{ route('client.home.productDetail', $product->id) }}">
                <span class="text-truncate">{{ $product->name }}</span>
            </a>
        </div>
        <div class="h6 mb-2">{{ formatMoney($product->price) }}
            @if ($product->isSale())
                <del class="fs-sm fw-normal text-body-tertiary">{{ formatMoney($product->old_price) }}</del>
            @endif
        </div>
        <div class="position-relative">
            <div class="hover-effect-target fs-xs text-body-secondary opacity-100">
                +{{ $product->colors->count() }} màu
            </div>
            <div class="hover-effect-target d-flex gap-2 position-absolute top-0 start-0 opacity-0">
                @foreach ($product->colors as $color)
                    <input type="radio" class="btn-check" name="name_product-color_{{ $product->id }}"
                        id="product_color_{{ $product->id }}_{{ $color->id }}"
                        @if ($loop->first) checked @endif>
                    <label for="product_color_{{ $product->id }}_{{ $color->id }}" class="btn btn-color fs-base"
                        style="color: {{ $color->color->name }}">
                        <span class="visually-hidden">{{ $color->color->label }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>
@push('js')
    @once
        <script>
            $(() => {
                const timer = 300;
                let clearTimeOut = null;

                $(document).on('click', '.btn-add-to-wishlist', function() {
                    const url = $(this).attr('data-url');

                    if (clearTimeOut != null) {
                        clearTimeout(clearTimeOut);
                        clearTimeOut = null;
                    }

                    clearTimeOut = setTimeout(() => {
                        ajax(url, 'post', {}, function(res) {
                            toast(res.data.message);
                        });
                    }, timer);
                });
            });
        </script>
    @endonce
@endpush
