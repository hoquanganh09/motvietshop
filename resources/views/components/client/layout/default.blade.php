@extends('master')

@section('html-attr')
    data-bs-theme="light"
@endsection
@section('body-attr')
    class="app-blank app-blank"
@endsection

@push('plugin-css')
    <link rel="preload" href="{{ asset('templates/cartzilla/fonts/inter-variable-latin.woff2') }}" as="font"
        type="font/woff2" crossorigin="">
    <link rel="preload" href="{{ asset('templates/cartzilla/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2"
        crossorigin="">
    <link rel="stylesheet" href="{{ asset('templates/cartzilla/icons/cartzilla-icons.min.css') }}">
    <link rel="preload" href="{{ asset('templates/cartzilla/css/theme.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('templates/cartzilla/css/theme.min.css') }}" id="theme-styles">
@endpush

{{-- @push('css')
    <link rel="stylesheet" href="{{ asset('templates/font/css/theme.min.css') }}">
@endpush --}}

@push('plugin-js')
    <script src="{{ asset('templates/cartzilla/js/customizer.min.js') }}"></script>
    <script src="{{ asset('templates/cartzilla/js/theme.min.js') }}"></script>
    <script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
    <script src="{{ asset('js/customAxios.js') }}"></script>
@endpush

@push('js')
    <script>
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
        window.axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
        
        // Auto NProgress for all API Calls
        axios.interceptors.request.use(config => {
            if (typeof NProgress !== 'undefined') NProgress.start();
            return config;
        });
        axios.interceptors.response.use(response => {
            if (typeof NProgress !== 'undefined') NProgress.done();
            return response;
        }, error => {
            if (typeof NProgress !== 'undefined') NProgress.done();
            // Show global error toast; skip 422 (validation errors handled per-form)
            const status = error?.response?.status;
            if (status && status !== 422 && typeof toast === 'function') {
                const msg = error?.response?.data?.message || 'Có lỗi xảy ra. Vui lòng thử lại.';
                toast(msg, 'error');
            }
            return Promise.reject(error);
        });
        
        $(() => {
            const toggleThemeBtn = $('#themeToggleBtn');
            const icon = toggleThemeBtn.find('i');
            
            const currentTheme = localStorage.getItem('theme') || 'light';
            if (currentTheme === 'dark') {
                icon.removeClass('ci-moon').addClass('ci-sun');
            }

            toggleThemeBtn.on('click', function () {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                const newTheme = isDark ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                if (newTheme === 'dark') {
                    icon.removeClass('ci-moon').addClass('ci-sun');
                } else {
                    icon.removeClass('ci-sun').addClass('ci-moon');
                }
            });
        });
    </script>
@endpush

@section('body')
    {{ $slot }}
    <!-- Customizer offcanvas -->
    <div class="offcanvas offcanvas-end" id="customizer" tabindex="-1">
        <div class="offcanvas-header border-bottom">
            <h4 class="h5 offcanvas-title">Customize theme</h4>
            <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <!-- Customizer settings -->
            <div class="customizer-collapse collapse show" id="customizerSettings">

                <!-- Colors -->
                <div class="pb-4 mb-2">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ci-paint text-body-tertiary fs-5 me-2"></i>
                        <h5 class="fs-lg mb-0">Colors</h5>
                    </div>
                    <div class="row row-cols-2 g-3" id="theme-colors">
                        <div class="col">
                            <h6 class="fs-sm mb-2">Primary</h6>
                            <div class="color-swatch d-flex border rounded gap-3 p-2" id="theme-primary"
                                data-color-labels="[&quot;theme-primary&quot;, &quot;primary&quot;, &quot;primary-rgb&quot;]">
                                <input type="text" class="form-control bg-transparent border-0 rounded-0 p-1"
                                    value="#f55266">
                                <label for="primary"
                                    class="ratio ratio-1x1 flex-shrink-0 w-100 cursor-pointer rounded-circle"
                                    style="max-width: 38px; background-color: #f55266"></label>
                                <input type="color" class="visually-hidden" id="primary" value="#f55266">
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fs-sm mb-2">Success</h6>
                            <div class="color-swatch d-flex border rounded gap-3 p-2" id="theme-success"
                                data-color-labels="[&quot;theme-success&quot;, &quot;success&quot;, &quot;success-rgb&quot;]">
                                <input type="text" class="form-control bg-transparent border-0 rounded-0 p-1"
                                    value="#33b36b">
                                <label for="success"
                                    class="ratio ratio-1x1 flex-shrink-0 w-100 cursor-pointer rounded-circle"
                                    style="max-width: 38px; background-color: #33b36b"></label>
                                <input type="color" class="visually-hidden" id="success" value="#33b36b">
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fs-sm mb-2">Warning</h6>
                            <div class="color-swatch d-flex border rounded gap-3 p-2" id="theme-warning"
                                data-color-labels="[&quot;theme-warning&quot;, &quot;warning&quot;, &quot;warning-rgb&quot;]">
                                <input type="text" class="form-control bg-transparent border-0 rounded-0 p-1"
                                    value="#fc9231">
                                <label for="warning"
                                    class="ratio ratio-1x1 flex-shrink-0 w-100 cursor-pointer rounded-circle"
                                    style="max-width: 38px; background-color: #fc9231"></label>
                                <input type="color" class="visually-hidden" id="warning" value="#fc9231">
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fs-sm mb-2">Danger</h6>
                            <div class="color-swatch d-flex border rounded gap-2 p-2" id="theme-danger"
                                data-color-labels="[&quot;theme-danger&quot;, &quot;danger&quot;, &quot;danger-rgb&quot;]">
                                <input type="text" class="form-control bg-transparent border-0 rounded-0 p-1"
                                    value="#f03d3d">
                                <label for="danger"
                                    class="ratio ratio-1x1 flex-shrink-0 w-100 cursor-pointer rounded-circle"
                                    style="max-width: 38px; background-color: #f03d3d"></label>
                                <input type="color" class="visually-hidden" id="danger" value="#f03d3d">
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fs-sm mb-2">Info</h6>
                            <div class="color-swatch d-flex border rounded gap-2 p-2" id="theme-info"
                                data-color-labels="[&quot;theme-info&quot;, &quot;info&quot;, &quot;info-rgb&quot;]">
                                <input type="text" class="form-control bg-transparent border-0 rounded-0 p-1"
                                    value="#2f6ed5">
                                <label for="info"
                                    class="ratio ratio-1x1 flex-shrink-0 w-100 cursor-pointer rounded-circle"
                                    style="max-width: 38px; background-color: #2f6ed5"></label>
                                <input type="color" class="visually-hidden" id="info" value="#2f6ed5">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Direction -->
                <div class="pb-4 mb-2">
                    <div class="d-flex align-items-center pb-1 mb-2">
                        <i class="ci-sort text-body-tertiary fs-lg me-2" style="transform: rotate(90deg)"></i>
                        <h5 class="fs-lg mb-0">Direction</h5>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border rounded p-3">
                        <div class="me-3">
                            <h6 class="mb-1">RTL</h6>
                            <p class="fs-sm mb-0">Change text direction</p>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input type="checkbox" class="form-check-input" role="switch" id="rtl-switch">
                        </div>
                    </div>
                    <div class="alert alert-info p-2 mt-2 mb-0">
                        <div class="d-flex text-body-emphasis fs-xs py-1 pe-1">
                            <i class="ci-info text-info fs-lg mb-2 mb-sm-0" style="margin-top: .125rem"></i>
                            <div class="ps-2">To switch the text direction of your webpage from LTR to RTL,
                                please consult the detailed instructions provided in the relevant section of our
                                documentation.</div>
                        </div>
                    </div>
                </div>

                <!-- Border width -->
                <div class="pb-4 mb-2">
                    <div class="d-flex align-items-center pb-1 mb-2">
                        <i class="ci-menu text-body-tertiary fs-lg me-2"></i>
                        <h5 class="fs-lg mb-0">Border width, px</h5>
                    </div>
                    <div class="slider-input d-flex align-items-center gap-3 border rounded p-3" id="border-input">
                        <input type="range" class="form-range" min="0" max="10" step="1"
                            value="1">
                        <input type="number" class="form-control" id="border-width" min="0" max="10"
                            value="1" style="max-width: 5.5rem">
                    </div>
                </div>

                <!-- Rounding -->
                <div class="d-flex align-items-center pb-1 mb-2">
                    <i class="ci-maximize text-body-tertiary fs-lg me-2"></i>
                    <h5 class="fs-lg mb-0">Rounding, rem</h5>
                </div>
                <div class="slider-input d-flex align-items-center gap-3 border rounded p-3">
                    <input type="range" class="form-range" min="0" max="5" step=".05"
                        value="0.5">
                    <input type="number" class="form-control" id="border-radius" min="0" max="5"
                        step=".05" value="0.5" style="max-width: 5.5rem">
                </div>
            </div>

            <!-- Customizer code -->
            <div class="customizer-collapse collapse" id="customizerCode">
                <div class="nav mb-3">
                    <a class="nav-link animate-underline fs-base p-0" href=".customizer-collapse"
                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="customizerSettings customizerCode">
                        <i class="ci-chevron-left fs-lg ms-n1 me-1"></i>
                        <span class="animate-target">Back to settings</span>
                    </a>
                </div>
                <p class="fs-sm pb-1">To apply the provided styles to your webpage, enclose them within a
                    <code>&lt;style&gt;</code> tag and insert this tag into the <code>&lt;head&gt;</code> section of
                    your HTML document after the following link to the main stylesheet:<br><code>&lt;link
                        href="assets/css/theme.min.css"&gt;</code>
                </p>
                <div class="position-relative bg-body-tertiary rounded overflow-hidden pt-3">
                    <div class="position-absolute top-0 start-0 w-100 p-3">
                        <button type="button" class="btn btn-sm btn-outline-dark w-100"
                            data-copy-text-from="#generated-styles" data-done-label="Code copied">
                            <i class="ci-copy fs-sm me-1"></i>
                            Copy code
                        </button>
                    </div>
                    <pre class="text-wrap bg-transparent border-0 fs-xs text-body-emphasis p-4 pt-5" id="generated-styles"></pre>
                </div>
            </div>
        </div>

        <!-- Offcanvas footer (Action buttons) -->
        <div class="offcanvas-header border-top gap-3 d-none" id="customizer-btns">
            <button type="button" class="btn btn-lg btn-secondary w-100 fs-sm" id="customizer-reset">
                <i class="ci-trash fs-lg me-2 ms-n1"></i>
                Reset
            </button>
            <button class="btn btn-lg btn-primary hiding-collapse-toggle w-100 fs-sm collapsed" type="button"
                data-bs-toggle="collapse" data-bs-target=".customizer-collapse" aria-expanded="false"
                aria-controls="customizerSettings customizerCode">
                <i class="ci-code fs-lg me-2 ms-n1"></i>
                Show code
            </button>
        </div>
    </div>
    <!-- Customizer toggle -->
    <div class="d-none floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
        <a class="btn btn-sm btn-outline-secondary text-uppercase bg-body rounded-pill shadow animate-rotate ms-2 me-n5"
            href="#customizer" style="font-size: .625rem; letter-spacing: .05rem;" data-bs-toggle="offcanvas"
            role="button" aria-controls="customizer">
            Customize<i class="ci-settings fs-base ms-1 me-n2 animate-target"></i>
        </a>
    </div>
    <!-- back to top -->
    <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
        <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
            Top
            <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
            <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
            <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor"
                    stroke-width="1.5" stroke-miterlimit="10"></rect>
            </svg>
        </a>
    </div>

    <!-- Floating compare bar (visible when ≥ 1 product added) -->
    @php $compareCount = count(session('compare', [])); @endphp
    <div id="compareBar"
        class="position-fixed bottom-0 start-0 w-100 bg-body border-top shadow-lg py-2 px-3 z-sticky d-flex align-items-center gap-3"
        style="transition: transform .3s ease; {{ $compareCount > 0 ? '' : 'transform: translateY(100%);' }}">
        <i class="ci-repeat fs-lg text-dark flex-shrink-0"></i>
        <span class="fw-semibold fs-sm me-auto">
            So sánh (<span id="compareBarCount">{{ $compareCount }}</span>/3 sản phẩm)
        </span>
        <a id="compareBarBtn" href="{{ route('client.compare.index') }}"
            class="btn btn-dark btn-sm {{ $compareCount < 2 ? 'disabled' : '' }}">
            So sánh ngay
        </a>
        <button type="button" id="compareBarClear" class="btn btn-outline-secondary btn-sm">
            Xóa tất cả
        </button>
    </div>

    @push('js')
        <script>
            // Global helper to show/hide and update compare bar
            function updateCompareBar(count) {
                const $bar = $('#compareBar');
                const $cnt = $('#compareBarCount');
                const $btn = $('#compareBarBtn');
                $cnt.text(count);
                if (count > 0) {
                    $bar.css('transform', 'translateY(0)');
                } else {
                    $bar.css('transform', 'translateY(100%)');
                }
                if (count >= 2) {
                    $btn.removeClass('disabled');
                } else {
                    $btn.addClass('disabled');
                }
            }

            $(() => {
                $(document).on('click', '.btn-add-to-compare', function () {
                    const url = $(this).data('url');
                    ajax(url, 'post', {}, function (res) {
                        toast(res.data.message);
                        updateCompareBar(res.data.count);
                    }, function (err) {
                        const msg = err?.response?.data?.message || 'Có lỗi xảy ra';
                        toast(msg, 'error');
                    });
                });

                $('#compareBarClear').on('click', function () {
                    ajax('{{ route('client.compare.clear') }}', 'delete', {}, function (res) {
                        toast(res.data.message);
                        updateCompareBar(0);
                    });
                });
            });
        </script>
    @endpush
@endsection
