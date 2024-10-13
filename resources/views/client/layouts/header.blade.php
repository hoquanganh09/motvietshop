<header class="navbar navbar-expand-lg navbar-sticky bg-body d-block z-fixed p-0"
    data-sticky-navbar="{&quot;offset&quot;: 500}">
    <div class="container py-2 py-lg-3">
        <div class="d-flex align-items-center gap-3">

            <!-- Mobile offcanvas menu toggler (Hamburger) -->
            <button type="button" class="navbar-toggler me-4 me-md-2" data-bs-toggle="offcanvas"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Navbar brand (Logo) -->
        <a class="navbar-brand fs-2 py-0 m-0 me-auto me-sm-n5"
            href="{{ route('client.home.index') }}">
            <img style="height: 80px;" src="{{ getLogo() }}" class="img-fluid" alt="logo">
        </a>

        <!-- Button group -->
        <div class="d-flex align-items-center">

            <!-- Navbar stuck nav toggler -->
            <button type="button" class="navbar-toggler d-none navbar-stuck-show me-3" data-bs-toggle="collapse"
                data-bs-target="#stuckNav" aria-controls="stuckNav" aria-expanded="false"
                aria-label="Toggle navigation in navbar stuck state">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Search toggle button visible on screens < 992px wide (lg breakpoint) -->
            <button type="button"
                class="btn btn-icon btn-lg fs-xl btn-outline-secondary border-0 rounded-circle animate-shake d-lg-none"
                data-bs-toggle="offcanvas" data-bs-target="#searchBox" aria-controls="searchBox"
                aria-label="Toggle search bar">
                <i class="ci-search animate-target"></i>
            </button>

            <!-- Wishlist button visible on screens > 768px wide (md breakpoint) -->
            <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-pulse d-none d-md-inline-flex"
                href="{{ route('client.home.wishlist') }}">
                <i class="ci-heart animate-target"></i>
                <span class="visually-hidden">Yêu thích</span>
            </a>

            <!-- Cart button -->
            <button type="button"
                class="btn btn-icon btn-lg fs-xl btn-outline-secondary position-relative border-0 rounded-circle animate-scale"
                data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart"
                aria-label="Shopping cart">
                <span class="position-absolute top-0 start-100 badge fs-xs text-bg-primary rounded-pill mt-1 ms-n4 z-2"
                    style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em">
                    {{ getCartCount() }}
                </span>
                <i class="ci-shopping-bag animate-target me-1"></i>
            </button>

            @guest
                <!-- Account button visible on screens > 768px wide (md breakpoint) -->
                <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex"
                    href="{{ route('client.auth.login') }}">
                    <i class="ci-log-in animate-target"></i>
                    <span class="visually-hidden">Đăng nhập</span>
                </a>
            @endguest

            @auth
                <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex"
                    href="{{ route('client.home.profile') }}">
                    <i class="ci-user animate-target"></i>
                    <span class="visually-hidden">Tài khoản</span>
                </a>
            @endauth
        </div>
    </div>

    <!-- Main navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
    <div class="collapse navbar-stuck-hide" id="stuckNav">
        <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
            <div class="offcanvas-header py-3">
                <h5 class="offcanvas-title" id="navbarNavLabel">{{ config('app.name') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body pt-1 pb-3 py-lg-0">
                <div class="container pb-lg-2 px-0 px-lg-3">

                    <div class="position-relative d-lg-flex align-items-center justify-content-between">

                        <!-- Navbar nav -->
                        <ul class="navbar-nav position-relative me-xl-n5">
                            <li class="nav-item dropdown pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link {{ Route::is('client.home.index') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('client.home.index') }}" role="button">Trang
                                    Chủ</a>
                            </li>
                            <li class="nav-item dropdown pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link {{ Route::is('client.home.shop') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('client.home.shop') }}" role="button">Cửa
                                    hàng</a>
                            </li>
                            <li class="nav-item dropdown pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link {{ Route::is('client.cart.showCart') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('client.cart.showCart') }}" role="button">Giỏ
                                    hàng</a>
                            </li>
                            @php
                                $activeAccount =
                                    Route::is('client.home.orderHistory') ||
                                    Route::is('client.home.wishlist') ||
                                    Route::is('client.home.profile') ||
                                    Route::is('client.home.addresses') ||
                                    Route::is('client.home.notification')
                                        ? 'active'
                                        : '';
                            @endphp
                            <li class="nav-item dropdown pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link dropdown-toggle {{ $activeAccount }}" aria-current="page"
                                    href="#" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover"
                                    data-bs-auto-close="outside" aria-expanded="false">Tài khoản</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item {{ !Route::is('client.home.orderHistory') ?: 'active' }}"
                                            href="{{ route('client.home.orderHistory') }}">
                                            Lịch sử đơn hàng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ !Route::is('client.home.wishlist') ?: 'active' }}"
                                            href="{{ route('client.home.wishlist') }}">
                                            Yêu thích
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ !Route::is('client.home.profile') ?: 'active' }}"
                                            href="{{ route('client.home.profile') }}">
                                            Thông tin cá nhân
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ !Route::is('client.home.addresses') ?: 'active' }}"
                                            href="{{ route('client.home.addresses') }}">
                                            Địa chỉ nhận hàng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ !Route::is('client.home.notification') ?: 'active' }}"
                                            href="{{ route('client.home.notification') }}">
                                            Thông báo
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('client.auth.logout') }}" method="post">
                                            @csrf
                                            <a class="btn-logout dropdown-item" href="javascript:void(0)">
                                                Đăng xuất
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <!-- Search toggle visible on screens > 991px wide (lg breakpoint) -->
                        <button type="button"
                            class="btn btn-outline-secondary justify-content-start w-100 px-3 mb-lg-2 ms-3 d-none d-lg-inline-flex"
                            style="max-width: 240px" data-bs-toggle="offcanvas" data-bs-target="#searchBox"
                            aria-controls="searchBox">
                            <i class="ci-search fs-base ms-n1 me-2"></i>
                            <span class="text-body-tertiary fw-normal">Tìm kiếm</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Account and Wishlist buttons visible on screens < 768px wide (md breakpoint) -->
            <div class="offcanvas-header border-top px-0 py-3 mt-3 d-md-none">
                <div class="nav nav-justified w-100">
                    @guest
                        <a class="nav-link border-end" href="{{ route('client.auth.login') }}">
                            <i class="ci-log-in fs-lg opacity-60 me-2"></i>
                            Đăng nhập
                        </a>
                    @endguest
                    @auth
                        <a class="nav-link border-end" href="{{ route('client.home.profile') }}">
                            <i class="ci-user fs-lg opacity-60 me-2"></i>
                            Tài khoản
                        </a>
                    @endauth
                    <a class="nav-link" href="{{ route('client.home.wishlist') }}">
                        <i class="ci-heart fs-lg opacity-60 me-2"></i>
                        Yêu thích
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>
