<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">

        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Cập nhật thông tin tài khoản
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
                            Cập nhật thông tin tài khoản
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <div class="card card-flush mb-9" id="kt_user_profile_panel">
                    <!--begin::Hero nav-->
                    <div class="card-header rounded-top bgi-size-cover h-200px"
                        style="background-position: 100% 50%; background-image:url('{{ getBackgroundImage() }}')">
                    </div>
                    <!--end::Hero nav-->

                    <!--begin::Body-->
                    <div class="card-body mt-n19">
                        <!--begin::Details-->
                        <div class="m-0">
                            <!--begin: Pic-->
                            <div class="d-flex flex-stack align-items-end pb-4 mt-n19">
                                <div class="symbol symbol-125px symbol-lg-150px symbol-fixed position-relative mt-n3">
                                    <img src="{{ getUserAvatar() }}" alt="image" class="border border-white border-4"
                                        style="border-radius: 20px">
                                    <div
                                        class="position-absolute translate-middle bottom-0 start-100 ms-n1 mb-9 bg-success rounded-circle h-15px w-15px">
                                    </div>
                                </div>
                            </div>
                            <!--end::Pic-->

                            <!--begin::Info-->
                            <div class="d-flex flex-stack flex-wrap align-items-end">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $user->fullname }}</a>
                                        @if ($user->isEmailVerified())
                                            <a href="#" class="" data-bs-toggle="tooltip"
                                                data-bs-placement="right" aria-label="Tài khoản đã xác thực email"
                                                data-bs-original-title="Tài khoản đã xác thực email"
                                                data-kt-initialized="1">
                                                <i class="ki-duotone ki-verify fs-1 text-primary"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                            </a>
                                        @endif
                                    </div>
                                    <!--end::Name-->

                                    <!--begin::Text-->
                                    <span class="fw-bold text-gray-600 fs-6 mb-2 d-block">
                                        {{ $user->getRole->name }}
                                    </span>
                                    <!--end::Text-->
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Thông tin chi tiết</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->

                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_account_profile_details_form" method="POST"
                            action="{{ route('admin.user.update', $user->id) }}"
                            class="form fv-plugins-bootstrap5 fv-plugins-framework">
                            @csrf
                            @method('PUT')
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Họ và tên</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input type="text" name="fullname"
                                                    class="form-control form-control-lg mb-3 mb-lg-0 @error('fullname') is-invalid @enderror"
                                                    value="{{ old('fullname', $user->fullname) }}">
                                                @error('fullname')
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Email</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input readonly type="text" name="email"
                                                    class="form-control form-control-lg mb-3 mb-lg-0 @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Sinh nhật</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                        <input type="date" name="date_of_birth"
                                            class="form-control form-control-lg @error('date_of_birth') is-invalid @enderror"
                                            value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                        @error('date_of_birth')
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Số điện
                                        thoại</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input type="number" name="phone_number"
                                                    class="form-control form-control-lg mb-3 mb-lg-0 @error('phone_number') is-invalid @enderror"
                                                    value="{{ old('phone_number', $user->phone_number) }}">
                                                @error('phone_number')
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                            </div>
                            <!--end::Card body-->

                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary"
                                    id="kt_account_profile_details_submit">Thay đổi</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>

                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Mật khẩu</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->

                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_account_profile_details_form" method="POST"
                            action="{{ route('admin.user.updatePassword', $user->id) }}"
                            class="form fv-plugins-bootstrap5 fv-plugins-framework">
                            @csrf
                            @method('PUT')
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Mật khẩu
                                        mới</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input type="password" name="password"
                                                    class="form-control form-control-lg mb-3 mb-lg-0 @error('password') is-invalid @enderror"
                                                    value="{{ old('password') }}">
                                                @error('password')
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Xác nhận mật khẩu</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input type="password" name="password_confirmation"
                                                    class="form-control form-control-lg mb-3 mb-lg-0 @error('password_confirmation') is-invalid @enderror"
                                                    value="{{ old('password_confirmation') }}">
                                                @error('password_confirmation')
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                            </div>
                            <!--end::Card body-->

                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button onclick="document.querySelector('#form-reset-password').submit()" type="button" class="btn btn-secondary me-2">Reset mật khẩu (Mail)
                                </button>
                                <button type="submit" class="btn btn-primary">Thay đổi</button>
                            </div>
                        </form>
                        <form id="form-reset-password" action="{{ route('admin.user.resetPassword') }}" method="post">
                            @csrf
                            <input type="hidden" name="email" value="{{ $user->email }}">
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
</x-admin.layout.home>
