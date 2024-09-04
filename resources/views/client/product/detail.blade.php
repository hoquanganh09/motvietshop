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
            <li class="breadcrumb-item"><a href="shop-catalog-fashion.html">Cửa hàng</a></li>
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
                    <button type="button"
                        class="btn btn-icon btn-secondary animate-pulse fs-lg bg-transparent border-0 position-absolute top-0 end-0 z-2 mt-2 mt-sm-3 me-2 me-sm-3"
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
                            <img loading="lazy" src="{{ $product->getThumbnail() }}" alt="Image">
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
                            <i class="ci-star-filled text-warning"></i>
                            <i class="ci-star-filled text-warning"></i>
                            <i class="ci-star-filled text-warning"></i>
                            <i class="ci-star-filled text-warning"></i>
                            <i class="ci-star text-body-tertiary opacity-75"></i>
                        </div>
                        <span class="text-body-tertiary fs-sm">23 reviews</span>
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
                                <input data-label="{{ $color->color->label }}" name="color" type="radio" class="btn-check" value="{{ $color->color_id }}"
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
                            <input name="quantity" type="number" class="form-control form-control-lg" min="1" value="1"
                                readonly="">
                            <button type="button" class="btn btn-icon btn-lg" data-increment=""
                                aria-label="Increment quantity">
                                <i class="ci-plus"></i>
                            </button>
                        </div>
                        <button @if($product->sizes->count() == 0 || $product->colors->count() == 0) disabled @endif data-url="{{ route('client.cart.addToCart', $product->id) }}" type="button"
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
                        <span class="fw-medium text-dark-emphasis me-2">🔥 Hurry up! The sale is coming to an
                            end</span>
                        <span><span class="fw-medium text-dark-emphasis">6</span> items in stock!</span>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Left in stock" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                        <div class="progress-bar rounded-pill" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky product preview + Add to cart CTA -->
    <section class="sticky-product-banner sticky-top" data-sticky-element="">
        <div class="sticky-product-banner-inner pt-5">
            <div class="navbar container flex-nowrap align-items-center bg-body pt-4 pt-lg-5 mt-lg-n2">
                <div class="d-flex align-items-center min-w-0 ms-lg-2 me-3">
                    <div class="ratio ratio-1x1 flex-shrink-0" style="width: 50px">
                        <img loading="lazy" src="{{ $product->getThumbnail() }}" alt="Image">
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
                    <button type="button" class="btn btn-dark ms-auto d-none d-md-inline-flex px-4">
                        Thêm vào giỏ hàng
                    </button>
                    <button type="button" class="btn btn-icon btn-dark animate-slide-end ms-auto d-md-none"
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
                    Đánh giá<span class="d-none d-md-inline">&nbsp;(23)</span>
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
                            <h6>Delivery</h6>
                            <p>We strive to deliver your denim midi skirt with pockets to you as quickly as possible.
                                Our estimated delivery times are as follows:</p>
                            <ul class="list-unstyled">
                                <li>Standard delivery: <span class="text-dark-emphasis fw-semibold">Within 3-7 business
                                        days</span></li>
                                <li>Express delivery: <span class="text-dark-emphasis fw-semibold">Within 1-3 business
                                        days</span></li>
                            </ul>
                            <p>Please note that delivery times may vary depending on your location and any ongoing
                                promotions or holidays. You can track your order using the provided tracking number once
                                your package has been dispatched.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="ps-lg-2 ps-xl-3">
                            <h6>Returns</h6>
                            <p>We want you to be completely satisfied with your denim midi skirt with pockets. If for
                                any reason you are not happy with your purchase, you can return it within 30 days of
                                receiving your order for a full refund or exchange.</p>
                            <p>To be eligible for a return, the skirt must be unused, unwashed, and in its original
                                condition with tags attached. Please ensure that all packaging is intact when returning
                                the item.</p>
                            <p class="mb-0">To initiate a return, please contact our customer service team with your
                                order number and reason for the return. We will provide you with a return shipping label
                                and instructions on how to proceed. Please note that shipping fees are non-refundable.
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
                        <h2 class="h5 pb-2 mb-1">Customer reviews</h2>
                        <div class="d-flex align-items-center text-body-secondary fs-sm">
                            <div class="d-flex gap-1 me-2">
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star text-body-tertiary opacity-75"></i>
                            </div>
                            Based on 23 reviews
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-dark mb-3" data-bs-toggle="modal"
                        data-bs-target="#reviewForm">Leave a review</button>
                </div>

                <!-- Review -->
                <div class="border-bottom py-4">
                    <div class="row py-sm-2">
                        <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                            <div class="d-flex h6 mb-2">
                                Rafael Marquez
                                <i class="ci-check-circle text-success mt-1 ms-2" data-bs-toggle="tooltip"
                                    data-bs-custom-class="tooltip-sm" title="Verified customer"></i>
                            </div>
                            <div class="fs-sm mb-2 mb-md-3">June 25, 2024</div>
                            <div class="d-flex gap-1 fs-sm">
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <p class="mb-md-4">Absolutely love this chair! It's exactly what I was looking for to
                                complete my Scandinavian-themed living room. The wooden legs add a touch of warmth and
                                the design is timeless. Comfortable and sturdy, couldn't be happier with my purchase!
                            </p>
                            <div class="d-sm-flex justify-content-between">
                                <div
                                    class="d-flex align-items-center fs-sm fw-medium text-dark-emphasis pb-2 pb-sm-0 mb-1 mb-sm-0">
                                    <i class="ci-check fs-base me-1" style="margin-top: .125rem"></i>
                                    Yes, I recommend this product
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="fs-sm fw-medium text-dark-emphasis me-1">Helpful?</div>
                                    <button type="button" class="btn btn-sm btn-secondary">
                                        <i class="ci-thumbs-up fs-sm ms-n1 me-1"></i>
                                        0
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review -->
                <div class="border-bottom py-4">
                    <div class="row py-sm-2">
                        <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                            <div class="d-flex h6 mb-2">
                                Bessie Cooper
                                <i class="ci-check-circle text-success mt-1 ms-2" data-bs-toggle="tooltip"
                                    data-bs-custom-class="tooltip-sm" title="Verified customer"></i>
                            </div>
                            <div class="fs-sm mb-2 mb-md-3">April 8, 2024</div>
                            <div class="d-flex gap-1 fs-sm">
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star text-body-tertiary opacity-75"></i>
                                <i class="ci-star text-body-tertiary opacity-75"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <p class="mb-md-4">While the design of the chair is nice and it does add a touch of retro
                                vibe to my space, I found the quality to be lacking. After just a few weeks of use, one
                                of the legs started to wobble, and the seat isn't as comfortable as I had hoped.
                                Disappointed with the durability. Additionally, the assembly process was a bit
                                frustrating as some of the screws didn't align properly with the holes, requiring extra
                                effort to secure them in place. Overall, while it looks good, I expected better quality
                                for the price.</p>
                            <div class="d-sm-flex justify-content-between">
                                <div
                                    class="d-flex align-items-center fs-sm fw-medium text-dark-emphasis pb-2 pb-sm-0 mb-1 mb-sm-0">
                                    <i class="ci-close fs-base me-1" style="margin-top: .125rem"></i>
                                    No, I don't recommend this product
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="fs-sm fw-medium text-dark-emphasis me-1">Helpful?</div>
                                    <button type="button" class="btn btn-sm btn-secondary">
                                        <i class="ci-thumbs-up fs-sm ms-n1 me-1"></i>
                                        3
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review -->
                <div class="border-bottom py-4">
                    <div class="row py-sm-2">
                        <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                            <div class="d-flex h6 mb-2">Savannah Nguyen</div>
                            <div class="fs-sm mb-2 mb-md-3">March 30, 2024</div>
                            <div class="d-flex gap-1 fs-sm">
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star text-body-tertiary opacity-75"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <p class="mb-md-4">Great addition to our dining room! The chair looks fantastic and is
                                quite comfortable for short sits. Assembly was a breeze, and the quality seems decent
                                for the price. Overall, satisfied with the purchase.</p>
                            <div class="d-sm-flex justify-content-between">
                                <div
                                    class="d-flex align-items-center fs-sm fw-medium text-dark-emphasis pb-2 pb-sm-0 mb-1 mb-sm-0">
                                    <i class="ci-check fs-base me-1" style="margin-top: .125rem"></i>
                                    Yes, I recommend this product
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="fs-sm fw-medium text-dark-emphasis me-1">Helpful?</div>
                                    <button type="button" class="btn btn-sm btn-secondary">
                                        <i class="ci-thumbs-up fs-sm ms-n1 me-1"></i>
                                        7
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review -->
                <div class="border-bottom py-4">
                    <div class="row py-sm-2">
                        <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                            <div class="d-flex h6 mb-2">Daniel Adams</div>
                            <div class="fs-sm mb-2 mb-md-3">March 16, 2024</div>
                            <div class="d-flex gap-1 fs-sm">
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <p class="mb-md-4">Couldn't be happier with this chair! It's not only stylish but also
                                incredibly comfortable. The size is perfect for our space, and the wooden legs feel
                                sturdy. Definitely recommend it to anyone looking for a chic and functional seating
                                option.</p>
                            <div class="d-sm-flex justify-content-between">
                                <div
                                    class="d-flex align-items-center fs-sm fw-medium text-dark-emphasis pb-2 pb-sm-0 mb-1 mb-sm-0">
                                    <i class="ci-check fs-base me-1" style="margin-top: .125rem"></i>
                                    Yes, I recommend this product
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="fs-sm fw-medium text-dark-emphasis me-1">Helpful?</div>
                                    <button type="button" class="btn btn-sm btn-secondary">
                                        <i class="ci-thumbs-up fs-sm ms-n1 me-1"></i>
                                        14
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review -->
                <div class="border-bottom py-4">
                    <div class="row py-sm-2">
                        <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                            <div class="d-flex h6 mb-2">Kristin Watson</div>
                            <div class="fs-sm mb-2 mb-md-3">February 7, 2024</div>
                            <div class="d-flex gap-1 fs-sm">
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star text-body-tertiary opacity-75"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9">
                            <p class="mb-md-4">The chair is nice, but it's not the most comfortable for extended
                                periods of sitting. The wooden legs give it a nice aesthetic, but they seem a bit
                                fragile. It's a decent chair for occasional use, but I wouldn't recommend it for daily
                                use or long sitting sessions.</p>
                            <div class="d-sm-flex justify-content-between">
                                <div
                                    class="d-flex align-items-center fs-sm fw-medium text-dark-emphasis pb-2 pb-sm-0 mb-1 mb-sm-0">
                                    <i class="ci-check fs-base me-1" style="margin-top: .125rem"></i>
                                    Yes, I recommend this product
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="fs-sm fw-medium text-dark-emphasis me-1">Helpful?</div>
                                    <button type="button" class="btn btn-sm btn-secondary">
                                        <i class="ci-thumbs-up fs-sm ms-n1 me-1"></i>
                                        9
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav class="mt-3 pt-2 pt-md-3" aria-label="Reviews pagination">
                    <ul class="pagination">
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">
                                1
                                <span class="visually-hidden">(current)</span>
                            </span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#!">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#!">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#!">4</a>
                        </li>
                        <li class="page-item">
                            <span class="page-link pe-none">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#!">6</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <!-- Viewed products (carousel) -->
    <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4 mt-xl-5">
        <div class="d-flex align-items-center justify-content-between pt-1 pt-lg-0 pb-3 mb-2 mb-sm-3">
            <h2 class="mb-0 me-3">Sản phẩm đã xem</h2>

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

                $('.add-to-cart').click(function(e) {
                    const url = $(this).data('url');
                    const data = {
                        color: $('[name="color"]:checked').val(),
                        size: sizeEl.val(),
                        quantity: quantityEl.val()
                    };

                    if (!data.size) {
                        toast('Vui lý chọn size', 'warning');
                        return;
                    }

                    ajax(url, 'post', data, function (res) {
                        cartEl.find('.offcanvas-body').html(res.data.body);
                        cartEl.find('.offcanvas-footer').html(res.data.footer);
                        $('[data-bs-target="#shoppingCart"] > span').html(res.data.count);

                        toast(res.data.message, 'success', {
                            timer: 1000,
                        });
                    });
                });

                // change color
                colorEl.on('change', function () {
                    const parent = $(this).closest('.color-container');
                    parent.find('.form-label').html($(this).dataset('label'));
                });
            });
        </script>
    @endpush
</x-client.layout.home>
