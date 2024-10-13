<div id="kt_app_header" class="app-header ">

    <!--begin::Header container-->
    <div class="app-container  container-fluid d-flex align-items-stretch justify-content-between "
        id="kt_app_header_container">

        <!--begin::sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>

        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('admin.home.dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ getLogo() }}" class="theme-light-show h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->

        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">


            <!--begin::Menu wrapper-->
            <div class="
        app-header-menu 
        app-header-mobile-drawer 
        align-items-stretch
    "
                data-kt-drawer="true" data-kt-drawer-name="app-header-menu"
                data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                data-kt-drawer-width="225px" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class="
            menu 
            menu-rounded  
            menu-column 
            menu-lg-row 
            my-5 
            my-lg-0 
            align-items-stretch 
            fw-semibold
            px-2 px-lg-0
        "
                    id="kt_app_header_menu" data-kt-menu="true">

                </div>
            </div>

            <div class="app-navbar flex-shrink-0">
                <div class="d-none app-navbar-item align-items-stretch ms-1 ms-lg-3">
                    <div id="kt_header_search" class="header-search d-flex align-items-stretch"
                        data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter"
                        data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false"
                        data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">

                        <div class="d-flex align-items-center" data-kt-search-element="toggle"
                            id="kt_header_search_toggle">
                            <div
                                class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px">
                                <i class="ki-duotone ki-magnifier fs-1"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                        </div>
                    </div>
                </div>
                @auth('admin')
                    <div class="app-navbar-item ms-2 ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <div class="cursor-pointer symbol symbol-35px symbol-md-40px"
                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <img src="{{ getUserAvatar() }}" alt="user" />
                        </div>

                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="{{ getUserAvatar() }}" />
                                    </div>
                                    <!--end::Avatar-->

                                    <!--begin::Username-->
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">
                                            {{ auth('admin')->user()->fullname }}
                                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"></span>
                                        </div>

                                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                            {{ auth('admin')->user()->getRole->name }}
                                        </a>
                                    </div>
                                    <!--end::Username-->
                                </div>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="{{ route('admin.home.profile', auth('admin')->id()) }}" class="menu-link px-5">
                                    Thông tin cá nhân
                                </a>
                            </div>   

                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <form action="{{ route('admin.auth.handleLogout') }}" method="post">
                                    @csrf
                                    <a onclick="logout(event)" href="javascript:void(0)" class="menu-link px-5">
                                        Đăng xuất
                                    </a>
                                </form>
                            </div>
                            <!--end::Menu item-->
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        function logout(e) {
            e.target.closest('form').submit();
        }
    </script>
@endpush
