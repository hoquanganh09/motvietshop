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
                                <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#createEmployeeModal">
                                    <i class="ki-duotone ki-plus fs-2"></i> Thêm nhân viên
                                </button>

                                <x-admin.filter :data="$filters" id="filter_user" />
                                <!--end::Menu 1--> <!--end::Filter-->
                            </div>
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
    @include('admin.users.modals.create')
</x-admin.layout.home>
