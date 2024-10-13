<x-admin.layout.default>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 bg-secondary">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10 bg-white">
                        <div class="d-flex justify-content-center mb-3">
                            <img src="{{ getLogo() }}" alt="logo" class="img-fluid" width="200">
                        </div>
                        <!--begin::Form-->
                        <form class="form w-100" action="{{ route('admin.auth.handleLogin') }}" method="POST">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">
                                    Đăng nhập
                                </h1>
                                <!--end::Title-->

                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">
                                    Vào trang quản trị
                                </div>
                                <!--end::Subtitle--->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input autofocus type="text" placeholder="Địa chỉ email" name="email"
                                    autocomplete="off"
                                    class="form-control bg-transparent @error('email') is-invalid @enderror" />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <!--end::Email-->
                            </div>

                            <!--end::Input group--->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <input type="password" placeholder="Mật khẩu" name="password" autocomplete="off"
                                    class="form-control bg-transparent @error('password') is-invalid @enderror" />
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <!--end::Password-->
                            </div>
                            <!--end::Input group--->

                            <!--begin::Wrapper-->
                            <div class="fv-row mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="kt_check_remember"
                                    value="1">
                                <label class="form-check-label" for="kt_check_remember">
                                    Nhớ đăng nhập
                                </label>
                            </div>
                            <!--end::Wrapper-->

                            @if (session()->has('error'))
                                <div class="text-danger text-center mb-3">{{ session()->get('error') }}</div>
                            @endif

                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        Đăng nhập
                                    </span>
                                </button>
                            </div>
                            <!--end::Submit button-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Body-->
        </div>
    </div>
</x-admin.layout.default>
