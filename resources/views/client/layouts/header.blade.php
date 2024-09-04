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
            href="{{ route('client.home.index') }}">{{ config('app.name') }}</a>

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
                    href="account-signin.html">
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
                <h5 class="offcanvas-title" id="navbarNavLabel">Browse Cartzilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body pt-1 pb-3 py-lg-0">
                <div class="container pb-lg-2 px-0 px-lg-3">

                    <div class="position-relative d-lg-flex align-items-center justify-content-between">

                        <!-- Navbar nav -->
                        {{-- <ul class="navbar-nav position-relative me-xl-n5">
                            <li class="nav-item dropdown pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link dropdown-toggle active" aria-current="page" href="#"
                                    role="button" data-bs-toggle="dropdown" data-bs-trigger="hover"
                                    aria-expanded="false">Home</a>
                                <ul class="dropdown-menu" style="--cz-dropdown-spacer: .75rem">
                                    <li class="hover-effect-opacity px-2 mx-n2">
                                        <a class="dropdown-item d-block mb-0" href="home-electronics.html">
                                            <span class="fw-medium">Electronics Store</span>
                                            <span class="d-block fs-xs text-body-secondary">Megamenu + Hero
                                                slider</span>
                                            <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                                style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                                <img class="position-relative z-2 d-none-dark"
                                                    src="assets/img/mega-menu/demo-preview/electronics-light.jpg"
                                                    alt="Electronics Store">
                                                <img class="position-relative z-2 d-none d-block-dark"
                                                    src="assets/img/mega-menu/demo-preview/electronics-dark.jpg"
                                                    alt="Electronics Store">
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                    style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                    style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="hover-effect-opacity px-2 mx-n2">
                                        <a class="dropdown-item d-block mb-0" href="home-fashion-v1.html">
                                            <span class="fw-medium">Fashion Store v.1</span>
                                            <span class="d-block fs-xs text-body-secondary">Hero promo
                                                slider</span>
                                            <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                                style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                                <img class="position-relative z-2 d-none-dark"
                                                    src="assets/img/mega-menu/demo-preview/fashion-1-light.jpg"
                                                    alt="Fashion Store v.1">
                                                <img class="position-relative z-2 d-none d-block-dark"
                                                    src="assets/img/mega-menu/demo-preview/fashion-1-dark.jpg"
                                                    alt="Fashion Store v.1">
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                    style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                    style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="hover-effect-opacity px-2 mx-n2">
                                        <a class="dropdown-item d-block mb-0" href="home-fashion-v2.html">
                                            <span class="fw-medium">Fashion Store v.2</span>
                                            <span class="d-block fs-xs text-body-secondary">Hero banner with
                                                hotspots</span>
                                            <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                                style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                                <img class="position-relative z-2 d-none-dark"
                                                    src="assets/img/mega-menu/demo-preview/fashion-2-light.jpg"
                                                    alt="Fashion Store v.2">
                                                <img class="position-relative z-2 d-none d-block-dark"
                                                    src="assets/img/mega-menu/demo-preview/fashion-2-dark.jpg"
                                                    alt="Fashion Store v.2">
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                    style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                    style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="hover-effect-opacity px-2 mx-n2">
                                        <a class="dropdown-item d-block mb-0" href="home-furniture.html">
                                            <span class="fw-medium">Furniture Store</span>
                                            <span class="d-block fs-xs text-body-secondary">Fancy product
                                                carousel</span>
                                            <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                                style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                                <img class="position-relative z-2 d-none-dark"
                                                    src="assets/img/mega-menu/demo-preview/furniture-light.jpg"
                                                    alt="Furniture Store">
                                                <img class="position-relative z-2 d-none d-block-dark"
                                                    src="assets/img/mega-menu/demo-preview/furniture-dark.jpg"
                                                    alt="Furniture Store">
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                    style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                    style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="hover-effect-opacity px-2 mx-n2">
                                        <a class="dropdown-item d-block mb-0" href="home-grocery.html">
                                            <span class="fw-medium">Grocery Store</span>
                                            <span class="d-block fs-xs text-body-secondary">Hero slider + Category
                                                cards</span>
                                            <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                                style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                                <img class="position-relative z-2 d-none-dark"
                                                    src="assets/img/mega-menu/demo-preview/grocery-light.jpg"
                                                    alt="Grocery Store">
                                                <img class="position-relative z-2 d-none d-block-dark"
                                                    src="assets/img/mega-menu/demo-preview/grocery-dark.jpg"
                                                    alt="Grocery Store">
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                    style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                                <span
                                                    class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                    style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown position-static pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">Shop</a>
                                <div class="dropdown-menu p-4" style="--cz-dropdown-spacer: .75rem">
                                    <div class="d-flex flex-column flex-lg-row gap-4">
                                        <div style="min-width: 190px">
                                            <div class="h6 mb-2">Electronics Store</div>
                                            <ul class="nav flex-column gap-2 mt-0">
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-categories-electronics.html">Categories
                                                        Page</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-catalog-electronics.html">Catalog with Side
                                                        Filters</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-product-general-electronics.html">Product
                                                        General Info</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-product-details-electronics.html">Product
                                                        Details</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-product-reviews-electronics.html">Product
                                                        Reviews</a>
                                                </li>
                                            </ul>
                                            <div class="h6 pt-4 mb-2">Fashion Store</div>
                                            <ul class="nav flex-column gap-2 mt-0">
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-catalog-fashion.html">Catalog with Side
                                                        Filters</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-product-fashion.html">Product Page</a>
                                                </li>
                                            </ul>
                                            <div class="h6 pt-4 mb-2">Furniture Store</div>
                                            <ul class="nav flex-column gap-2 mt-0">
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-catalog-furniture.html">Catalog with Top
                                                        Filters</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-product-furniture.html">Product Page</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div style="min-width: 190px">
                                            <div class="h6 mb-2">Grocery Store</div>
                                            <ul class="nav flex-column gap-2 mt-0">
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-catalog-grocery.html">Catalog with Side
                                                        Filters</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="shop-product-grocery.html">Product Page</a>
                                                </li>
                                            </ul>
                                            <div class="h6 pt-4 mb-2">Checkout v.1</div>
                                            <ul class="nav flex-column gap-2 mt-0">
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v1-cart.html">Shopping Cart</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v1-delivery-1.html">Delivery Info (Step
                                                        1)</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v1-delivery-2.html">Delivery Info (Step
                                                        2)</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v1-shipping.html">Shipping Address</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v1-payment.html">Payment</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v1-thankyou.html">Thank You Page</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div style="min-width: 190px">
                                            <div class="h6 mb-2">Checkout v.2</div>
                                            <ul class="nav flex-column gap-2 mt-0">
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v2-cart.html">Shopping Cart</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v2-delivery.html">Delivery Info</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v2-pickup.html">Pickup from Store</a>
                                                </li>
                                                <li class="d-flex w-100 pt-1">
                                                    <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                        href="checkout-v2-thankyou.html">Thank You Page</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-auto-close="outside"
                                    aria-expanded="false">Account</a>
                                <ul class="dropdown-menu" style="--cz-dropdown-spacer: .75rem">
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#!" role="button"
                                            data-bs-toggle="dropdown" data-bs-trigger="hover"
                                            aria-expanded="false">Auth Pages</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="account-signin.html">Sign In</a>
                                            </li>
                                            <li><a class="dropdown-item" href="account-signup.html">Sign Up</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="account-password-recovery.html">Password Recovery</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="account-orders.html">Orders History</a>
                                    </li>
                                    <li><a class="dropdown-item" href="account-wishlist.html">Wishlist</a></li>
                                    <li><a class="dropdown-item" href="account-payment.html">Payment Methods</a>
                                    </li>
                                    <li><a class="dropdown-item" href="account-reviews.html">My Reviews</a></li>
                                    <li><a class="dropdown-item" href="account-info.html">Personal Info</a></li>
                                    <li><a class="dropdown-item" href="account-addresses.html">Addresses</a>
                                    </li>
                                    <li><a class="dropdown-item" href="account-notifications.html">Notifications</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown pb-lg-2 me-lg-n1 me-xl-0">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-auto-close="outside"
                                    aria-expanded="false">Pages</a>
                                <ul class="dropdown-menu" style="--cz-dropdown-spacer: .75rem">
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#!" role="button"
                                            data-bs-toggle="dropdown" data-bs-trigger="hover"
                                            aria-expanded="false">About</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="about-v1.html">About v.1</a></li>
                                            <li><a class="dropdown-item" href="about-v2.html">About v.2</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#!" role="button"
                                            data-bs-toggle="dropdown" data-bs-trigger="hover"
                                            aria-expanded="false">Blog</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="blog-grid-v1.html">Grid View
                                                    v.1</a></li>
                                            <li><a class="dropdown-item" href="blog-grid-v2.html">Grid View
                                                    v.2</a></li>
                                            <li><a class="dropdown-item" href="blog-list.html">List View</a>
                                            </li>
                                            <li><a class="dropdown-item" href="blog-single-v1.html">Single Post
                                                    v.1</a></li>
                                            <li><a class="dropdown-item" href="blog-single-v2.html">Single Post
                                                    v.2</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#!" role="button"
                                            data-bs-toggle="dropdown" data-bs-trigger="hover"
                                            aria-expanded="false">Contact</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="contact-v1.html">Contact v.1</a>
                                            </li>
                                            <li><a class="dropdown-item" href="contact-v2.html">Contact v.2</a>
                                            </li>
                                            <li><a class="dropdown-item" href="contact-v3.html">Contact v.3</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#!" role="button"
                                            data-bs-toggle="dropdown" data-bs-trigger="hover"
                                            aria-expanded="false">Help Center</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="help-topics-v1.html">Help Topics
                                                    v.1</a></li>
                                            <li><a class="dropdown-item" href="help-topics-v2.html">Help Topics
                                                    v.2</a></li>
                                            <li><a class="dropdown-item" href="help-single-article-v1.html">Help
                                                    Single Article v.1</a></li>
                                            <li><a class="dropdown-item" href="help-single-article-v2.html">Help
                                                    Single Article v.2</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#!" role="button"
                                            data-bs-toggle="dropdown" data-bs-trigger="hover"
                                            aria-expanded="false">404 Error</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="404-electronics.html">404
                                                    Electronics</a></li>
                                            <li><a class="dropdown-item" href="404-fashion.html">404 Fashion</a>
                                            </li>
                                            <li><a class="dropdown-item" href="404-furniture.html">404
                                                    Furniture</a></li>
                                            <li><a class="dropdown-item" href="404-grocery.html">404 Grocery</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="terms-and-conditions.html">Terms &amp;
                                            Conditions</a></li>
                                </ul>
                            </li>
                            <li class="nav-item pb-lg-2 me-lg-n2 me-xl-0">
                                <a class="nav-link" href="docs/installation.html">Docs</a>
                            </li>
                            <li class="nav-item pb-lg-2 me-lg-n2 me-xl-0">
                                <a class="nav-link" href="docs/typography.html">Components</a>
                            </li>
                        </ul> --}}

                        <!-- Search toggle visible on screens > 991px wide (lg breakpoint) -->
                        <button type="button"
                            class="btn btn-outline-secondary justify-content-start w-100 px-3 mb-lg-2 ms-3 d-none d-lg-inline-flex"
                            style="max-width: 240px" data-bs-toggle="offcanvas" data-bs-target="#searchBox"
                            aria-controls="searchBox">
                            <i class="ci-search fs-base ms-n1 me-2"></i>
                            <span class="text-body-tertiary fw-normal">Search</span>
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
                        <a class="nav-link border-end" href="account-signin.html">
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
