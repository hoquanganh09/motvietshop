<div class="modal fade" id="newAddressModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="newAddressModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAddressModalLabel">Thêm địa chỉ mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 g-lg-4" method="post" action="{{ route('client.shippingAddress.store') }}">
                    @csrf
                    <div class="col-md-12 validate-name">
                        <div class="position-relative">
                            <label for="add-address" class="form-label">Tên của địa chỉ giao hàng
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name"
                                class="form-control" placeholder="Nhà">
                            <div style="display: block" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6 validate-fullname">
                        <div class="position-relative">
                            <label for="add-address" class="form-label">Họ và tên
                                <span class="text-danger">*</span>
                            </label>
                            <input data-default="{{ auth()->user()->fullname }}" type="text" name="fullname"
                                class="form-control">
                            <div style="display: block" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6 validate-phone_number">
                        <div class="position-relative">
                            <label for="add-address" class="form-label">Số điện thoại
                                <span class="text-danger">*</span>
                            </label>
                            <input data-default="{{ auth()->user()->phone_number }}" type="number" name="phone_number"
                                class="form-control">
                            <div style="display: block" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-12 validate-address">
                        <div class="position-relative">
                            <label for="add-address" class="form-label">Địa chỉ
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="address" class="form-control"></textarea>
                            <div style="display: block" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check mb-0">
                            <input value="1" type="checkbox" name="is_default" class="form-check-input" id="set-primary-3">
                            <label for="set-primary-3" class="form-check-label">Đặt làm địa chỉ mặc định</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3 pt-2 pt-sm-0">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(() => {
            const modal = $('#newAddressModal');
            const validateName = modal.find('.validate-name');
            const validateFullname = modal.find('.validate-fullname');
            const validatePhoneNumber = modal.find('.validate-phone_number');
            const validateAddress = modal.find('.validate-address');
            const inputName = modal.find('input[name="name"]');
            const inputFullname = modal.find('input[name="fullname"]');
            const inputPhone = modal.find('input[name="phone_number"]');
            const inputAddress = modal.find('textarea[name="address"]');

            modal.on('show.bs.modal', function(e) {
                inputFullname.val(inputFullname.data('default'));
                inputPhone.val(inputPhone.data('default'));
            });

            modal.on('hide.bs.modal', function(e) {
                clear();
            });

            modal.find('form').on('submit', function(e) {
                e.preventDefault();
                const url = $(this).attr('action');
                const formData = new FormData($(this)[0]);

                ajax(url, 'post', formData, function(res) {
                    toast(res.data.message);
                    modal.modal('hide');
                    location.reload();
                }, function(e) {
                    clearError();
                    fillError(e.response.data);
                });
            });

            function clear() {
                inputFullname.val('');
                inputPhone.val('');
                inputAddress.val('');
                inputName.val('');

                clearError();
            }

            function clearError() {
                validateFullname.find('.invalid-feedback').html('');
                validateFullname.find('input').removeClass('is-invalid');
                
                validateName.find('.invalid-feedback').html('');
                validateName.find('input').removeClass('is-invalid');

                validatePhoneNumber.find('.invalid-feedback').html('');
                validatePhoneNumber.find('input').removeClass('is-invalid');

                validateAddress.find('.invalid-feedback').html('');
                validateAddress.find('textarea').removeClass('is-invalid');
            }

            function fillError(e) {
                if (e.errors) {
                    if (e.errors['fullname']) {
                        validateFullname.find('.invalid-feedback').html(e.errors['fullname'][0]);
                        validateFullname.find('input').addClass('is-invalid');
                    }

                    if (e.errors['phone_number']) {
                        validatePhoneNumber.find('.invalid-feedback').html(e.errors['phone_number'][0]);
                        validatePhoneNumber.find('input').addClass('is-invalid');
                    }

                    if (e.errors['address']) {
                        validateAddress.find('.invalid-feedback').html(e.errors['address'][0]);
                        validateAddress.find('textarea').addClass('is-invalid');
                    }

                    if (e.errors['name']) {
                        validateName.find('.invalid-feedback').html(e.errors['name'][0]);
                        validateName.find('textarea').addClass('is-invalid');
                    }
                }
            }
        })
    </script>
@endpush
