<x-client.layout.default>
    <main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto" style="max-width: 1920px">
        <div class="d-lg-flex">

            <!-- Login form + Footer -->
            <div class="d-flex flex-column min-vh-100 w-100 py-4 mx-auto me-lg-51" style="max-width: 416px">

                <!-- Logo -->
                @include('client.layouts.auth_header')

                <h1 class="h2 mt-auto">Tạo tài khoản</h1>
                <div class="nav fs-sm mb-3 mb-lg-4">
                    Tôi đã có tài khoản
                    <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('client.auth.login') }}">Đăng
                        nhập</a>
                </div>

                <!-- Form -->
                <form action="{{ route('client.auth.handleRegister') }}" method="post">
                    @csrf
                    <div class="position-relative mb-4">
                        <label for="register-email" class="form-label">Họ và tên</label>
                        <input value="{{ old('fullname') }}" name="fullname" type="text"
                            class="form-control form-control-lg @error('fullname') is-invalid @enderror"
                            id="register-fullname">
                        @error('fullname')
                            <div class="d-block invalid-tooltip bg-transparent py-0">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="position-relative mb-4">
                        <label for="register-email" class="form-label">Địa chỉ email</label>
                        <input value="{{ old('email') }}" name="email" type="text"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            id="register-email">
                        @error('email')
                            <div class="d-block invalid-tooltip bg-transparent py-0">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="register-password" class="form-label">Mật khẩu</label>
                        <div class="password-toggle">
                            <input name="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                id="register-password">
                            @error('password')
                                <div class="invalid-tooltip bg-transparent py-0">{{ $message }}
                                </div>
                            @enderror
                            <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                <input type="checkbox" class="btn-check">
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="register-password" class="form-label">Xác nhận mật khẩu</label>
                        <div class="password-toggle">
                            <input name="password_confirmation" type="password"
                                class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                id="register-password">
                            @error('password_confirmation')
                                <div class="invalid-tooltip bg-transparent py-0">{{ $message }}
                                </div>
                            @enderror
                            <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                <input type="checkbox" class="btn-check">
                            </label>
                        </div>
                    </div>

                    @if (session()->has('error'))
                        <div class="text-danger text-center bg-transparent mb-2">{{ session()->get('error') }}</div>
                    @endif

                    <button type="submit" class="btn btn-lg btn-primary w-100">
                        Tạo tài khoản
                        <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                    </button>
                </form>

                @include('client.layouts.auth_social')

                <!-- Footer -->
                @include('client.layouts.auth_footer')
            </div>
        </div>
    </main>
</x-client.layout.default>
