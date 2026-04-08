<x-client.layout.home>
    @push('plugin-css')
        <link rel="stylesheet" href="{{ asset('plugins/glightbox/glightbox.min.css') }}">
    @endpush
    @push('plugin-js')
        <script src="{{ asset('plugins/glightbox/glightbox.min.js') }}"></script>
    @endpush

    <nav class="container pt-2 pt-xxl-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.home.shop') }}">Cửa hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thông tin sản phẩm</li>
        </ol>
    </nav>

    <!-- Product gallery and details -->
    <section class="container">
        <div class="row">
            <div class="col-md-6 pb-4 pb-md-0 mb-2 mb-sm-3 mb-md-0">
                <div class="position-relative">
                    <span
                        class="badge text-bg-danger position-absolute top-0 start-0 z-2 mt-3 mt-sm-4 ms-3 ms-sm-4">Sale</span>
                    <button type="button" data-url="{{ route('client.wishlist.store', $product->id) }}"
                        class="btn-add-to-wishlist-2 btn btn-icon btn-secondary animate-pulse fs-lg bg-transparent border-0 position-absolute top-0 end-0 z-2 mt-2 mt-sm-3 me-2 me-sm-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm"
                        data-bs-title="Add to Wishlist" aria-label="Add to Wishlist">
                        <i class="ci-heart animate-target"></i>
                    </button>
                    <a class="hover-effect-scale hover-effect-opacity position-relative d-flex rounded overflow-hidden mb-3 mb-sm-4 mb-md-3 mb-lg-4"
                        href="{{ $product->getThumbnail() }}" data-glightbox="" data-gallery="product-gallery">
                        <i
                            class="ci-zoom-in hover-effect-target fs-3 text-white position-absolute top-50 start-50 translate-middle opacity-0 z-2"></i>
                        <div class="ratio hover-effect-target bg-body-tertiary rounded"
                            style="--cz-aspect-ratio: calc(706 / 636 * 100%)">
                            <img id="productMainThumbnail" loading="lazy" src="{{ $product->getThumbnail() }}" alt="Image">
                        </div>
                    </a>
                </div>
                <div class="collapse d-md-block" id="morePictures">
                    <div class="row row-cols-2 g-3 g-sm-4 g-md-3 g-lg-4 pb-3 pb-sm-4 pb-md-0">
                        @foreach ($product->images->where('is_on_top', 0) as $image)
                            <div class="col">
                                <a class="hover-effect-scale hover-effect-opacity position-relative d-flex rounded overflow-hidden"
                                    href="{{ $image->getImage() }}" data-glightbox="" data-gallery="product-gallery">
                                    <i
                                        class="ci-zoom-in hover-effect-target fs-3 text-white position-absolute top-50 start-50 translate-middle opacity-0 z-2"></i>
                                    <div class="ratio hover-effect-target bg-body-tertiary rounded"
                                        style="--cz-aspect-ratio: calc(342 / 306 * 100%)">
                                        <img loading="lazy" src="{{ $image->getImage() }}" alt="Image">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="btn btn-lg btn-outline-secondary w-100 collapsed d-md-none"
                    data-bs-toggle="collapse" data-bs-target="#morePictures" data-label-collapsed="Hiển thị thêm ảnh"
                    data-label-expanded="Ẩn bớt ảnh" aria-expanded="false" aria-controls="morePictures"
                    aria-label="Show / hide pictures">
                    <i class="collapse-toggle-icon ci-chevron-down fs-lg ms-2 me-n2"></i>
                </button>
            </div>


            <!-- Product details and options -->
            <div class="col-md-6">
                <div class="ps-md-4 ps-xl-5">

                    <!-- Reviews -->
                    <a class="d-none d-md-flex align-items-center gap-2 text-decoration-none mb-3" href="#reviews">
                        <div class="d-flex gap-1 fs-sm">
                            @php
                                $avg = $product->reviews->avg('rating');
                            @endphp
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < round($avg, 0, 2))
                                    <i class="ci-star-filled text-warning"></i>
                                @else
                                    <i class="ci-star text-body-tertiary opacity-75"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-body-tertiary fs-sm">{{ $product->reviews->count() }} đánh giá</span>
                    </a>

                    <!-- Title -->
                    <h1 class="h3">{{ $product->name }}</h1>

                    <div class="h4 d-flex align-items-center my-4">
                        {{ formatMoney($product->price) }}
                        @if ($product->isSale())
                            <del class="fs-sm fw-normal text-body-tertiary ms-2">
                                {{ formatMoney($product->old_price) }}
                            </del>
                        @endif
                    </div>

                    <!-- Color options -->
                    <div class="mb-4 color-container">
                        <label class="form-label fw-semibold pb-1 mb-2">Màu: <span class="text-body fw-normal"
                                id="colorOption">{{ $product->colors->first()?->color->label }}</span>
                        </label>
                        <div class="d-flex flex-wrap gap-2" data-binded-label="#colorOption">
                            @foreach ($product->colors as $color)
                                <input data-label="{{ $color->color->label }}" name="color" type="radio"
                                    class="btn-check" value="{{ $color->color_id }}"
                                    id="product_color_{{ $product->id }}_{{ $color->id }}"
                                    @if ($loop->first) checked @endif>
                                <label for="product_color_{{ $product->id }}_{{ $color->id }}"
                                    class="btn btn-color fs-base" style="color: {{ $color->color->name }}">
                                    <span class="visually-hidden">{{ $color->color->label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Size select -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label fw-semibold mb-0">Size</label>
                            <div class="nav">
                                <a class="nav-link animate-underline fw-normal px-0" href="#sizeGuide"
                                    data-bs-toggle="modal">
                                    <i class="ci-ruler fs-lg me-2"></i>
                                    <span class="animate-target">Size guide</span>
                                </a>
                            </div>
                        </div>
                        <select name="size" class="form-select form-select-lg" aria-label="Material select">
                            <option value="">Chọn một size</option>
                            @foreach ($product->sizes as $size)
                                <option value="{{ $size->size->id }}">
                                    {{ $size->size->number }}
                                    ({{ $size->size->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Count input + Add to cart button -->
                    <div class="d-flex gap-3 pb-3 pb-lg-4 mb-3">
                        <div class="count-input flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-lg" data-decrement=""
                                aria-label="Decrement quantity">
                                <i class="ci-minus"></i>
                            </button>
                            <input data-old_value="1" name="quantity" type="number"
                                class="btn-quantity-detail form-control form-control-lg" min="1"
                                value="1">
                            <button type="button" class="btn btn-icon btn-lg" data-increment=""
                                aria-label="Increment quantity">
                                <i class="ci-plus"></i>
                            </button>
                        </div>
                        <button @if ($product->sizes->count() == 0 || $product->colors->count() == 0) disabled @endif
                            data-url="{{ route('client.cart.addToCart', $product->id) }}" type="button"
                            class="add-to-cart btn btn-lg btn-dark w-100">Thêm vào giỏ hàng</button>
                    </div>

                    <!-- Info list -->
                    <ul class="list-unstyled gap-3 pb-3 pb-lg-4 mb-3">
                        <li class="d-flex flex-wrap fs-sm">
                            <span class="d-flex align-items-center fw-medium text-dark-emphasis me-2">
                                <i class="ci-clock fs-base me-2"></i>
                                Thời gian giao hàng:
                            </span>
                            {{ date('d/m/Y', strtotime('+7 days')) }} -
                            {{ date('d/m/Y', strtotime('+10 days')) }}
                        </li>
                        <li class="d-flex flex-wrap fs-sm">
                            <span class="d-flex align-items-center fw-medium text-dark-emphasis me-2">
                                <i class="ci-delivery fs-base me-2"></i>
                                Miễn phí vận chuyển &amp; trả hàng:
                            </span>
                            Tất cả đơn hàng
                        </li>
                    </ul>

                    <!-- Stock status -->
                    <div class="d-flex flex-wrap justify-content-between fs-sm mb-3">
                        <span class="fw-medium text-dark-emphasis me-2">🔥 Nhanh lên! Chương trình giảm giá đang đến
                            gần</span>
                        <span><span class="fw-medium text-dark-emphasis">{{ $product->stock }}</span> sản phẩm trong
                            kho!</span>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Left in stock" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                        <div class="progress-bar rounded-pill" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky product preview + Add to cart CTA -->
    <section id="customStickyBottomBar" class="fixed-bottom border-top shadow-lg" style="z-index: 1020; background: var(--cz-body-bg); transform: translateY(150%); transition: transform 0.3s ease-in-out;">
        <div class="py-3">
            <div class="navbar container flex-nowrap align-items-center">
                <div class="d-flex align-items-center min-w-0 ms-lg-2 me-3">
                    <div class="ratio ratio-1x1 flex-shrink-0" style="width: 50px">
                        <img id="stickyCartThumbnail" loading="lazy" src="{{ $product->getThumbnail() }}" alt="Image">
                    </div>
                    <h4 class="h6 fw-medium d-none d-lg-block ps-3 mb-0">{{ $product->name }}</h4>
                    <div class="w-100 min-w-0 d-lg-none ps-2">
                        <h4 class="fs-sm fw-medium text-truncate mb-1">{{ $product->name }}</h4>
                        <div class="h6 mb-0">{{ formatMoney($product->price) }}
                            @if ($product->isSale())
                                <del class="fs-xs fw-normal text-body-tertiary">
                                    {{ formatMoney($product->old_price) }}
                                </del>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="h4 d-none d-lg-block mb-0 ms-auto me-4">{{ formatMoney($product->price) }}
                    @if ($product->isSale())
                        <del class="fs-sm fw-normal text-body-tertiary">
                            {{ formatMoney($product->old_price) }}
                        </del>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-icon btn-secondary animate-pulse"
                        aria-label="Add to Wishlist">
                        <i class="ci-heart fs-base animate-target"></i>
                    </button>
                    <button type="button" class="btn-trigger-add-to-cart btn btn-dark ms-auto d-none d-md-inline-flex px-4">
                        Thêm vào giỏ hàng
                    </button>
                    <button type="button" class="btn-trigger-add-to-cart btn btn-icon btn-dark animate-slide-end ms-auto d-md-none"
                        aria-label="Thêm vào giỏ hàng">
                        <i class="ci-shopping-cart fs-base animate-target"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Product details tabs -->
    <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4 mt-xl-5">
        <ul class="nav nav-underline flex-nowrap border-bottom" role="tablist">
            <li class="nav-item me-md-1" role="presentation">
                <button type="button" class="nav-link active" id="description-tab" data-bs-toggle="tab"
                    data-bs-target="#description-tab-pane" role="tab" aria-controls="description-tab-pane"
                    aria-selected="true">
                    Mô tả
                </button>
            </li>
            <li class="nav-item me-md-1" role="presentation">
                <button type="button" class="nav-link" id="washing-tab" data-bs-toggle="tab"
                    data-bs-target="#washing-tab-pane" role="tab" aria-controls="washing-tab-pane"
                    aria-selected="false">
                    Hướng dẫn giặt đồ
                </button>
            </li>
            <li class="nav-item me-md-1" role="presentation">
                <button type="button" class="nav-link" id="delivery-tab" data-bs-toggle="tab"
                    data-bs-target="#delivery-tab-pane" role="tab" aria-controls="delivery-tab-pane"
                    aria-selected="false">
                    Giao hàng<span class="d-none d-md-inline">&nbsp;và hoàn tiền</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                    data-bs-target="#reviews-tab-pane" role="tab" aria-controls="reviews-tab-pane"
                    aria-selected="false">
                    Đánh giá<span class="d-none d-md-inline">&nbsp;({{ $reviews->total() }})</span>
                </button>
            </li>
        </ul>

        <div class="tab-content pt-4 mt-sm-1 mt-md-3">
            <!-- Description tab -->
            <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel"
                aria-labelledby="description-tab">
                {!! $product->description !!}
            </div>

            <!-- Washing instructions tab -->
            <div class="tab-pane fade fs-sm" id="washing-tab-pane" role="tabpanel" aria-labelledby="washing-tab">
                {!! $product->getWashingInstructions() !!}
            </div>

            <!-- Delivery and returns tab -->
            <div class="tab-pane fade fs-sm" id="delivery-tab-pane" role="tabpanel" aria-labelledby="delivery-tab">
                <div class="row row-cols-1 row-cols-md-2">
                    <div class="col mb-3 mb-md-0">
                        <div class="pe-lg-2 pe-xl-3">
                            <h6>Giao hàng</h6>
                            <p>Thời gian giao hàng ước tính của chúng tôi như sau:</p>
                            <ul class="list-unstyled">
                                <li>Nội thành: <span class="text-dark-emphasis fw-semibold">1-2 ngày</span></li>
                                <li>Ngoại thành: <span class="text-dark-emphasis fw-semibold">5-7 ngày</span></li>
                            </ul>
                            <p>Xin lưu ý rằng thời gian giao hàng có thể thay đổi tùy thuộc vào vị trí của bạn và mọi
                                hoạt động đang diễn ra.
                                chương trình khuyến mãi hoặc ngày lễ. Bạn có thể theo dõi đơn hàng của mình bằng số theo
                                dõi được cung cấp một lần
                                gói hàng của bạn đã được gửi đi.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="ps-lg-2 ps-xl-3">
                            <h6>Trả hàng</h6>
                            <p>Chúng tôi muốn bạn hoàn toàn hài lòng với sản phẩm của mình. Nếu vì
                                bất kỳ lý do gì bạn không hài lòng với giao dịch mua hàng của mình, bạn có thể trả lại
                                trong vòng 30 ngày kể từ ngày
                                nhận được đơn đặt hàng của bạn để được hoàn lại tiền đầy đủ hoặc trao đổi.</p>
                            <p>Để đủ điều kiện trả lại, sản phẩm chưa được sử dụng, chưa giặt và còn nguyên trạng
                                tình trạng có thẻ đính kèm. Hãy đảm bảo rằng tất cả bao bì còn nguyên vẹn khi trả lại
                                món đồ.</p>
                            <p class="mb-0">Để bắt đầu hoàn trả, vui lòng liên hệ với nhóm dịch vụ khách hàng của
                                chúng tôi cùng với
                                số thứ tự và lý do trả lại. Chúng tôi sẽ cung cấp cho bạn nhãn vận chuyển trả lại
                                và hướng dẫn cách tiến hành. Xin lưu ý rằng phí vận chuyển sẽ không được hoàn lại.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews tab -->
            <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab">

                <!-- Heading + Add review button -->
                <div class="d-sm-flex align-items-center justify-content-between border-bottom pb-2 pb-sm-3">
                    <div class="mb-3 me-sm-3">
                        <h2 class="h5 pb-2 mb-1">Đánh giá của khách hàng</h2>
                        <div class="d-flex align-items-center text-body-secondary fs-sm">
                            <div class="d-flex gap-1 me-2">
                                @php
                                    $avg = $product->reviews->avg('rating');
                                @endphp
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < round($avg, 0, 2))
                                        <i class="ci-star-filled text-warning"></i>
                                    @else
                                        <i class="ci-star text-body-tertiary opacity-75"></i>
                                    @endif
                                @endfor
                            </div>
                            {{ $avg }}/5 sao dựa trên {{ $reviews->total() }} đánh giá
                        </div>
                    </div>
                </div>

                @foreach ($reviews as $item)
                    <div class="border-bottom py-4">
                        <div class="row py-sm-2">
                            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                                <div class="d-flex h6 mb-2">
                                    {{ $item->user->fullname }}
                                    @if ($item->user->isEmailVerified())
                                        <i class="ci-check-circle text-success mt-1 ms-2" data-bs-toggle="tooltip"
                                            data-bs-custom-class="tooltip-sm" title="Khách hàng đã xác thực"></i>
                                    @endif
                                </div>
                                <div class="fs-sm mb-2 mb-md-3">{{ $item->created_at->format('d/m/Y') }}</div>
                                <div class="d-flex gap-1 fs-sm">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $item->rating)
                                            <i class="ci-star-filled text-warning"></i>
                                        @else
                                            <i class="ci-star text-body-tertiary opacity-75"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <p class="mb-md-4">{{ $item->note }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Pagination -->
                {{ $reviews->links() }}
            </div>
        </div>
    </section>

    <!-- Viewed products (carousel) -->
    <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4 mt-xl-5">
        <div class="d-flex align-items-center justify-content-between pt-1 pt-lg-0 pb-3 mb-2 mb-sm-3">
            <h2 class="mb-0 me-3">Sản phẩm liên quan</h2>

            <!-- Slider prev/next buttons -->
            <div class="d-flex gap-2">
                <button type="button"
                    class="btn btn-icon btn-outline-secondary animate-slide-start rounded-circle me-1" id="viewedPrev"
                    aria-label="Prev">
                    <i class="ci-chevron-left fs-lg animate-target"></i>
                </button>
                <button type="button" class="btn btn-icon btn-outline-secondary animate-slide-end rounded-circle"
                    id="viewedNext" aria-label="Next">
                    <i class="ci-chevron-right fs-lg animate-target"></i>
                </button>
            </div>
        </div>

        <!-- Slider -->
        <div class="swiper"
            data-swiper="{
            &quot;slidesPerView&quot;: 2,
            &quot;spaceBetween&quot;: 24,
            &quot;loop&quot;: true,
            &quot;navigation&quot;: {
              &quot;prevEl&quot;: &quot;#viewedPrev&quot;,
              &quot;nextEl&quot;: &quot;#viewedNext&quot;
            },
            &quot;breakpoints&quot;: {
              &quot;768&quot;: {
                &quot;slidesPerView&quot;: 3
              },
              &quot;992&quot;: {
                &quot;slidesPerView&quot;: 4
              }
            }
          }">
            <div class="swiper-wrapper">
                @foreach ($productVieweds as $item)
                    <x-client.product class="swiper-slide" :product="$item" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recently Viewed products (carousel) -->
    @if($recentlyVieweds && $recentlyVieweds->count() > 0)
    <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4 mt-xl-5">
        <div class="d-flex align-items-center justify-content-between pt-1 pt-lg-0 pb-3 mb-2 mb-sm-3">
            <h2 class="mb-0 me-3">Sản phẩm bạn vừa xem</h2>

            <!-- Slider prev/next buttons -->
            <div class="d-flex gap-2">
                <button type="button"
                    class="btn btn-icon btn-outline-secondary animate-slide-start rounded-circle me-1" id="recentPrev"
                    aria-label="Prev">
                    <i class="ci-chevron-left fs-lg animate-target"></i>
                </button>
                <button type="button" class="btn btn-icon btn-outline-secondary animate-slide-end rounded-circle"
                    id="recentNext" aria-label="Next">
                    <i class="ci-chevron-right fs-lg animate-target"></i>
                </button>
            </div>
        </div>

        <!-- Slider -->
        <div class="swiper"
            data-swiper="{
            &quot;slidesPerView&quot;: 2,
            &quot;spaceBetween&quot;: 24,
            &quot;loop&quot;: false,
            &quot;navigation&quot;: {
              &quot;prevEl&quot;: &quot;#recentPrev&quot;,
              &quot;nextEl&quot;: &quot;#recentNext&quot;
            },
            &quot;breakpoints&quot;: {
              &quot;768&quot;: {
                &quot;slidesPerView&quot;: 3
              },
              &quot;992&quot;: {
                &quot;slidesPerView&quot;: 4
              }
            }
          }">
            <div class="swiper-wrapper">
                @foreach ($recentlyVieweds as $item)
                    <x-client.product class="swiper-slide" :product="$item" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('client.layouts.brands')
    @include('client.modal.size_guide')
    {{-- @include('client.layouts.instagram_feed') --}}
    @push('js')
        <script>
            $(() => {
                const colorEl = $('[name="color"]');
                const quantityEl = $('[name="quantity"]');
                const sizeEl = $('[name="size"]');
                const cartEl = $('#shoppingCart');

                let sourceThumbnail = null;

                $('.add-to-cart').click(function(e) {
                    if (!sourceThumbnail) {
                        sourceThumbnail = $('#productMainThumbnail');
                    }

                    const url = $(this).data('url');
                    const data = {
                        color: $('[name="color"]:checked').val(),
                        size: sizeEl.val(),
                        quantity: quantityEl.val()
                    };

                    if (!data.size) {
                        toast('Vui lý chọn size', 'warning');
                        sourceThumbnail = null;
                        return;
                    }

                    if (quantityEl.val() == '') {
                        toast('Số lượng không hợp lệ', 'warning');
                        sourceThumbnail = null;
                        return;
                    }

                    ajax(url, 'post', data, function(res) {
                        // Flying Cart Animation
                        const cartIcon = $('[data-bs-target="#shoppingCart"]');

                        if (sourceThumbnail.length > 0 && cartIcon.length > 0) {
                            const flyingImg = sourceThumbnail.clone();
                            const flyingImgOffset = sourceThumbnail.offset();
                            const cartIconOffset = cartIcon.offset();

                            flyingImg.css({
                                'position': 'absolute',
                                'z-index': 9999,
                                'top': flyingImgOffset.top,
                                'left': flyingImgOffset.left,
                                'width': sourceThumbnail.width() + 'px',
                                'height': sourceThumbnail.height() + 'px',
                                'opacity': 0.9,
                                'border-radius': '10px',
                                'box-shadow': '0 10px 30px rgba(0,0,0,0.3)',
                                'transition': 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                            }).appendTo('body');

                            setTimeout(() => {
                                flyingImg.css({
                                    'top': cartIconOffset.top + 'px',
                                    'left': cartIconOffset.left + 'px',
                                    'width': '20px',
                                    'height': '20px',
                                    'opacity': 0.2,
                                    'transform': 'scale(0.1)'
                                });
                            }, 20);

                            setTimeout(() => {
                                flyingImg.remove();
                                cartIcon.addClass('animate-shake');
                                setTimeout(() => cartIcon.removeClass('animate-shake'), 500);
                            }, 800);
                        }

                        // reset
                        sourceThumbnail = null;

                        cartEl.find('.offcanvas-body').html(res.data.body);
                        cartEl.find('.offcanvas-footer').html(res.data.footer);
                        $('[data-bs-target="#shoppingCart"] > span').html(res.data.count);

                        toast(res.data.message, 'success', {
                            timer: 1000,
                        });
                    });
                });

                $('.btn-trigger-add-to-cart').click(function(e) {
                    e.preventDefault();
                    if ($('#stickyCartThumbnail').is(':visible')) {
                        sourceThumbnail = $('#stickyCartThumbnail');
                    } else {
                        sourceThumbnail = $('#productMainThumbnail');
                    }
                    $('.add-to-cart').trigger('click');
                });

                // Toggle Custom Sticky Bottom Bar
                const stickyBar = $('#customStickyBottomBar');
                const mainAddToCartBtn = $('.add-to-cart').first();

                $(window).on('scroll', function() {
                    if (mainAddToCartBtn.length) {
                        const btnBottom = mainAddToCartBtn.offset().top + mainAddToCartBtn.outerHeight();
                        if ($(window).scrollTop() > btnBottom) {
                            stickyBar.css('transform', 'translateY(0)');
                        } else {
                            stickyBar.css('transform', 'translateY(150%)');
                        }
                    }
                });

                // change color
                colorEl.on('change', function() {
                    const parent = $(this).closest('.color-container');
                    parent.find('.form-label').html($(this).dataset('label'));
                });
            });

            $(() => {
                const timer = 300;
                let clearTimeOut = null;

                $(document).on('click', '.btn-add-to-wishlist-2', function() {
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

                $(document).on('input', '.btn-quantity-detail', function() {
                    const val = $(this).val();

                    if (val == '') {
                        $(this).val($(this)[0].dataset.old_value);
                    } else {
                        $(this)[0].dataset.old_value = val;
                    }
                });
            });
        </script>
    @endpush
</x-client.layout.home>
