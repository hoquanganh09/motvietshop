<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Danh sách nhân viên
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
                            Nhân viên
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            Danh Sách nhân viên
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                        class="path1"></span><span class="path2"></span></i>
                                <input type="search" class="form-control form-control-solid w-250px ps-13"
                                    placeholder="Search user">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"
                                data-select2-id="select2-data-161-pji5">
                                <!--begin::Filter-->

                                <x-admin.filter :data="$filters" id="filter_user" />
                                <!--end::Menu 1--> <!--end::Filter-->

                                <!--begin::Export-->
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_export_users">
                                    <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span
                                            class="path2"></span></i> Export
                                </button>
                                <!--end::Export-->

                                <!--begin::Add user-->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_user">
                                    <i class="ki-duotone ki-plus fs-2"></i> Add User
                                </button>
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->

                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none"
                                data-kt-user-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-user-table-select="selected_count">10</span> Selected
                                </div>

                                <button type="button" class="btn btn-danger"
                                    data-kt-user-table-select="delete_selected">
                                    Delete Selected
                                </button>
                            </div>
                            <!--end::Group actions-->

                            <!--begin::Modal - Adjust Balance-->
                            <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true"
                                style="display: none;">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-650px"
                                    data-select2-id="select2-data-144-142u">
                                    <!--begin::Modal content-->
                                    <div class="modal-content" data-select2-id="select2-data-143-5f5l">
                                        <!--begin::Modal header-->
                                        <div class="modal-header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Export Users</h2>
                                            <!--end::Modal title-->

                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-kt-users-modal-action="close">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                        class="path2"></span></i>
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->

                                        <!--begin::Modal body-->
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                            <!--begin::Form-->
                                            <form id="kt_modal_export_users_form"
                                                class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#"
                                                data-select2-id="select2-data-kt_modal_export_users_form">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mb-2">Select
                                                        Roles:</label>
                                                    <!--end::Label-->

                                                    <!--begin::Input-->
                                                    <select name="role" data-control="select2"
                                                        data-placeholder="Select a role" data-hide-search="true"
                                                        class="form-select form-select-solid fw-bold select2-hidden-accessible"
                                                        data-select2-id="select2-data-16-o4iv" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option data-select2-id="select2-data-18-2kyq"></option>
                                                        <option value="Administrator"
                                                            data-select2-id="select2-data-149-1737">Administrator
                                                        </option>
                                                        <option value="Analyst" data-select2-id="select2-data-150-rpk7">
                                                            Analyst</option>
                                                        <option value="Developer"
                                                            data-select2-id="select2-data-151-zmag">Developer</option>
                                                        <option value="Support" data-select2-id="select2-data-152-lb4g">
                                                            Support</option>
                                                        <option value="Trial" data-select2-id="select2-data-153-87b4">
                                                            Trial</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5 select2-container--below"
                                                        dir="ltr" data-select2-id="select2-data-17-tc9k"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid fw-bold"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-role-2f-container"
                                                                aria-controls="select2-role-2f-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-role-2f-container" role="textbox"
                                                                    aria-readonly="true" title="Select a role"><span
                                                                        class="select2-selection__placeholder">Select a
                                                                        role</span></span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="fv-row mb-10 fv-plugins-icon-container">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold form-label mb-2">Select
                                                        Export Format:</label>
                                                    <!--end::Label-->

                                                    <!--begin::Input-->
                                                    <select name="format" data-control="select2"
                                                        data-placeholder="Select a format" data-hide-search="true"
                                                        class="form-select form-select-solid fw-bold select2-hidden-accessible"
                                                        data-select2-id="select2-data-19-yt85" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option data-select2-id="select2-data-21-umfu"></option>
                                                        <option value="excel">Excel</option>
                                                        <option value="pdf">PDF</option>
                                                        <option value="cvs">CVS</option>
                                                        <option value="zip">ZIP</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-20-73i1"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid fw-bold"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-format-nx-container"
                                                                aria-controls="select2-format-nx-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-format-nx-container" role="textbox"
                                                                    aria-readonly="true" title="Select a format"><span
                                                                        class="select2-selection__placeholder">Select a
                                                                        format</span></span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    <!--end::Input-->
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Actions-->
                                                <div class="text-center">
                                                    <button type="reset" class="btn btn-light me-3"
                                                        data-kt-users-modal-action="cancel">
                                                        Discard
                                                    </button>

                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">
                                                            Submit
                                                        </span>
                                                        <span class="indicator-progress">
                                                            Please wait... <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Modal body-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                            <!--end::Modal - New Card-->

                            <!--begin::Modal - Add task-->
                            <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header" id="kt_modal_add_user_header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Add User</h2>
                                            <!--end::Modal title-->

                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-kt-users-modal-action="close">
                                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                        class="path2"></span></i>
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->

                                        <!--begin::Modal body-->
                                        <div class="modal-body px-5 my-7">
                                            <!--begin::Form-->
                                            <form id="kt_modal_add_user_form"
                                                class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                                action="#">
                                                <!--begin::Scroll-->
                                                <div class="d-flex flex-column scroll-y px-5 px-lg-10"
                                                    id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                                    data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                                                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                                    data-kt-scroll-offset="300px" style="max-height: 611px;">
                                                    <!--begin::Input group-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                                        <!--end::Label-->


                                                        <!--begin::Image placeholder-->
                                                        <style>
                                                            /* .image-input-placeholder {
                                                                background-image: url('/keen/demo1/assets/media/svg/files/blank-image.svg');
                                                            }

                                                            [data-bs-theme="dark"] .image-input-placeholder {
                                                                background-image: url('/keen/demo1/assets/media/svg/files/blank-image-dark.svg');
                                                            } */
                                                        </style>
                                                        <!--end::Image placeholder-->
                                                        <!--begin::Image input-->
                                                        <div class="image-input image-input-outline image-input-placeholder"
                                                            data-kt-image-input="true">
                                                            <!--begin::Preview existing avatar-->
                                                            <div class="image-input-wrapper w-125px h-125px"
                                                                style="background-image: url(/keen/demo1/assets/media/avatars/300-6.jpg);">
                                                            </div>
                                                            <!--end::Preview existing avatar-->

                                                            <!--begin::Label-->
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" aria-label="Change avatar"
                                                                data-bs-original-title="Change avatar"
                                                                data-kt-initialized="1">
                                                                <i class="ki-duotone ki-pencil fs-7"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i>
                                                                <!--begin::Inputs-->
                                                                <input type="file" name="avatar"
                                                                    accept=".png, .jpg, .jpeg">
                                                                <input type="hidden" name="avatar_remove">
                                                                <!--end::Inputs-->
                                                            </label>
                                                            <!--end::Label-->

                                                            <!--begin::Cancel-->
                                                            <span
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="cancel"
                                                                data-bs-toggle="tooltip" aria-label="Cancel avatar"
                                                                data-bs-original-title="Cancel avatar"
                                                                data-kt-initialized="1">
                                                                <i class="ki-duotone ki-cross fs-2"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i> </span>
                                                            <!--end::Cancel-->

                                                            <!--begin::Remove-->
                                                            <span
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="remove"
                                                                data-bs-toggle="tooltip" aria-label="Remove avatar"
                                                                data-bs-original-title="Remove avatar"
                                                                data-kt-initialized="1">
                                                                <i class="ki-duotone ki-cross fs-2"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i> </span>
                                                            <!--end::Remove-->
                                                        </div>
                                                        <!--end::Image input-->

                                                        <!--begin::Hint-->
                                                        <div class="form-text">Allowed file types: png, jpg, jpeg.
                                                        </div>
                                                        <!--end::Hint-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group-->
                                                    <div class="fv-row mb-7 fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                                                        <!--end::Label-->

                                                        <!--begin::Input-->
                                                        <input type="text" name="user_name"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Full name" value="Emma Smith">
                                                        <!--end::Input-->
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group-->
                                                    <div class="fv-row mb-7 fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                                                        <!--end::Label-->

                                                        <!--begin::Input-->
                                                        <input type="email" name="user_email"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="example@domain.com" value="smith@kpmg.com">
                                                        <!--end::Input-->
                                                        <div
                                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-5">Role</label>
                                                        <!--end::Label-->

                                                        <!--begin::Roles-->
                                                        <!--begin::Input row-->
                                                        <div class="d-flex fv-row">
                                                            <!--begin::Radio-->
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="0"
                                                                    id="kt_modal_update_role_option_0"
                                                                    checked="checked">
                                                                <!--end::Input-->

                                                                <!--begin::Label-->
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_0">
                                                                    <div class="fw-bold text-gray-800">Administrator
                                                                    </div>
                                                                    <div class="text-gray-600">Best for business owners
                                                                        and company administrators</div>
                                                                </label>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Radio-->
                                                        </div>
                                                        <!--end::Input row-->

                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Input row-->
                                                        <div class="d-flex fv-row">
                                                            <!--begin::Radio-->
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="1"
                                                                    id="kt_modal_update_role_option_1">
                                                                <!--end::Input-->

                                                                <!--begin::Label-->
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_1">
                                                                    <div class="fw-bold text-gray-800">Developer</div>
                                                                    <div class="text-gray-600">Best for developers or
                                                                        people primarily using the API</div>
                                                                </label>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Radio-->
                                                        </div>
                                                        <!--end::Input row-->

                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Input row-->
                                                        <div class="d-flex fv-row">
                                                            <!--begin::Radio-->
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="2"
                                                                    id="kt_modal_update_role_option_2">
                                                                <!--end::Input-->

                                                                <!--begin::Label-->
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_2">
                                                                    <div class="fw-bold text-gray-800">Analyst</div>
                                                                    <div class="text-gray-600">Best for people who need
                                                                        full access to analytics data, but don't need to
                                                                        update business settings</div>
                                                                </label>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Radio-->
                                                        </div>
                                                        <!--end::Input row-->

                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Input row-->
                                                        <div class="d-flex fv-row">
                                                            <!--begin::Radio-->
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="3"
                                                                    id="kt_modal_update_role_option_3">
                                                                <!--end::Input-->

                                                                <!--begin::Label-->
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_3">
                                                                    <div class="fw-bold text-gray-800">Support</div>
                                                                    <div class="text-gray-600">Best for employees who
                                                                        regularly refund payments and respond to
                                                                        disputes</div>
                                                                </label>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Radio-->
                                                        </div>
                                                        <!--end::Input row-->

                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Input row-->
                                                        <div class="d-flex fv-row">
                                                            <!--begin::Radio-->
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="4"
                                                                    id="kt_modal_update_role_option_4">
                                                                <!--end::Input-->

                                                                <!--begin::Label-->
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_4">
                                                                    <div class="fw-bold text-gray-800">Trial</div>
                                                                    <div class="text-gray-600">Best for people who need
                                                                        to preview content data, but don't need to make
                                                                        any updates</div>
                                                                </label>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Radio-->
                                                        </div>
                                                        <!--end::Input row-->

                                                        <!--end::Roles-->
                                                    </div>
                                                    <!--end::Input group-->
                                                </div>
                                                <!--end::Scroll-->

                                                <!--begin::Actions-->
                                                <div class="text-center pt-10">
                                                    <button type="reset" class="btn btn-light me-3"
                                                        data-kt-users-modal-action="cancel">
                                                        Discard
                                                    </button>

                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">
                                                            Submit
                                                        </span>
                                                        <span class="indicator-progress">
                                                            Please wait... <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Modal body-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                            <!--end::Modal - Add task-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body py-4">

                        <!--begin::Table-->
                        <div id="kt_table_users_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                            <x-handle_ajax 
                                url="{{ route('admin.user.index') }}"
                                search="#kt_app_content_container input[type=search]"
                                filter_id="#filter_user"
                                >
                                @include('admin.users.table_list_user', $users)
                            </x-handle_ajax>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
</x-admin.layout.home>
