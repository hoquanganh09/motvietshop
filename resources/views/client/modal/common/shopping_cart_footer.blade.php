<div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
    <span class="text-light-emphasis">Tổng tiền:</span>
    <span class="h6 mb-0">{{ formatMoney(getCartTotal(\App\Enums\CartStatus::NotDisabled)) }}</span>
</div>
<div class="d-flex w-100 gap-3">
    <a class="btn btn-lg btn-secondary w-100" href="{{ route('client.cart.showCart') }}">Xem giỏ hảng</a>
    <a class="btn btn-lg btn-dark w-100" href="{{ route('client.home.checkout') }}">Thanh toán</a>
</div>
