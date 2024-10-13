<x-client.layout.home>
    <nav class="container pt-2 pt-xxl-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.home.shop') }}">Cửa hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        @if ($errorQuantity)
            <div class="alert alert-danger" role="alert">
                Một số sản phẩm đã hết hàng. Chúng tôi đã tự động điều chỉnh lại sản phẩm của bạn trong giỏ hảng. <a
                    class="alert-link" href="{{ route('client.cart.showCart') }}">Xem chi tiết</a>
            </div>
        @endif
        <h1 class="h3 mb-4">Thanh toán</h1>
        <div class="">
            <div class="row pb-2 pb-md-3 pb-lg-4 pb-xl-5">
                <div class="col-lg-8 col-xl-7 position-relative z-2 mb-5 mb-lg-0">
                    <form id="checkout-form" action="{{ route('client.order.store') }}" method="post">
                        @csrf
                        <div class="accordion d-flex flex-column gap-5 pe-lg-4 pe-xl-0" id="checkout">
                            <!-- Shipping address overview + Edit button -->
                            @if (!$shippingAddress)
                                <div class="nav">
                                    <div>
                                        <i class="ci-alert-triangle text-warning"></i>
                                        Không có địa chỉ giao hàng mặc định nào
                                    </div>
                                    <a class="nav-link text-decoration-underline p-0 ps-1"
                                        href="{{ route('client.home.addresses') }}">thêm ngay
                                    </a>
                                </div>
                            @else
                                <div class="accordion-item d-flex align-items-start border-0">
                                    <div class="d-flex align-items-center justify-content-center bg-body-secondary text-dark-emphasis rounded-circle flex-shrink-0"
                                        style="width: 2rem; height: 2rem; margin-top: -.125rem">
                                        <i class="ci-check fs-base"></i>
                                    </div>
                                    <div class="w-100 ps-3 ps-md-4">
                                        <div class="d-flex align-items-center">
                                            <h2 class="accordion-header h5 mb-0 me-3" id="shippingAddressHeading">
                                                <span class="d-none d-lg-inline">Địa chỉ giao hàng
                                                    ({{ $shippingAddress->name }})</span>
                                                <button type="button"
                                                    class="accordion-button collapsed fs-5 d-lg-none py-1"
                                                    data-bs-toggle="collapse" data-bs-target="#shippingAddress"
                                                    aria-expanded="false" aria-controls="shippingAddress">
                                                    <span class="me-2">Địa chỉ giao hàng
                                                        ({{ $shippingAddress->name }})
                                                    </span>
                                                </button>
                                            </h2>
                                            <div class="nav ms-auto">
                                                <a class="nav-link text-decoration-underline p-0"
                                                    href="{{ route('client.home.addresses') }}">Sửa</a>
                                            </div>
                                        </div>
                                        <div class="accordion-collapse collapse d-lg-block" id="shippingAddress"
                                            aria-labelledby="shippingAddressHeading" data-bs-parent="#checkout">
                                            <ul class="accordion-body list-unstyled fs-sm p-0 pt-3 pt-md-4 mb-0">
                                                <li>
                                                    {{ $shippingAddress->fullname }}
                                                    <input type="hidden" name="fullname"
                                                        value="{{ $shippingAddress->fullname }}">
                                                </li>
                                                <li>{{ $shippingAddress->phone_number }}
                                                    <input type="hidden" name="phone_number"
                                                        value="{{ $shippingAddress->phone_number }}">
                                                </li>
                                                <li>{{ $shippingAddress->address }}
                                                    <input type="hidden" name="address"
                                                        value="{{ $shippingAddress->address }}">
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Payment method -->
                            <div class="d-flex align-items-start">
                                <div class="d-flex align-items-center justify-content-center bg-body-secondary text-dark-emphasis rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0"
                                    style="width: 2rem; height: 2rem; margin-top: -.125rem">
                                    <i class="ci-check fs-base"></i>
                                </div>
                                <div class="w-100 ps-3 ps-md-4">
                                    <h2 class="h5 mb-0">Phương thức thanh toán</h2>
                                    <div class="mb-4" role="list">
                                        <div class="mt-4">
                                            <div class="form-check mb-0" role="listitem">
                                                <label
                                                    class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                                    <input value="cod" checked type="radio"
                                                        class="form-check-input fs-base me-2 me-sm-3"
                                                        name="payment_method">
                                                    Thanh toán khi nhận hàng
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="form-check mb-0" role="listitem">
                                                <label
                                                    class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                                    <input value="online" type="radio"
                                                        class="form-check-input fs-base me-2 me-sm-3"
                                                        name="payment_method">
                                                    Thanh toán online
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional comments -->
                                    <textarea name="note" class="form-control form-control-lg mb-4" rows="3" placeholder="Ghi chú"></textarea>

                                    <!-- Pay button visible on screens > 991px wide (lg breakpoint) -->
                                    @if ($products->count() == 0 || !$shippingAddress)
                                        <button type="button" disabled
                                            class="btn-process-checkout btn btn-lg btn-primary w-100 d-none d-lg-flex">Thanh
                                            toán
                                        </button>
                                    @else
                                        <a class="btn-process-checkout btn btn-lg btn-primary w-100 d-none d-lg-flex"
                                            href="javascript:void(0)">Thanh toán
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Order summary (sticky sidebar) -->
                <aside id="order_summary" class="col-lg-4 offset-xl-1" style="margin-top: -100px">
                    @include('client.home.common.order_summary')
                </aside>
            </div>
        </div>
    </section>
    <div class="fixed-bottom z-sticky w-100 py-2 px-3 bg-body border-top shadow d-lg-none">
        @if ($products->count() == 0 || !$shippingAddress)
            <button disabled type="button" class="btn-process-checkout btn btn-lg btn-primary w-100"
                href="javascript:void(0)">Thanh toán</button>
        @else
            <a class="btn-process-checkout btn btn-lg btn-primary w-100" href="javascript:void(0)">Thanh toán</a>
        @endif
    </div>
    @include('client.modal.order_preview')
    @push('js')
        <script>
            $('.btn-process-checkout').on('click', function() {
                $('#checkout-form').submit();
            });
        </script>
    @endpush
</x-client.layout.home>
