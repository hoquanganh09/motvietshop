{{-- <x-client.layout.default>
    <!-- Page content -->
    <main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto" style="max-width: 1920px">
        <div class="d-lg-flex">

            <!-- Login form + Footer -->
            <div class="d-flex flex-column min-vh-100 w-100 py-4 mx-auto me-lg-51 border-1 border-red-50"
                style="max-width: 416px">

                <!-- Logo -->
                @include('client.layouts.auth_header')

                <h1 class="h2 mt-auto">Xác thực email</h1>
                <p class="pb-2 pb-md-3">Enter the email address you used when you joined and we’ll send you instructions
                    to reset your password</p>

                <!-- Form -->
                <form class="needs-validation pb-4 mb-3 mb-lg-4" novalidate="">
                    <div class="position-relative mb-4">
                        <i class="ci-mail position-absolute top-50 start-0 translate-middle-y fs-lg ms-3"></i>
                        <input type="email" class="form-control form-control-lg form-icon-start"
                            placeholder="Email address" required="">
                        <div class="invalid-tooltip bg-transparent py-0">Please enter a vaild email address!</div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary w-100">Gửi lại</button>
                </form>

                <!-- Footer -->
                @include('client.layouts.auth_footer')
            </div>
        </div>
    </main>
</x-client.layout.default> --}}
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
                        <div class="pb-1 mb-3">
                            <h2 class="h6 mb-0">Xác thực email</h2>
                            <p>Enter the email address you used when you joined and we’ll send you instructions
                                to reset your password</p>
                        </div>
                        <div class="basic-info collapse show"
                            id="basicInfoPreview" style="">
                            <form class="needs-validation pb-4 mb-3 mb-lg-4" novalidate="">
                                <button type="submit" class="btn btn-lg btn-primary w-100">Gửi lại</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-client.layout.home>
