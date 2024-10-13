<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="reviewOrder" tabindex="-1" style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header align-items-start py-3 pt-lg-4">
        <div>
            <h4 class="offcanvas-title mb-1" id="orderDetailsLabel">Đánh giá đơn hàng</h4>
        </div>
        <button type="button" class="btn-close mt-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2 pb-3">
    </div>

    <!-- Footer -->
    <div class="offcanvas-header offcanvas-footer">
        <button class="btn-review btn btn-lg btn-success w-100">Đánh giá</button>
    </div>
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.rating', function() {
                const parent = $(this).parent();

                parent.find('input').val($(this)[0].dataset.value);
            });

            $(document).on('mouseover', '.rating', function() {
                const currentValue = $(this)[0].dataset.value;

                const parent = $(this).parent();
                parent.find('.rating').each(function() {
                    const val = $(this)[0].dataset.value;

                    if (val <= currentValue) {
                        changeStarStyle($(this), true);
                    }
                    else {
                        changeStarStyle($(this), false);
                    }

                });
            });

            function changeStarStyle(el, isActive = true) {
                if (isActive) {
                    el.addClass('text-warning');
                    el.addClass('ci-star-filled');
                    el.removeClass('ci-star');
                    el.removeClass('text-body-tertiary');
                    el.removeClass('opacity-75');
                } else {
                    el.removeClass('text-warning');
                    el.removeClass('ci-star-filled');
                    el.addClass('ci-star');
                    el.addClass('text-body-tertiary');
                    el.addClass('opacity-75');
                }
            }
        });
    </script>
@endpush
