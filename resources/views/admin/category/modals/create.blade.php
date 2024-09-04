<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm phân loại</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="form-label">Ảnh</label>
                        <div class="text-center pt-0 validate-avatar">
                            <!--begin::Image input-->
                            <!--begin::Image input placeholder-->
                            <style>
                                #createCategoryModal .image-input-placeholder {
                                    background-image: url("{{ getDefaultImage() }}");
                                }
                            </style>
                            <!--end::Image input placeholder-->

                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <!--end::Preview existing avatar-->

                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    aria-label="Change avatar" data-bs-original-title="Change avatar"
                                    data-kt-initialized="1">
                                    <!--begin::Icon-->
                                    <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span
                                            class="path2"></span></i> <!--end::Icon-->

                                    <!--begin::Inputs-->
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="avatar_remove">
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->

                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                            class="path2"></span></i> </span>
                                <!--end::Cancel-->

                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <div class="text-danger feedback"></div>
                            <!--end::Image input-->
                        </div>
                    </div>

                    <div class="validate-name">
                        <label class="form-label">
                            Tên
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control mb-2" name="name">
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
            const modal = $('#createCategoryModal');
            const form = modal.find('form');
            const validateName = form.find('.validate-name');
            const validateAvatar = form.find('.validate-avatar');

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
                form.find('[data-kt-image-input-action="cancel"]').trigger('click');

                clearError();
            }

            function clearError() {
                validateName.find('.feedback').html('');
                validateName.find('input[name="name"]').removeClass('is-invalid');

                validateAvatar.find('.feedback').html('');
            }

            function fillError(e) {
                if (e.errors) {
                    if (e.errors['name']) {
                        validateName.find('.feedback').html(e.errors['name'][0]);
                        validateName.find('input[name="name"]').addClass('is-invalid');
                    }

                    if (e.errors['avatar']) {
                        validateAvatar.find('.feedback').html(e.errors['avatar'][0]);
                    }
                }
            }
        });
    </script>
@endpush
