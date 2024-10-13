<x-client.layout.home>
    <nav class="container pt-2 pt-xxl-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.home.shop') }}">Cửa hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        <h1 class="h3 mb-4">Giỏ hàng</h1>
        <div class="row">

            <!-- Items list -->
            <div class="col-lg-8">
                <div class="pe-lg-2 pe-xl-3 me-xl-3">
                    <div class="progress w-100 overflow-visible mb-4" role="progressbar"
                        aria-label="Free shipping progress" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                        style="height: 4px">
                        <div class="progress-bar bg-dark rounded-pill position-relative overflow-visible"
                            style="width: 100%; height: 4px">
                        </div>
                    </div>

                    <!-- Table of items -->
                    <table class="table position-relative z-2 mb-4">
                        <thead>
                            <tr>
                                <th scope="col" class="fs-sm fw-normal py-3 ps-0"><span class="text-body">Sản
                                        phẩm</span></th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-xl-table-cell"><span
                                        class="text-body">Giá tiền</span></th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span
                                        class="text-body">Số lượng</span></th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span
                                        class="text-body">Tổng tiền</span></th>
                                <th scope="col" class="py-0 px-0">
                                    <div class="nav justify-content-end">
                                        <button data-url="{{ route('client.cart.clearCart') }}"
                                            @if (getCartCount() <= 0) disabled @endif type="button"
                                            class="btn-clear-cart nav-link d-inline-block text-decoration-underline text-nowrap py-3 px-0">
                                            Làm mới giỏ hàng
                                        </button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="align-middle cart-items">
                            @include('client.home.common.cart_item')
                        </tbody>
                    </table>

                    <div class="nav position-relative z-2 mb-4 mb-lg-0">
                        <a class="nav-link animate-underline px-0" href="{{ route('client.home.index') }}">
                            <i class="ci-chevron-left fs-lg me-1"></i>
                            <span class="animate-target">Tiếp tục mua hàng</span>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Order summary (sticky sidebar) -->
            <aside class="col-lg-4 cart-summary" style="margin-top: -100px">
                @include('client.home.common.cart_summary')
            </aside>
        </div>
    </section>
    @push('js')
        <script>
            $('.btn-clear-cart').on('click', function() {
                const url = $(this).data('url');

                showConfirm('Bạn có chắc chắn muốn làm mới giỏ hàng?', function() {
                    ajax(url, 'delete', {}, function(res) {
                        $('.cart-summary').html(res.data.cart_summary);
                        $('[data-bs-target="#shoppingCart"] > span').html(res.data.count);
                        $('#shoppingCart .offcanvas-footer').html(res.data.footer);

                        $('.cart-item').remove();
                    });
                });
            });
        </script>
    @endpush
</x-client.layout.home>
