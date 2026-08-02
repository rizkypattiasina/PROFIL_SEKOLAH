<!DOCTYPE html>
<html
    class="loading semi-dark-layout"
    lang="id"
    data-layout="semi-dark-layout"
    data-textdirection="ltr"
>
<head>
    <meta charset="UTF-8">

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
    >

    <meta
        name="description"
        content="Sekolahku adalah aplikasi manajemen sekolah berbasis website yang dibangun dan dikembangkan menggunakan Framework Laravel."
    >

    <meta
        name="keywords"
        content="sekolah, manajemen sekolah, aplikasi sekolah, laravel"
    >

    <meta
        name="author"
        content="Andri Desmana"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'SekolahKu')
    </title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500;1,600&display=swap"
        rel="stylesheet"
    >

    {{-- CSS utama template backend --}}
    @include('layouts.backend.style')

    {{-- CSS tambahan dari halaman tertentu --}}
    @stack('styles')

    {{-- CSS tambahan alternatif jika masih memakai @section('styles') --}}
    @yield('styles')
</head>

<body
    class="vertical-layout vertical-menu-modern navbar-floating footer-static"
    data-open="click"
    data-menu="vertical-menu-modern"
    data-col=""
>

    {{-- Header --}}
    @include('layouts.backend.header')

    {{-- Sidebar/Menu --}}
    @include('layouts.backend.menu')

    {{-- Konten utama --}}
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        @yield('content')
    </div>

    {{-- Overlay sidebar --}}
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    {{-- Footer --}}
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0">

            <span class="float-md-left d-block d-md-inline-block mt-25">
                COPYRIGHT &copy; {{ date('Y') }}

                <a
                    class="ml-25"
                    href="https://andridesmana.pw"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Andri Desmana
                </a>

                <span class="d-none d-sm-inline-block">
                    , All rights Reserved
                </span>
            </span>

            <span class="float-md-right d-none d-md-block">
                Hand-crafted &amp; Made with
                <i data-feather="heart"></i>
            </span>

        </p>
    </footer>

    {{-- Tombol kembali ke atas --}}
    <button
        class="btn btn-primary btn-icon scroll-top"
        type="button"
        aria-label="Kembali ke atas"
    >
        <i data-feather="arrow-up"></i>
    </button>

    {{-- JavaScript utama template backend --}}
    @include('layouts.backend.scripts')

    {{-- JavaScript tambahan alternatif jika masih memakai @section('scripts') --}}
    @yield('scripts')

    {{-- JavaScript tambahan dari halaman tertentu --}}
    @stack('scripts')
</body>
</html>