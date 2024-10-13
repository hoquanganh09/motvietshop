@extends('master')

@section('html-attr')
    data-bs-theme="light"
@endsection
@section('body-attr')
    class="app-blank app-blank"
@endsection

@push('plugin-css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="stylesheet" href="{{ asset('templates/keen/css/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/keen/css/style.bundle.css') }}">
    
@endpush

{{-- @push('css')
    <link rel="stylesheet" href="{{ asset('templates/font/css/theme.min.css') }}">
@endpush --}}

@push('plugin-js')
    <script src="{{ asset('templates/keen/js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('templates/keen/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/customAxios.js') }}"></script>
    <script src="{{ asset('js/customSweetalert2.js') }}"></script>
@endpush

@push('js')
    <script>
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
        // window.axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
        window.axios.defaults.headers.common['Accept'] = 'application/json';
    </script>
@endpush

@section('body')
    {{ $slot }}
    <div id="view_ajax"></div>
@endsection
