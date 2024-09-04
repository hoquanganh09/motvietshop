<x-client.layout.home>
    <div class="container py-5">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('client.home.common.user_sidebar')


            <!-- Wishlist content -->
            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title + Add list button-->
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-1 mb-sm-2 mb-md-3">
                        <h1 class="h2 me-3 mb-0">Sản phẩm yêu thích</h1>
                    </div>

                    <!-- Master checkbox + Action buttons -->
                    <div class="nav align-items-center mb-4">
                        @if ($wishlists->count() > 0)
                            <div class="form-checkl nav-link animate-underline fs-lg ps-0 pe-2 py-2 mt-n1 me-4">
                                <input type="checkbox" class="form-check-input" id="wishlist-master">
                                <label for="wishlist-master" class="form-check-label animate-target mt-1 ms-2">
                                    Chọn tất cả
                                </label>
                            </div>
                            <div class="d-flex flex-wrap">
                                <a id="btn-delete-wishlist" class="nav-link animate-underline px-0 py-2"
                                    href="{{ route('client.wishlist.destroy') }}">
                                    <i class="ci-trash fs-base me-1"></i>
                                    <span class="animate-target d-none d-md-inline">Xóa sản phẩm đã lựa chọn</span>
                                </a>
                            </div>
                        @endif
                    </div>


                    <!-- Wishlist items (Grid) -->
                    <div class="row row-cols-2 row-cols-md-3 g-4" id="wishlistSelection">
                        @foreach ($wishlists as $item)
                            <div class="col">
                                <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                                    <div class="position-relative">
                                        <div class="position-absolute top-0 end-0 z-1 pt-1 pe-1 mt-2 me-2">
                                            <div class="form-check fs-lg">
                                                <input value="{{ $item->product_id }}" name="product_id" type="checkbox"
                                                    class="form-check-input select-card-check">
                                            </div>
                                        </div>
                                        <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                            href="{{ route('client.home.productDetail', $item->product_id) }}">
                                            @if ($item->product->isSale())
                                                <span
                                                    class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">-{{ $item->product->getDiscount() }}%</span>
                                            @endif
                                            <div class="ratio mt-3" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                                <img src="{{ $item->product->getThumbnail() }}" alt="image">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <div class="d-flex gap-1 fs-xs">
                                                <i class="ci-star-filled text-warning"></i>
                                                <i class="ci-star-filled text-warning"></i>
                                                <i class="ci-star-filled text-warning"></i>
                                                <i class="ci-star-filled text-warning"></i>
                                                <i class="ci-star text-body-tertiary opacity-75"></i>
                                            </div>
                                            <span class="text-body-tertiary fs-xs">(123)</span>
                                        </div>
                                        <h3 class="pb-1 mb-2">
                                            <a class="d-block fs-sm fw-medium text-truncate"
                                                href="shop-product-general-electronics.html">
                                                <span class="animate-target">{{ $item->product->name }}</span>
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="h5 lh-1 mb-0">{{ formatMoney($item->product->price) }}
                                                @if ($item->product->isSale())
                                                    <del class="text-body-tertiary fs-sm fw-normal">
                                                        {{ formatMoney($item->product->old_price) }}
                                                    </del>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        {{ $wishlists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(() => {
                const items = $('#wishlistSelection .product-card .select-card-check');

                $('#wishlist-master').on('change', function() {
                    if ($(this).is(':checked')) {
                        items.prop('checked', true);
                    } else {
                        items.prop('checked', false);
                    }
                });

                $('#btn-delete-wishlist').on('click', function(e) {
                    const url = $(this).attr('href');
                    const inputs = $('#wishlistSelection .product-card .select-card-check:checked');
                    const ids = Array.from(inputs).map((item) => item.value);
                    console.log(ids);

                    ajax(url, 'post', {
                        product_id: ids
                    }, function(res) {
                        toast(res.data.message);
                        location.reload();
                    });
                    e.preventDefault();
                });
            });
        </script>
    @endpush
</x-client.layout.home>
