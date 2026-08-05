<!doctype html>
<html class="no-js" lang="">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') - {{ $footer->school_name ?? 'SMA Plus Muhammadiyah Merauke' }}</title>
    <meta name="description" content="{{ $footer->desc ?? 'Website resmi sekolah' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ !empty($footer->favicon) ? asset('storage/'.$footer->favicon) : asset('favicon.ico') }}">
    <style>:root{--school-primary:{{ $footer->primary_color ?? '#087f5b' }};--school-accent:{{ $footer->secondary_color ?? '#f59f00' }};}</style>
    @include('layouts.Frontend.style')
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader" role="status" aria-label="Memuat halaman">
        @php
            $preloaderLogo = !empty($footer->logo)
                ? asset('storage/'.(\Illuminate\Support\Str::contains($footer->logo, '/') ? $footer->logo : 'images/logo/'.$footer->logo))
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
           @include('frontend.content.header')
        </header>
        <!-- Header Area End Here -->

        <!-- Slider 1 Area Start Here -->
        <div class="slider1-area overlay-default">
            @yield('slider')
        </div>
        <!-- Slider 1 Area End Here -->
        
        <!-- About 1 Area Start Here -->
            @yield('about')
        <!-- About 1 Area End Here -->

        <!-- News and Event Area Start Here -->
            @yield('beritaEvent')
        <!-- News and Event Area End Here -->

        <!-- Video Area Start Here -->
            @yield('video')
        <!-- Video Area End Here -->

        <!-- Lecturers Area Start Here -->
            @yield('guru')
        <!-- Lecturers Area End Here -->

        <!-- Social Media Feed Area Start Here -->
            @yield('socialMedia')
        <!-- Social Media Feed Area End Here -->

        <!-- Footer Area Start Here -->
        <footer>
            @include('frontend.content.footer')
        </footer>
        <!-- Footer Area End Here -->
    </div>
    <!-- Main Body Area End Here -->
    @include('layouts.Frontend.scripts')
</body>

</html>
