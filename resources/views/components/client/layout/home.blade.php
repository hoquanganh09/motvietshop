<x-client.layout.default>
    @push('plugin-css')
        <link rel="stylesheet" href="{{ asset('plugins/swiper/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/simplebar/simplebar.min.css') }}">
    @endpush
    @push('plugin-js')
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('plugins/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.js') }}"></script>
        <script src="{{ asset('js/customSweetalert2.js') }}"></script>
        @if (session()->has('success'))
            <script>toast("{{ session()->get('success') }}")</script>
        @endif
    @endpush
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endpush

    @include('client.modal.shopping_cart')

    <!-- Search offcanvas -->
    @include('client.layouts.search')


    <!-- Topbar -->
    @include('client.layouts.topbar')

    <!-- Navigation bar (Page header) -->
    @include('client.layouts.header')

    <!-- Page content -->
    <main class="content-wrapper">
        {{ $slot }}
    </main>

    <!-- Page footer -->
    @include('client.layouts.footer')
</x-client.layout.default>
