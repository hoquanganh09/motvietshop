<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Cập nhật sản phẩm
                    </h1>

                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.home.dashboard') }}" class="text-muted text-hover-primary">
                                Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            Sản phẩm
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.product.index') }}" class="text-muted text-hover-primary">
                                Danh sách sản phẩm
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            Cập nhật Sản phẩm
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <!--begin::Form-->
                <form id="kt_ecommerce_add_product_form" method="post"
                    action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data"
                    class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    @method('put')
                    <!--begin::Aside column-->
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Ảnh nổi bật</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <!--begin::Image input placeholder-->
                                <style>
                                    .image-input-placeholder {
                                        background-image: url('{{ $product->getThumbnail() }}');
                                    }
                                </style>
                                <!--end::Image input placeholder-->

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
                                        <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg">
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
                                                class="path2"></span></i> </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->

                                <!--begin::Description-->
                                @error('thumbnail')
                                    <div class="text-danger feedback">{{ $message }}</div>
                                @enderror
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->

                        <!--begin::Category & tags-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Chi tiết</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label required">Số lượng tồn kho</label>
                                    <!--end::Label-->

                                    <input type="number" name="stock"
                                        class="form-control mb-2 @error('stock') is-invalid @enderror"
                                        placeholder="Số lượng" value="{{ old('stock', $product->stock) }}">
                                    <!--end::Input-->
                                    @error('stock')
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Thể loại</label>
                                    <select name="kind_id" id="" class="form-select">
                                        @foreach ($kinds as $item)
                                            <option @if (old('kind_id', $product->kind_id) == $item->id) selected @endif
                                                value="{{ $item->id }}">
                                                {{ $item->name }} -
                                                {{ $item->category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Trạng thái</label>
                                    <div
                                        class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                        <input name="is_active" class="form-check-input h-20px w-30px" type="checkbox"
                                            value="1" @if (old('is_active', $product->is_active) == 1) checked @endif
                                            id="product_status" />
                                        <label class="form-check-label" for="product_status">
                                            Hoạt động
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Category & tags-->
                    </div>
                    <!--end::Aside column-->

                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade active show" id="kt_ecommerce_add_product_general"
                                role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">

                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Thông tin chung</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->

                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row fv-plugins-icon-container">
                                                <!--begin::Label-->
                                                <label class="required form-label">Tên sản phẩm</label>
                                                <!--end::Label-->

                                                <!--begin::Input-->
                                                <input type="text" name="name"
                                                    class="form-control mb-2 @error('name') is-invalid @enderror"
                                                    placeholder="Tên sản phẩm"
                                                    value="{{ old('name', $product->name) }}">
                                                <!--end::Input-->
                                                @error('name')
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--end::Input group-->

                                            <div class="row">
                                                <div class="mb-10 col-md-6">
                                                    <!--begin::Label-->
                                                    <label class="form-label required">Giá tiền</label>
                                                    <!--end::Label-->

                                                    <input type="number" name="price"
                                                        class="form-control mb-2 @error('price') is-invalid @enderror"
                                                        placeholder="Giá tiền"
                                                        value="{{ old('price', $product->price) }}">
                                                    <!--end::Input-->
                                                    @error('price')
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="mb-10 col-md-6">
                                                    <!--begin::Label-->
                                                    <label class="form-label">Giá tiền cũ</label>
                                                    <!--end::Label-->

                                                    <input type="number" name="old_price"
                                                        class="form-control mb-2 @error('old_price') is-invalid @enderror"
                                                        placeholder="Giá tiền"
                                                        value="{{ old('old_price', $product->old_price) }}">
                                                    <!--end::Input-->
                                                    @error('old_price')
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-10">
                                                <label class="form-label">Màu sản phẩm</label>

                                                <select name="colors[]" class="form-select" multiple>
                                                    @foreach ($colors as $item)
                                                        <option @if ($product->colors->where('color_id', $item->id)->count() > 0) selected @endif
                                                            value="{{ $item->id }}">
                                                            {{ $item->label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-10">
                                                <label class="form-label">Size sản phẩm</label>

                                                <select name="sizes[]" class="form-select" multiple>
                                                    @foreach ($sizes as $item)
                                                        <option @if ($product->sizes->where('size_id', $item->id)->count() > 0) selected @endif
                                                            value="{{ $item->id }}">
                                                            {{ $item->name }} -
                                                            {{ $item->number }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label">Mô tả</label>
                                                <!--end::Label-->

                                                <!--begin::Editor-->
                                                <x-editor value="{!! old('description', $product->description) !!}" name="description"
                                                    style="min-height: 150px;" />
                                                <!--end::Editor-->
                                            </div>

                                            <div>
                                                <!--begin::Label-->
                                                <label class="form-label">Hướng dẫn giặt đồ</label>
                                                <!--end::Label-->

                                                <!--begin::Editor-->
                                                <x-editor value="{!! old('washing_instructions', $product->washing_instructions) !!}" name="washing_instructions"
                                                    style="min-height: 150px;" />
                                                <!--end::Editor-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::General options-->
                                    <!--begin::Media-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Ảnh sản phẩm</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->

                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-2">
                                                <!--begin::Dropzone-->
                                                <div class="dropzone dz-clickable dz-image-product cursor-pointer"
                                                    id="kt_ecommerce_add_product_media">
                                                    <!--begin::Message-->
                                                    <div class="dz-message needsclick">
                                                        <!--begin::Icon-->
                                                        <i class="ki-duotone ki-file-up text-primary fs-3x"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                        <!--end::Icon-->
                                                        <!--begin::Info-->
                                                        <div class="ms-4">
                                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">
                                                                Kéo ảnh vào đây hoặc nhấn để upload
                                                            </h3>
                                                            <span class="fs-7 fw-semibold text-gray-500">
                                                                Chỉ chấp nhận file .png, .jpeg, .jpg
                                                            </span>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <div
                                                        class="d-none row flex-wrap file-container justify-content-center">
                                                    </div>
                                                    <input multiple accept=".png , .jpeg, .jpg" type="file"
                                                        name="images[]" class="d-none">
                                                </div>

                                                <div class="mt-3 row justify-content-center flex-wrap">
                                                    @foreach ($product->images->where('is_on_top', 0) as $item)
                                                        <div class="image-preview col-md-2 col-4 bg-primary p-2 m-2"
                                                            style="border-radius: 5px; position: relative">
                                                            <img src="{{ $item->getImage() }}" class="img-fluid w-100">
                                                            <div data-url="{{ route('admin.productImage.destroy', $item->id) }}" class="btn-delete-image bg-dark rounded-circle cursor-pointer"
                                                                style="position: absolute; bottom: -5px; right: -5px; width: 20px; height: 20px">
                                                                <i class="bi bi-x-circle text-white"
                                                                    style="font-size: 20px;"></i>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!--end::Dropzone-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Media-->
                                </div>
                            </div>
                            <!--end::Tab pane-->
                        </div>
                        <!--end::Tab content-->

                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.product.index') }}" class="btn btn-light me-5">
                                Hủy
                            </a>
                            <!--end::Button-->

                            <!--begin::Button-->
                            <button type="submit" class="btn btn-primary btn-store-product">
                                Lưu lại
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content container-->
        </div>
    </div>
    @push('js')
        <script>
            $('select[name="kind_id"]').select2();
            $('select[name="colors[]"]').select2();
            $('select[name="sizes[]"]').select2();

            $(() => {
                const dropzone = $('.dz-image-product');
                const input = $('input[name="images[]"]');
                const fileContainer = dropzone.find('.file-container');
                const fileMessage = dropzone.find('.dz-message');
                let oldFile = [];

                dropzone.on('drop', function(e) {
                    const files = e.originalEvent.dataTransfer.files;
                    handlePreviewFiles(files);

                    e.preventDefault()
                });

                dropzone.on('dragover', function(e) {
                    e.preventDefault()
                });

                dropzone.on('click', function(e) {
                    if (e.target.closest('.file-container') == null) {
                        input[0].click();
                    }
                });

                input.on('change', function() {
                    handlePreviewFiles(input[0].files);
                });

                dropzone.on('click', '.btn-remove-image', function(e) {
                    e.stopPropagation(e);
                    e.preventDefault();

                    const parent = $(this).closest('.image-preview');
                    const file = JSON.parse(parent[0].dataset.file);

                    oldFile = oldFile.filter(oldFile => {
                        return !compareFile(file, oldFile);
                    });

                    parent.remove();

                    handleToggleImagePreview(oldFile);
                    fillFiles(oldFile);
                });

                function handlePreviewFiles(files) {
                    const fileFilters = Array.from(files).filter(file => checkMimeType(file));

                    if (fileFilters.length > 0) {
                        handleToggleImagePreview(fileFilters);

                        fileContainer.html(
                            fileContainer.html() + fileFilters.map(file => {
                                const check = oldFile.filter(oldFile => {
                                    return compareFile(file, oldFile);
                                });

                                if (check.length > 0) return '';
                                oldFile.push(file);
                                return getImageEl(file);
                            }).join('')
                        );
                    }

                    fillFiles(oldFile);
                }

                function getImageEl(file) {
                    const url = URL.createObjectURL(file);
                    const obj = {
                        name: file.name,
                        size: file.size,
                        lastModified: file.lastModified,
                        type: file.type,
                    };

                    const html = `
                        <div data-file='${JSON.stringify(obj)}' class="image-preview col-md-2 col-4 bg-primary p-2 m-2" style="border-radius: 5px; position: relative">
                            <label class="text-white fw-bold">${Math.floor(file.size/1024)} kb</label>
                            <p class="text-white">${file.name}</p>
                            <img src="${url}"
                                class="img-fluid w-100">
                            <div class="btn-remove-image bg-dark rounded-circle cursor-pointer" style="position: absolute; bottom: -5px; right: -5px; width: 20px; height: 20px">
                                <i class="bi bi-x-circle text-white" style="font-size: 20px;"></i>
                            </div>
                            <div class="error-message text-danger fw-bold">${checkFileSize(file) ? '' : 'Ảnh phải nhỏ hơn 2MB'}</div>
                        </div>
                    `;

                    return html;
                }

                function checkMimeType(file) {
                    const array = ['png', 'jpeg', 'jpg'];
                    const ext = file.name.split('.').pop();

                    return array.includes(ext);
                }

                function compareFile(a, b) {
                    return (a.name == b.name) && (a.size == b.size) && (a.lastModified == b.lastModified);
                }

                function handleToggleImagePreview(arr) {
                    if (arr.length > 0) {
                        // fileMessage.addClass('d-none');
                        fileContainer.removeClass('d-none');
                    } else {
                        // fileMessage.removeClass('d-none');
                        fileContainer.addClass('d-none');
                    }
                }

                function fillFiles(files) {
                    const dataTransfer = new DataTransfer();

                    files.forEach(file => dataTransfer.items.add(file));

                    const fileList = dataTransfer.files;

                    input[0].files = fileList;
                    canSubmit();
                }

                function checkFileSize(file) {
                    const maximum = 2048;

                    return (file.size / 1024) < maximum;
                }

                function canSubmit() {
                    const errors = oldFile.filter((file) => {
                        return !checkFileSize(file);
                    });

                    if (errors.length > 0) {
                        $('.btn-store-product').prop('disabled', true);
                    } else {
                        $('.btn-store-product').prop('disabled', false);
                    }
                }

                $('.btn-delete-image').on('click', function () {
                    const image = $(this).closest('.image-preview');
                    const url = $(this)[0].dataset.url;

                    ajax(url, 'delete', {}, function(res) {
                        toast(res.data.message);
                        image.remove();
                    });
                });
            });
        </script>
    @endpush
</x-admin.layout.home>
