<!doctype html>
<html class="no-js" lang="">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="Informasi dan pendaftaran peserta didik baru {{ @$footer->school_name ?: 'SMA Plus Muhammadiyah Merauke' }}.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ @$footer->favicon ? asset('storage/'.(str_contains($footer->favicon, '/') ? $footer->favicon : 'images/favicon/'.$footer->favicon)) : asset('Assets/Frontend/img/favicon.png') }}">
    <style>:root{--school-primary:{{ $footer->primary_color ?? '#087f5b' }};--school-accent:{{ $footer->secondary_color ?? '#f59f00' }};}</style>
    @include('layouts.Frontend.style')
</head>

<body class="ppdb-public-page">
    <!-- Preloader Start Here -->
    <div id="preloader" role="status" aria-label="Memuat halaman">
        @php
            $preloaderLogo = !empty($footer->logo)
                ? asset('storage/'.(str_contains($footer->logo, '/') ? $footer->logo : 'images/logo/'.$footer->logo))
                : asset('Assets/Frontend/img/logo-footer.png');
        @endphp
        <img src="{{ $preloaderLogo }}" alt="Logo {{ $footer->school_name ?? 'Sekolah' }}">
    </div>
    <!-- Preloader End Here -->
    <!-- Main Body Area Start Here -->
    <div id="wrapper">
        @yield('content')
        <!-- Header Area Start Here -->
        <header>
           @include('ppdb::layouts.header')
        </header>
        <!-- Header Area End Here -->

        
        @yield('slider')

        <div class="about2-area">
            @yield('studi')
        </div>

        
        @yield('count')

        
        @yield('why')

        
        @yield('video')

        <!-- Footer Area Start Here -->
        <footer>
            @include('ppdb::layouts.footer')
        </footer>
        <!-- Footer Area End Here -->
    </div>
    <!-- Main Body Area End Here -->
    @include('layouts.Frontend.scripts')
</body>

</html>
