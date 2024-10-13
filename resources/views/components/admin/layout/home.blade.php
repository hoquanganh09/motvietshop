<x-admin.layout.default>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endpush

    @push('plugin-css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('plugin-js')
    @endpush

    @section('body-attr')
        id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
        data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
        data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
        class="app-default"
    @endsection
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
            @include('admin.layouts.header')

            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
                @include('admin.layouts.sidebar')
                <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                    {{ $slot }}
            
                    @include('admin.layouts.footer')
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        @push('js')
            <script>
                $(() => {
                    toast(`{{ session()->get('success') }}`);
                });
            </script>
        @endpush
    @endif
</x-admin.layout.default>
