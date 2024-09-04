<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle" style="">

    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('admin.home.dashboard') }}">
            <img alt="Logo" src="{{ getLogo() }}" class="h-30px app-sidebar-logo-default">
        </a>
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-sm h-30px w-30px rotate "
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">

            <i class="ki-duotone ki-double-left fs-2 rotate-180"><span class="path1"></span><span
                    class="path2"></span>
            </i>
        </div>
    </div>

    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">

        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">

            {{-- <div id="kt_app_sidebar_menu_scroll" class="hover-scroll-y my-5 mx-3">

                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion hover show">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="bi bi-bookmarks-fill fs-2x"></i></span>
                            <span class="menu-title">Nhân viên</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('admin.user.index') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Danh sách nhân viên</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="/keen/demo1/index.html">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Thêm mới vai trò</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('admin.permission.index') ? 'active' : '' }}" href="{{ route('admin.permission.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Danh sách quyền</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion hover show">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="bi bi-bookmarks-fill fs-2x"></i></span>
                            <span class="menu-title">Phân quyên</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('admin.role.index') ? 'active' : '' }}" href="{{ route('admin.role.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Danh sách vai trò</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="/keen/demo1/index.html">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Thêm mới vai trò</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::is('admin.permission.index') ? 'active' : '' }}" href="{{ route('admin.permission.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Danh sách quyền</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <x-admin.sidemenu :items="$menu" />
        </div>
    </div>
</div
