<div class="modal fade" id="createEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nhân viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="validate-fullname mb-3">
                        <label class="form-label required">
                            Họ và tên
                        </label>
                        <input type="text" class="form-control mb-2" name="fullname">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-email mb-3">
                        <label class="form-label required">
                            Email
                        </label>
                        <input type="text" class="form-control mb-2" name="email">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-password mb-3">
                        <label class="form-label required">
                            Mật khẩu
                        </label>
                        <input type="password" class="form-control mb-2" name="password">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-phone_number mb-3">
                        <label class="form-label">
                            Số điện thoại
                        </label>
                        <input type="number" class="form-control mb-2" name="phone_number">
                        <div class="text-danger feedback"></div>
                    </div>
                    
                    <div class="validate-date_of_birth mb-3">
                        <label class="form-label">
                            Ngày sinh
                        </label>
                        <input type="date" class="form-control mb-2" name="date_of_birth">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-role">
                        <label class="form-label required">
                            Vai trò
                        </label>
                        <div class="d-flex justify-content-between">
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input me-3" name="role" type="radio" value="2" id="kt_docs_formvalidation_checkbox_option_2" />
                                <label class="form-check-label" for="kt_docs_formvalidation_checkbox_option_2">
                                    <div class="fw-semibold text-gray-800">Super Admin</div>
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-check-solid">
                                <input checked class="form-check-input me-3" name="role" type="radio" value="3" id="kt_docs_formvalidation_checkbox_option_3" />
                                <label class="form-check-label" for="kt_docs_formvalidation_checkbox_option_3">
                                    <div class="fw-semibold text-gray-800">Admin</div>
                                </label>
                            </div>
                        </div>
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
@push('js')
    <script>
        $(() => {
            const modal = $('#createEmployeeModal');
            const form = modal.find('form');
            const validateFullname = form.find('.validate-fullname');
            const validateEmail = form.find('.validate-email');
            const validatePassword = form.find('.validate-password');
            const validatePhonenumber = form.find('.validate-phone_number');
            const validateDateOfBirth = form.find('.validate-date_of_birth');
            const validateRole = form.find('.validate-role');

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
                validateFullname.find('input').val('');
                validateEmail.find('input').val('');
                validatePhonenumber.find('input').val('');
                validateDateOfBirth.find('input').val('');
                validatePassword.find('input').val('');
                validateRole.find('input[value=3]').prop('checked', true);
                validateRole.find('input[value=2]').prop('checked', false);

                clearError();
            }

            function clearError() {
                validateFullname.find('.feedback').html('');
                validateFullname.find('input').removeClass('is-invalid');

                validateEmail.find('.feedback').html('');
                validateEmail.find('input').removeClass('is-invalid');

                validatePhonenumber.find('.feedback').html('');
                validatePhonenumber.find('input').removeClass('is-invalid');

                validatePassword.find('.feedback').html('');
                validatePassword.find('input').removeClass('is-invalid');

                validateDateOfBirth.find('.feedback').html('');
                validateDateOfBirth.find('input').removeClass('is-invalid');
            }

            function fillError(e) {
                if (e.errors) {
                    if (e.errors['fullname']) {
                        validateFullname.find('.feedback').html(e.errors['fullname'][0]);
                        validateFullname.find('input').addClass('is-invalid');
                    }

                    if (e.errors['date_of_birth']) {
                        validateDateOfBirth.find('.feedback').html(e.errors['date_of_birth'][0]);
                        validateDateOfBirth.find('input').addClass('is-invalid');
                    }

                    if (e.errors['email']) {
                        validateEmail.find('.feedback').html(e.errors['email'][0]);
                        validateEmail.find('input').addClass('is-invalid');
                    }

                    if (e.errors['phone_number']) {
                        validatePhonenumber.find('.feedback').html(e.errors['phone_number'][0]);
                        validatePhonenumber.find('input').addClass('is-invalid');
                    }

                    if (e.errors['password']) {
                        validatePassword.find('.feedback').html(e.errors['password'][0]);
                        validatePassword.find('input').addClass('is-invalid');
                    }
                }
            }
        });
    </script>
@endpush
