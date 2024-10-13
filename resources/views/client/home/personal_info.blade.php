<x-client.layout.home>
    <div class="container py-5">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('client.home.common.user_sidebar')


            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title -->
                    <h1 class="h2 mb-1 mb-sm-2">Thông tin cá nhân</h1>

                    <!-- Basic info -->
                    <div class="border-bottom py-4">
                        @php
                            $errorInfo = $errors->has('fullname') || $errors->has('date_of_birth');
                        @endphp
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <h2 class="h6 mb-0">Thông tin cơ bản</h2>
                            <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                href=".basic-info" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="basicInfoPreview basicInfoEdit">Chỉnh sửa</a>
                        </div>
                        <div class="basic-info collapse @if (!$errorInfo) show @endif"
                            id="basicInfoPreview" style="">
                            <ul class="list-unstyled fs-sm m-0">
                                <li>{{ $user->fullname }}</li>
                                <li>{{ $user->date_of_birth }}</li>
                            </ul>
                        </div>
                        <div class="basic-info collapse @if ($errorInfo) show @endif"
                            id="basicInfoEdit" style="">
                            <form class="row g-3 g-sm-4" action="{{ route('client.auth.changeInfo') }}" method="post">
                                @csrf
                                @method('put')
                                <div class="col-sm-6">
                                    <label for="fn" class="form-label">Họ và tên
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input name="fullname" type="text"
                                            class="form-control @error('fullname') is-invalid @enderror" id="fn"
                                            value="{{ old('fullname', $user->fullname) }}">
                                        @error('fullname')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="birthdate" class="form-label">Ngày sinh</label>
                                    <div class="position-relative">
                                        <input value="{{ old('date_of_birth', $user->date_of_birth) }}" id="birthdate"
                                            name="date_of_birth" type="date" class="form-control form-icon-end">
                                        <i
                                            class="show-date-picker ci-calendar position-absolute top-50 end-0 translate-middle-y me-3"></i>
                                    </div>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3 pt-2 pt-sm-0">
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                        <button type="button" class="btn btn-secondary collapsed"
                                            data-bs-toggle="collapse" data-bs-target=".basic-info" aria-expanded="false"
                                            aria-controls="basicInfoPreview basicInfoEdit">Đóng</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="border-bottom py-4">
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <div class="d-flex align-items-center gap-3 me-4">
                                <h2 class="h6 mb-0">Liên hệ</h2>
                            </div>
                            <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                href=".contact-info" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="contactInfoPreview contactInfoEdit">Chỉnh sửa</a>
                        </div>
                        @php
                            $errorContact = $errors->has('email') || $errors->has('phone_number');
                        @endphp
                        <div class="contact-info collapse @if (!$errorContact) show @endif"
                            id="contactInfoPreview" style="">
                            <ul class="list-unstyled fs-sm m-0">
                                <li class="mb-1">{{ $user->email }}
                                    @if ($user->isEmailVerified())
                                        <span class="text-success ms-1">Đã xác thực</span>
                                    @else
                                        <span class="text-danger ms-1">Chưa xác thực</span>

                                        @if (!session()->has('success_verify_email'))
                                            <a href="{{ route('verification.notice') }}" class="ms-2">Xác thực
                                                ngay</a>
                                        @else
                                            <span class="ms-2 timming" data-second="30"></span>
                                            <a class="text-secondary resend-verify-email"
                                                href="{{ route('verification.notice') }}">Gửi lại</a>
                                        @endif
                                    @endif
                                </li>
                                <li>{{ $user->phone_number }}</li>
                            </ul>
                        </div>
                        <div class="contact-info collapse @if ($errorContact) show @endif"
                            id="contactInfoEdit" style="">
                            <form class="row g-3 g-sm-4" method="post"
                                action="{{ route('client.auth.changeContact') }}">
                                @csrf
                                @method('put')
                                <div class="col-sm-6">
                                    <label for="email" class="form-label">Địa chỉ email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input name="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div style="display: block;" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <div class="position-relative">
                                        <input type="number" name="phone_number"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone" value="{{ old('phone_number', $user->phone_number) }}">
                                        @error('phone_number')
                                            <div style="display: block;" class="invalid-feedback">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3 pt-2 pt-sm-0">
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                        <button type="button" class="btn btn-secondary collapsed"
                                            data-bs-toggle="collapse" data-bs-target=".contact-info"
                                            aria-expanded="false"
                                            aria-controls="contactInfoPreview contactInfoEdit">Đóng</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="border-bottom py-4">
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <div class="d-flex align-items-center gap-3 me-4">
                                <h2 class="h6 mb-0">Mật khẩu</h2>
                            </div>
                            <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                href=".password-change" data-bs-toggle="collapse" aria-expanded="false"
                                aria-controls="passChangePreview passChangeEdit">Chỉnh sửa</a>
                        </div>
                        @php
                            $errorPassword = $errors->has('new_password') || $errors->has('current_password');
                        @endphp
                        <div class="password-change collapse @if (!$errorPassword) show @endif"
                            id="passChangePreview" style="">
                            <ul class="list-unstyled fs-sm m-0">
                                <li>**************</li>
                            </ul>
                        </div>
                        <div class="password-change collapse @if ($errorPassword) show @endif"
                            id="passChangeEdit" style="">
                            <form method="POST" class="row g-3 g-sm-4"
                                action="{{ route('client.auth.changePassword') }}">
                                @method('put')
                                @csrf
                                <div class="col-sm-6">
                                    <label for="current-password" class="form-label">Mật khẩu hiện tại</label>
                                    <div class="password-toggle">
                                        <input name="current_password" type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current-password" value="{{ old('current_password') }}">
                                        <label class="password-toggle-button" aria-label="Show/hide password">
                                            <input type="checkbox" class="btn-check">
                                        </label>
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="new-password" class="form-label">
                                        Mật khẩu mới
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="password-toggle">
                                        <input name="new_password" type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            id="new-password" value="{{ old('new_password') }}">
                                        <label class="password-toggle-button" aria-label="Show/hide password">
                                            <input type="checkbox" class="btn-check">
                                        </label>
                                    </div>
                                    @error('new_password')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3 pt-2 pt-sm-0">
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                        <button type="button" class="btn btn-secondary collapsed"
                                            data-bs-toggle="collapse" data-bs-target=".password-change"
                                            aria-expanded="false"
                                            aria-controls="passChangePreview passChangeEdit">Đóng</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('input[type=date],.show-date-picker').on('click', showPopupDatePicker);

            function showPopupDatePicker() {
                document.querySelector('input[type=date]').showPicker();
            }

            $(document).on('click', '.resend-verify-email.text-secondary', function(e) {
                e.preventDefault();
                console.log(123);

            });

            @if (session()->has('success_verify_email'))
                $(() => {
                    const timing = $('.timming');
                    let clear = null;
                    let time = timing[0].dataset.second;

                    timing.html(time + 's');

                    clear = setInterval(() => {
                        if (time == 1) {
                            clearInterval(clear);
                            $('.resend-verify-email').removeClass('text-secondary');
                            timing.html('');
                        } else {
                            time -= 1;
                            timing.html(time + 's');
                        }
                    }, 1000);
                });
            @endif
        </script>
    @endpush
</x-client.layout.home>
