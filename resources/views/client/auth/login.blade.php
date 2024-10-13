<x-client.layout.default>
    <!-- Page content -->
    <main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto" style="max-width: 1920px">
        <div class="d-lg-flex">

            <!-- Login form + Footer -->
            <div class="d-flex flex-column min-vh-100 w-100 py-4 mx-auto me-lg-51 border-1 border-red-50"
                style="max-width: 416px">

                <!-- Logo -->
                @include('client.layouts.auth_header')

                <h1 class="h2 mt-auto">Đăng nhập</h1>
                <div class="nav fs-sm mb-4">
                    Không có tài khoản?
                    <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('client.auth.register') }}">
                        Tạo tài khoản
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('client.auth.handleLogin') }}" method="post">
                    @csrf
                    <div class="position-relative mb-4">
                        <input value="{{ old('email') }}" name="email" type="text"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            placeholder="Email">
                        @error('email')
                            <div class="d-block invalid-tooltip bg-transparent py-0">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <div class="password-toggle">
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                                <div class="d-block invalid-tooltip bg-transparent py-0">{{ $message }}</div>
                            @enderror
                            <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                <input type="checkbox" class="btn-check">
                            </label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check me-2">
                            <input value="1" @if (session()->has('remember')) checked @endif name="remember" type="checkbox" class="form-check-input" id="remember-30">
                            <label for="remember-30" class="form-check-label">Ghi nhớ đăng nhập</label>
                        </div>
                        <div class="nav">
                            <a class="nav-link animate-underline p-0" href="{{ route('client.auth.forgotPassword') }}">
                                <span class="animate-target">Quên mật khẩu?</span>
                            </a>
                        </div>
                    </div>
                    @if (session()->has('error'))
                        <div class="text-danger text-center bg-transparent mb-2">{{ session()->get('error') }}</div>
                    @endif
                    
                    <button type="submit" class="btn btn-lg btn-primary w-100">Đăng nhập</button>
                </form>

                @include('client.layouts.auth_social')

                <!-- Footer -->
                @include('client.layouts.auth_footer')
            </div>
        </div>
    </main>
</x-client.layout.default>
