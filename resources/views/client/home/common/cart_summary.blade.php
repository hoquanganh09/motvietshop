<div class="position-sticky top-0" style="padding-top: 100px">
    <div class="bg-body-tertiary rounded-5 p-4 mb-3">
        <div class="p-sm-2 p-lg-0 p-xl-2">
            <h5 class="border-bottom pb-4 mb-4">Tóm tắt đơn hàng</h5>
            <ul class="list-unstyled fs-sm gap-3 mb-0">
                <li class="d-flex justify-content-between">
                    Tổng phụ ({{ getCartCount() }} sản phẩm):
                    <span
                        class="text-dark-emphasis fw-medium">{{ formatMoney(getCartTotal()) }}</span>
                </li>
                <li class="d-flex justify-content-between">
                    Tiết kiệm:
                    <span class="text-danger fw-medium">{{ formatMoney(getCartSavingTotal()) }}</span>
                </li>
            </ul>
            <div class="border-top pt-4 mt-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="fs-sm">Tổng tiền ước tính:</span>
                    <span class="h5 mb-0">{{ formatMoney(getCartTotal()) }}</span>
                </div>
                @if (getCartCount() > 0)
                    <a class="btn btn-lg btn-primary w-100" href="checkout-v1-delivery-1.html">
                        Thanh toán
                        <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                    </a>
                @else
                    <button disabled class="btn btn-lg btn-primary w-100">
                        Thanh toán
                        <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>