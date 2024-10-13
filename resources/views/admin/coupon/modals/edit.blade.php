<div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa mã giảm giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="validate-code mb-3">
                        <label class="form-label required">
                            Mã
                        </label>
                        <input value="{{ $coupon->code }}" type="text" class="form-control mb-2" name="code">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-discount mb-3">
                        <label class="form-label required">
                            Giảm (%)
                        </label>
                        <input value="{{ $coupon->discount }}" type="number" class="form-control mb-2" name="discount">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-max_price mb-3">
                        <label class="form-label required">
                            Giảm tối đa
                        </label>
                        <input value="{{ $coupon->max_price }}" type="number" class="form-control mb-2" name="max_price">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-amount mb-3">
                        <label class="form-label required">
                            Số lượng
                        </label>
                        <input value="{{ $coupon->amount }}" type="number" class="form-control mb-2" name="amount">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-expiration_date">
                        <label class="form-label required">
                            Ngày hết hạn
                        </label>
                        <input value="{{ $coupon->expiration_date->format('Y-m-d') }}" type="date" class="form-control mb-2" name="expiration_date">
                        <div class="text-danger feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary btn-save">Lưu lại</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(() => {
        const modal = $('#editCouponModal');
        const form = modal.find('form');
        const validateCode = form.find('.validate-code');
        const validateDiscount = form.find('.validate-discount');
        const validateMaxPrice = form.find('.validate-max_price');
        const validateAmount = form.find('.validate-amount');
        const validateExpirationDate = form.find('.validate-expiration_date');

        modal.modal('show');  

        modal.on('hidden.bs.modal', function() {
            clear();
        });

        modal.on('click', '.btn-save', function() {
            const formData = new FormData(form[0]);

            ajax(form.attr('action'), 'post', formData, function(res) {
                dispatchReloadEvent();
                toast(res.data.message);
                modal.modal('hide');
            }, function(e) {
                clearError();
                fillError(e.response.data);
            });
        });

        function clear() {
            validateCode.find('input').val('');
            validateDiscount.find('input').val('');
            validateMaxPrice.find('input').val('');
            validateAmount.find('input').val('');
            validateExpirationDate.find('input').val('');

            clearError();
        }

        function clearError() {
            validateCode.find('.feedback').html('');
            validateCode.find('input').removeClass('is-invalid');

            validateDiscount.find('.feedback').html('');
            validateDiscount.find('input').removeClass('is-invalid');

            validateMaxPrice.find('.feedback').html('');
            validateMaxPrice.find('input').removeClass('is-invalid');

            validateAmount.find('.feedback').html('');
            validateAmount.find('input').removeClass('is-invalid');

            validateExpirationDate.find('.feedback').html('');
            validateExpirationDate.find('input').removeClass('is-invalid');
        }

        function fillError(e) {
            if (e.errors) {
                if (e.errors['code']) {
                    validateCode.find('.feedback').html(e.errors['code'][0]);
                    validateCode.find('input').addClass('is-invalid');
                }

                if (e.errors['amount']) {
                    validateAmount.find('.feedback').html(e.errors['amount'][0]);
                    validateAmount.find('input').addClass('is-invalid');
                }

                if (e.errors['discount']) {
                    validateDiscount.find('.feedback').html(e.errors['discount'][0]);
                    validateDiscount.find('input').addClass('is-invalid');
                }

                if (e.errors['max_price']) {
                    validateMaxPrice.find('.feedback').html(e.errors['max_price'][0]);
                    validateMaxPrice.find('input').addClass('is-invalid');
                }

                if (e.errors['expiration_date']) {
                    validateExpirationDate.find('.feedback').html(e.errors['expiration_date'][0]);
                    validateExpirationDate.find('input').addClass('is-invalid');
                }
            }
        }
    });
</script>
