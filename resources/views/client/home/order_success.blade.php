<x-client.layout.home>
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        <div class="d-flex justify-content-center">
            <div class="col-6">
                <div
                    class="w-100 pt-sm-2 pt-md-3 pt-lg-4 pb-lg-4 pb-xl-5 px-3 px-sm-4 pe-lg-0 ps-lg-5 mx-auto ms-lg-auto me-lg-4">
                    <div class="d-flex align-items-sm-center border-bottom pb-4 pb-md-5">
                        <div class="d-flex align-items-center justify-content-center bg-success text-white rounded-circle flex-shrink-0"
                            style="width: 3rem; height: 3rem; margin-top: -.125rem">
                            <i class="ci-check fs-4"></i>
                        </div>
                        <div class="w-100 ps-3">
                            <div class="fs-sm mb-1">Đơn hàng #{{ $order->code }}</div>
                            <div class="d-sm-flex align-items-center">
                                <h1 class="h4 mb-0 me-3">Cảm ơn bạn đã đặt hàng!</h1>
                                <div class="nav mt-2 mt-sm-0 ms-auto">
                                    <a class="nav-link text-decoration-underline p-0" href="{{ route('client.home.orderHistory') }}">Xem đơn hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-4 pt-3 pb-5 mt-3">
                        <div>
                            <h3 class="h6 mb-2">Họ tên</h3>
                            <p class="fs-sm mb-0">{{ $order->fullname }}</p>
                        </div>
                        <div>
                            <h3 class="h6 mb-2">Số điện thoại</h3>
                            <p class="fs-sm mb-0">{{ $order->phone_number }}</p>
                        </div>
                        <div>
                            <h3 class="h6 mb-2">Địa chỉ</h3>
                            <p class="fs-sm mb-0">{{ $order->address }}</p>
                        </div>
                        <div>
                            <h3 class="h6 mb-2">Thanh toán</h3>
                            <p class="fs-sm mb-0">{{ $order->getPaymentMethodLabel() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-client.layout.home>
