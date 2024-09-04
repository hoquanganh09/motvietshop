<div class="modal fade" id="editColorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa màu sắc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.color.update', $color->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="validate-name">
                        <label class="form-label">
                            Tên
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control mb-2" name="name" value="{{ $color->name }}"
                            placeholder="red">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-label">
                        <label class="form-label">
                            Nhãn
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control mb-2" name="label" value="{{ $color->label }}"
                            placeholder="Đỏ">
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
        const modal = $('#editColorModal');
        const form = modal.find('form');
        const validateName = form.find('.validate-name');
        const validateLabel = form.find('.validate-label');

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
            form.find('input[name="name"]').val('');
            form.find('input[name="label"]').val('');

            clearError();
        }

        function clearError() {
            validateName.find('.feedback').html('');
            validateName.find('input[name="name"]').removeClass('is-invalid');

            validateLabel.find('.feedback').html('');
            validateLabel.find('input[name="label"]').removeClass('is-invalid');
        }

        function fillError(e) {
            if (e.errors) {
                if (e.errors['name']) {
                    validateName.find('.feedback').html(e.errors['name'][0]);
                    validateName.find('input[name="name"]').addClass('is-invalid');
                }

                if (e.errors['label']) {
                    validateLabel.find('.feedback').html(e.errors['label'][0]);
                    validateLabel.find('input[name="label"]').addClass('is-invalid');
                }
            }
        }
    });
</script>
