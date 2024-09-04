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
</head>
<body @yield('body-attr')>
    @yield('body')
    @stack('plugin-js')
    @stack('js')
</body>
</html>