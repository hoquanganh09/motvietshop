<div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.banner.update', $banner->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div>
                        <label class="form-label">Ảnh</label>
                        <div class="text-center pt-0 validate-image">
                            <!--begin::Image input-->
                            <!--begin::Image input placeholder-->
                            <style>
                                #editBannerModal .image-input-placeholder {
                                    background-image: url("{{ $banner->getImage() }}");
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
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
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

                    <div class="validate-title mb-3">
                        <label class="form-label">
                            Tiêu đề
                        </label>
                        <input value="{{ $banner->title }}" type="text" class="form-control mb-2" name="title">
                        <div class="text-danger feedback"></div>
                    </div>

                    <div class="validate-content">
                        <label class="form-label">
                            Tên
                            <span class="text-danger">*</span>
                        </label>
                        <input value="{{ $banner->content }}" type="text" class="form-control mb-2" name="content">
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
        const modal = $('#editBannerModal');
        const form = modal.find('form');
        const validateTitle = form.find('.validate-title');
        const validateImage = form.find('.validate-image');
        const validateContent = form.find('.validate-content');
        const parent = modal.find('[data-kt-image-input="true"]');
        const input = parent.find('input[type="file"]');
        const imgWrapper = parent.find('.image-input-wrapper');

        modal.modal('show');

        function previewAvatar() {
            const url = URL.createObjectURL(input[0].files[0]);
            imgWrapper.css('background-image', `url(${url})`);
            parent.addClass('image-input-changed');
            parent.removeClass('image-input-empty');
        }

        function removeAvatar() {
            imgWrapper.css('background-image', `none`);
            parent.removeClass('image-input-changed');
            parent.addClass('image-input-empty');
            input.val('');
        }

        input.on('change', previewAvatar);
        parent.find('[data-kt-image-input-action="cancel"]').on('click', removeAvatar);

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
            form.find('input[name="title"]').val('');
            form.find('input[name="content"]').val('');
            form.find('[data-kt-image-input-action="cancel"]').trigger('click');

            clearError();
        }

        function clearError() {
            validateTitle.find('.feedback').html('');
            validateTitle.find('input[name="title"]').removeClass('is-invalid');

            validateContent.find('.feedback').html('');
            validateContent.find('input[name="content"]').removeClass('is-invalid');

            validateImage.find('.feedback').html('');
        }

        function fillError(e) {
            if (e.errors) {
                if (e.errors['title']) {
                    validateTitle.find('.feedback').html(e.errors['title'][0]);
                    validateTitle.find('input[name="title"]').addClass('is-invalid');
                }

                if (e.errors['content']) {
                    validateContent.find('.feedback').html(e.errors['content'][0]);
                    validateContent.find('input[name="content"]').addClass('is-invalid');
                }

                if (e.errors['image']) {
                    validateImage.find('.feedback').html(e.errors['image'][0]);
                }
            }
        }
    });
</script>
