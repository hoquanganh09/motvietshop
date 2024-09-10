<div class="position-sticky top-0" style="padding-top: 100px">
    <div class="bg-body-tertiary rounded-5 p-4 mb-3">
        <div class="p-sm-2 p-lg-0 p-xl-2">
            <div class="border-bottom pb-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                    <div class="nav">
                        <a class="nav-link text-decoration-underline p-0"
                            href="{{ route('client.cart.showCart') }}">Sửa</a>
                    </div>
                </div>
                <a class="d-flex align-items-center gap-2 text-decoration-none" href="#orderPreview"
                    data-bs-toggle="offcanvas">
                    @php
                        $i = 0;
                    @endphp
                    @foreach (getCart(\App\Enums\CartStatus::NotDisabled) as $item)
                        @if ($i < 4)
                            <div class="ratio ratio-1x1" style="max-width: 64px">
                                <img src="{{ $item['thumbnail'] }}" class="d-block p-1" alt="product">
                            </div>
                        @endif
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <i class="ci-chevron-right text-body fs-xl p-0 ms-auto"></i>
                </a>
            </div>
            <ul class="list-unstyled fs-sm gap-3 mb-0">
                <li class="d-flex justify-content-between">
                    Sản phẩm ({{ getCartCount(\App\Enums\CartStatus::NotDisabled) }} sản phẩm):
                    <span
                        class="text-dark-emphasis fw-medium">{{ formatMoney(getCartTotal(\App\Enums\CartStatus::NotDisabled)) }}</span>
                </li>
                <li class="d-flex justify-content-between">
                    Mã giảm giá:
                    <span class="text-danger fw-medium">-{{ formatMoney(getCartDiscount(\App\Enums\CartStatus::NotDisabled)) }}</span>
                </li>
                <li class="d-flex justify-content-between">
                    Vận chuyển:
                    <span class="text-dark-emphasis fw-medium">{{ formatMoney(0) }}</span>
                </li>
            </ul>
            <div class="border-top pt-4 mt-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="fs-sm">Thành tiền:</span>
                    <span class="h5 mb-0">{{ formatMoney(getCartDiscountTotal(\App\Enums\CartStatus::NotDisabled)) }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-body-tertiary rounded-5">
        <div class="accordion bg-body-tertiary rounded-5 p-4">
            <div class="accordion-item border-0">
                <h3 class="accordion-header" id="promoCodeHeading">
                    <button type="button" class="accordion-button animate-underline py-0 ps-sm-2 ps-lg-0 ps-xl-2"
                        data-bs-toggle="collapse" data-bs-target="#promoCode" aria-expanded="true"
                        aria-controls="promoCode">
                        <i class="ci-percent fs-xl me-2"></i>
                        <span class="animate-target me-2">Nhập mã giảm giá</span>
                    </button>
                </h3>
                <div class="accordion-collapse collapse" id="promoCode" aria-labelledby="promoCodeHeading"
                    style="">
                    <div class="accordion-body pt-3 pb-2 ps-sm-2 px-lg-0 px-xl-2">
                        <form class="needs-validation d-flex gap-2" action="{{ route('client.coupon.apply') }}">
                            @csrf
                            <div class="position-relative w-100">
                                <input type="text" name="code" class="form-control"
                                    placeholder="Nhập mã giảm giá">
                                <div class="invalid-tooltip bg-transparent py-0">Nhập mã giảm giá
                                </div>
                            </div>
                            <button type="button" class="btn-apply-code btn btn-dark">Áp
                                dụng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#order_summary').on('click', '.btn-apply-code', function() {
            const url = $(this).closest('form').attr('action');
            const data = new FormData($(this).closest('form')[0]);

            ajax(url, 'post', data, function(res) {
                $('#order_summary').html(res.data.order_summary);
                toast(res.data.message);
            }, function (err) {                
                $('#order_summary').html(err.response.data.order_summary);
                toast(err.response.data.message, 'error');
            });
        });
    </script>
@endpush
