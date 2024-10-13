<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" aria-labelledby="shoppingCartLabel"
    style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
        <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-lg-4">
            <h4 class="offcanvas-title" id="shoppingCartLabel">Giỏ hàng</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="progress w-100" role="progressbar" aria-label="Free shipping progress" aria-valuenow="78"
            aria-valuemin="0" aria-valuemax="100" style="height: 4px">
            <div class="progress-bar bg-dark rounded-pill d-none-dark" style="width: 100%"></div>
            <div class="progress-bar bg-light rounded-pill d-none d-block-dark" style="width: 100%"></div>
        </div>
    </div>

    <div class="offcanvas-body d-flex flex-column gap-4 pt-2">
        @include('client.modal.common.shopping_cart_body')
    </div>

    <!-- Footer -->
    <div class="offcanvas-header offcanvas-footer flex-column align-items-start">
        @include('client.modal.common.shopping_cart_footer')
    </div>
</div>
@push('js')
    <script>
        $(() => {
            const timer = 300;
            const cartEl = $('#shoppingCart');
            const cartCount = $('[data-bs-target="#shoppingCart"] > span');
            let clearTimeOut = null;

            $(document).on('click', '.btn-remove-product', function() {
                const url = $(this)[0].dataset.url;
                const parent = $(this).closest('.cart-item');  

                ajax(url, 'delete', {}, function(res) {
                    parent.remove();
                    cartEl.find('.offcanvas-footer').html(res.data.footer);
                    $('[data-bs-target="#shoppingCart"] > span').html(res.data.count);
                    $('.cart-summary').html(res.data.cart_summary);
                    if (parent.is('div')) {
                        $('.cart-items').html(res.data.cart_items);
                    }
                    else {
                        $(`div.cart-item[data-key="${parent[0].dataset.key}"]`).remove();
                    }
                });
            });

            $(document).on('click', '.count-input .btn-decrement', function(e) {
                const input = $(this).closest('.count-input').find('input');
                const url = this.dataset.url;
                const parent = $(this).closest('.cart-item');
                const inputs = $(`.cart-item[data-key="${parent[0].dataset.key}"] .count-input input`);

                if (parseInt(input.val()) <= 1) {
                    return;
                }

                const val = parseInt(input.val()) - 1;

                input.val(val);
                inputs.val(val);

                updateQuantity(url, input);
            });

            $(document).on('click', '.count-input .btn-increment', function(e) {
                const input = $(this).closest('.count-input').find('input');
                const url = this.dataset.url;
                const parent = $(this).closest('.cart-item');
                const inputs = $(`.cart-item[data-key="${parent[0].dataset.key}"] .count-input input`);
                
                const val = parseInt(input.val()) + 1;
                input.val(val);
                inputs.val(val);

                updateQuantity(url, input);
                
            });

            $(document).on('input', '.count-input .input-quantity-cart', function(e) {
                const input = $(this).closest('.count-input').find('input');
                const url = this.dataset.url;
                const parent = $(this).closest('.cart-item');
                const inputs = $(`.cart-item[data-key="${parent[0].dataset.key}"] .count-input input`);
                
                const val = parseInt(input.val());
                inputs.val(val);

                updateQuantity(url, input);
                
            });

            function updateQuantity(url, input) {
                if (clearTimeOut != null) {
                    clearTimeout(clearTimeOut);
                    clearTimeOut = null;
                }

                clearTimeOut = setTimeout(() => {
                    ajax(url, 'post', {
                        quantity: input.val(),
                    }, function(res) {
                        cartEl.find('.offcanvas-footer').html(res.data.footer);
                        $('.cart-summary').html(res.data.cart_summary);
                        $('.cart-items').html(res.data.cart_items);
                    });
                }, timer);
            }
        });
    </script>
@endpush
