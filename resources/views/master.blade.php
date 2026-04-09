<!DOCTYPE html>
<html lang="vi" @yield('html-attr')>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('plugin-css')
    @stack('css')

    <title>{{ config('app.name') }}</title>
    <!-- Default SEO meta tags — individual pages can push overrides via @push('head-meta') -->
    <meta name="description" content="{{ config('app.name') }} - Thời trang Việt, phong cách hiện đại">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:description" content="{{ config('app.name') }} - Thời trang Việt, phong cách hiện đại">
    <meta name="twitter:card" content="summary_large_image">
    @stack('head-meta')
    <script>
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
    </script>
    
    <!-- Smooth UX Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <style>
        #nprogress .bar { background: #000 !important; height: 3px !important; }
        html.dark #nprogress .bar, [data-bs-theme="dark"] #nprogress .bar { background: #fff !important; }
        #nprogress .peg { box-shadow: 0 0 10px #000, 0 0 5px #000 !important; }
        html.dark #nprogress .peg, [data-bs-theme="dark"] #nprogress .peg { box-shadow: 0 0 10px #fff, 0 0 5px #fff !important; }
    </style>
</head>
<body @yield('body-attr')>
    @yield('body')
    @stack('plugin-js')
    @stack('js')

    <!-- Smooth UX Scripts (NProgress) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        // NProgress Setup
        NProgress.configure({ showSpinner: false, speed: 400, minimum: 0.1 });
        document.addEventListener('DOMContentLoaded', () => NProgress.start());
        window.addEventListener('load', () => NProgress.done());

        document.addEventListener('click', (e) => {
            const a = e.target.closest('a');
            if(a && a.href && !a.href.startsWith('#') && !a.href.startsWith('javascript') && !a.target && a.origin === window.location.origin) {
                NProgress.start();
            }
        });
    </script>
</body>
</html>