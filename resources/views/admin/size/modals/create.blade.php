<div class="modal fade" id="createSizeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.size.store') }}" method="post">
                    @csrf
                    <div class="validate-name mb-3">
                        <label class="form-label">
                            Size chữ
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control mb-2" name="name" placeholder="L">
                        <div class="text-danger feedback"></div>
                    </div>
                    
                    <div class="validate-number">
                        <label class="form-label">
                            Size số
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control mb-2" name="number" placeholder="12-13">
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
            const modal = $('#createSizeModal');
            const form = modal.find('form');
            const validateName = form.find('.validate-name');
            const validateNumber = form.find('.validate-number');

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
                form.find('input[name="name"]').val('');
                form.find('input[name="number"]').val('');

                clearError();
            }

            function clearError() {
                validateName.find('.feedback').html('');
                validateName.find('input[name="name"]').removeClass('is-invalid');

                validateNumber.find('.feedback').html('');
                validateNumber.find('input[name="number"]').removeClass('is-invalid');
            }

            function fillError(e) {
                if (e.errors) {
                    if (e.errors['name']) {
                        validateName.find('.feedback').html(e.errors['name'][0]);
                        validateName.find('input[name="name"]').addClass('is-invalid');
                    }

                    if (e.errors['number']) {
                        validateNumber.find('.feedback').html(e.errors['number'][0]);
                        validateNumber.find('input[name="number"]').addClass('is-invalid');
                    }
                }
            }
        });
    </script>
@endpush
