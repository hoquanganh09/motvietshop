<aside class="col-lg-3">
    <div class="offcanvas-lg offcanvas-start pe-lg-0 pe-xl-4" id="accountSidebar">

        <!-- Header -->
        <div class="offcanvas-header d-lg-block py-3 p-lg-0">
            <div class="d-flex align-items-center">
                <div class="h5 d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle mb-0"
                    style="width: 3rem; height: 3rem">S</div>
                <div class="min-w-0 ps-3">
                    <h5 class="h6 mb-1">{{ auth()->user()->fullname }}</h5>
                </div>
            </div>
            <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas"
                data-bs-target="#accountSidebar" aria-label="Close"></button>
        </div>

        <!-- Body (Navigation) -->
        <div class="offcanvas-body d-block pt-2 pt-lg-4 pb-lg-0">
            <nav class="list-group list-group-borderless">
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-orders.html">
                    <i class="ci-shopping-bag fs-base opacity-75 me-2"></i>
                    Orders
                    <span class="badge bg-primary rounded-pill ms-auto">1</span>
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center pe-none {{ Route::is('client.home.wishlist') ? 'active' : '' }}"
                    href="{{ route('client.home.wishlist') }}">
                    <i class="ci-heart fs-base opacity-75 me-2"></i>
                    Yêu thích
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-payment.html">
                    <i class="ci-credit-card fs-base opacity-75 me-2"></i>
                    Payment methods
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-reviews.html">
                    <i class="ci-star fs-base opacity-75 me-2"></i>
                    My reviews
                </a>
            </nav>
            <h6 class="pt-4 ps-2 ms-1">Manage account</h6>
            <nav class="list-group list-group-borderless">
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('client.home.profile') ? 'active' : '' }}"
                    href="{{ route('client.home.profile') }}">
                    <i class="ci-user fs-base opacity-75 me-2"></i>
                    Personal info
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center"
                    href="account-addresses.html">
                    <i class="ci-map-pin fs-base opacity-75 me-2"></i>
                    Addresses
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center"
                    href="account-notifications.html">
                    <i class="ci-bell fs-base opacity-75 mt-1 me-2"></i>
                    Notifications
                </a>
            </nav>
            <h6 class="pt-4 ps-2 ms-1">Customer service</h6>
            <nav class="list-group list-group-borderless">
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="help-topics-v1.html">
                    <i class="ci-help-circle fs-base opacity-75 me-2"></i>
                    Help center
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center"
                    href="terms-and-conditions.html">
                    <i class="ci-info fs-base opacity-75 me-2"></i>
                    Terms and conditions
                </a>
            </nav>
            <nav class="list-group list-group-borderless pt-3">
                <form action="{{ route('client.auth.logout') }}" method="post">
                    @csrf
                    <a class="btn-logout list-group-item list-group-item-action d-flex align-items-center"
                        href="javascript:void(0)">
                        <i class="ci-log-out fs-base opacity-75 me-2"></i>
                        Đăng xuất
                    </a>
                </form>
            </nav>
        </div>
    </div>
</aside>
@push('js')
    <script>
        $('.btn-logout').on('click', function(e) {
            const form = $(this).closest('form');
            form.submit();
        });
    </script>
@endpush
