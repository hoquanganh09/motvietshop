<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Danh sách vai trò
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
                            Phân quyền
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            Danh Sách vai trò
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                    @foreach ($roles as $role)
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ $role->name }}</h2>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="fw-bold text-gray-600 mb-5">
                                    Tổng số lượng người dùng: 
                                    {{ $role->users->count() }}
                                </div>
    
                                <div class="d-flex flex-column text-gray-600">
                                    <div class="d-flex align-items-center py-2"><span
                                            class="bullet bg-primary me-3"></span> All Admin Controls</div>
                                    <div class="d-flex align-items-center py-2"><span
                                            class="bullet bg-primary me-3"></span> View and Edit Financial Summaries
                                    </div>
                                    <div class="d-flex align-items-center py-2"><span
                                            class="bullet bg-primary me-3"></span> Enabled Bulk Reports</div>
                                    <div class="d-flex align-items-center py-2"><span
                                            class="bullet bg-primary me-3"></span> View and Edit Payouts</div>
                                    <div class="d-flex align-items-center py-2"><span
                                            class="bullet bg-primary me-3"></span> View and Edit Disputes</div>

                                    <div class="d-flex align-items-center py-2"><span
                                            class="bullet bg-primary me-3"></span> <em>and 7 more...</em></div>
                                </div>
                            </div>
 
                            <div class="card-footer flex-wrap pt-0">
                                <a href="/keen/demo1/apps/user-management/roles/view.html"
                                    class="btn btn-light btn-active-primary my-1 me-2">Chi tiết</a>

                                <button type="button" class="btn btn-light btn-active-light-primary my-1"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Sửa vai trò</button>
                            </div>
                        </div>
                    </div>  
                    @endforeach
                    <div class="ol-md-4">
                        <!--begin::Card-->
                        <div class="card h-md-100">
                            <!--begin::Card body-->
                            <div class="card-body d-flex flex-center">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                    <!--begin::Illustration-->
                                    <img src="/keen/demo1/assets/media/illustrations/sketchy-1/4.png" alt=""
                                        class="mw-100 mh-150px mb-7">
                                    <!--end::Illustration-->

                                    <!--begin::Label-->
                                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                                    <!--end::Label-->
                                </button>
                                <!--begin::Button-->
                            </div>
                            <!--begin::Card body-->
                        </div>
                        <!--begin::Card-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout.home>
