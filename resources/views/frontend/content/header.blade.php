<div id="header2" class="header4-area">
    <div class="header-top-area">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="header-top-left">
                        <div class="logo-area">

                            <a href="{{ route('frontend.home') }}">
                                @if (empty($footer->logo))
                                    <img
                                        class="img-responsive"
                                        src="{{ asset('Assets/Frontend/img/logo-footer.png') }}"
                                        alt="Logo sekolah"
                                    >
                                @else
                                    <img
                                        class="img-responsive"
                                        src="{{ asset('storage/' . (\Illuminate\Support\Str::contains($footer->logo, '/') ? $footer->logo : 'images/logo/'.$footer->logo)) }}"
                                        alt="{{ $footer->school_name ?? 'Logo sekolah' }}"
                                        onerror="this.onerror=null;this.src='{{ asset('Assets/Frontend/img/logo-footer.png') }}';"
                                    >
                                @endif
                            </a>
                            <div class="school-brand-copy"><strong>{{ $footer->school_name ?? 'SMA Plus Muhammadiyah Merauke' }}</strong><span>{{ $footer->tagline ?? 'Unggul, Islami, dan Berkemajuan' }}</span></div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <div class="header-top-right">
                        <ul>
                            <li>
                                <i class="fa fa-phone" aria-hidden="true"></i>

                                <a href="tel:{{ @$footer->telp }}">
                                    {{ @$footer->telp }}
                                </a>
                            </li>

                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i>

                                <a href="mailto:{{ @$footer->email }}">
                                    {{ @$footer->email }}
                                </a>
                            </li>

                            <li>
                                @auth
                                    <a
                                        href="{{ route('home') }}"
                                        class="apply-now-btn2"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        class="apply-now-btn2"
                                        href="{{ route('login') }}"
                                    >
                                        Masuk
                                    </a>
                                @endauth
                            </li>
                            @auth
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="btn btn-link" style="color:inherit;padding:0;">Keluar</button>
                                </form>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="main-menu-area bg-primary" id="sticker">
        <div class="container">
            <div class="row">

                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                    <nav id="desktop-nav">
                        <ul>

                            <li class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                                <a href="{{ route('frontend.home') }}">
                                    Beranda
                                </a>
                            </li>

                            <li>
                                <a href="#">Tentang Kami</a>

                                <ul>
                                    <li>
                                        <a href="{{ route('profile.sekolah') }}">
                                            Profile Sekolah
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('visimisi.sekolah') }}">
                                            Visi dan Misi
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#">Program</a>

                                <ul>
                                    <li class="has-child-menu">
                                        <a href="#">Program Studi</a>

                                        <ul class="thired-level">
                                            @foreach ($jurusanM as $jurusans)
                                                <li>
                                                    <a href="{{ url('program/' . $jurusans->slug) }}">
                                                        {{ $jurusans->nama }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li class="has-child-menu">
                                        <a href="#">Kegiatan</a>

                                        <ul class="thired-level">
                                            @foreach ($kegiatanM as $kegiatans)
                                                <li>
                                                    <a href="{{ url('kegiatan/' . $kegiatans->slug) }}">
                                                        {{ $kegiatans->nama }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ request()->routeIs('berita') ? 'active' : '' }}">
                                <a href="{{ route('berita') }}">
                                    Berita
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('ppdb.index') }}">
                                    PPDB
                                </a>
                            </li>

                            <li>
                                <a href="#">Lainnya</a>

                                <ul>
                                    <li>
                                        <a href="{{ url('murid/perpustakaan') }}">
                                            Perpustakaan
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('alumni') }}">
                                            Alumni
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>

@php
    $mobileHeaderLogo = !empty($footer->logo)
        ? asset('storage/'.(\Illuminate\Support\Str::contains($footer->logo, '/') ? $footer->logo : 'images/logo/'.$footer->logo))
        : asset('Assets/Frontend/img/logo-footer.png');
@endphp

<!-- Header mobile mandiri: tidak memakai MeanMenu agar lebar halaman tetap stabil. -->
<div class="school-mobile-header" data-school-mobile-header>
    <div class="school-mobile-bar">
        <a class="school-mobile-brand" href="{{ route('frontend.home') }}">
            <img src="{{ $mobileHeaderLogo }}" alt="Logo {{ $footer->school_name ?? 'Sekolah' }}" onerror="this.onerror=null;this.src='{{ asset('Assets/Frontend/img/logo-footer.png') }}';">
            <span>
                <strong>{{ $footer->school_name ?? 'SMA Plus Muhammadiyah Merauke' }}</strong>
                <small>{{ $footer->tagline ?? 'Unggul, Islami, dan Berkemajuan' }}</small>
            </span>
        </a>
        <button class="school-mobile-toggle" type="button" aria-expanded="false" aria-controls="school-mobile-navigation" aria-label="Buka menu navigasi" data-school-mobile-toggle>
            <span></span><span></span><span></span>
        </button>
    </div>

    <nav class="school-mobile-navigation" id="school-mobile-navigation" aria-label="Navigasi mobile" data-school-mobile-navigation hidden>
        <a class="{{ request()->routeIs('frontend.home') ? 'is-active' : '' }}" href="{{ route('frontend.home') }}"><i class="fa fa-home" aria-hidden="true"></i>Beranda</a>

        <details>
            <summary><span><i class="fa fa-university" aria-hidden="true"></i>Tentang Kami</span><i class="fa fa-angle-down" aria-hidden="true"></i></summary>
            <div>
                <a href="{{ route('profile.sekolah') }}">Profil Sekolah</a>
                <a href="{{ route('visimisi.sekolah') }}">Visi dan Misi</a>
                <a href="{{ route('alumni') }}">Alumni</a>
            </div>
        </details>

        <details>
            <summary><span><i class="fa fa-graduation-cap" aria-hidden="true"></i>Program &amp; Kegiatan</span><i class="fa fa-angle-down" aria-hidden="true"></i></summary>
            <div>
                @foreach ($jurusanM as $jurusans)
                    <a href="{{ route('program.detail', $jurusans->slug) }}">{{ $jurusans->nama }}</a>
                @endforeach
                @foreach ($kegiatanM as $kegiatans)
                    <a href="{{ route('kegiatan.detail', $kegiatans->slug) }}">{{ $kegiatans->nama }}</a>
                @endforeach
            </div>
        </details>

        <a class="{{ request()->routeIs('berita') ? 'is-active' : '' }}" href="{{ route('berita') }}"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Berita</a>
        <a href="{{ route('event') }}"><i class="fa fa-calendar" aria-hidden="true"></i>Agenda Sekolah</a>
        <a href="{{ route('ppdb.index') }}"><i class="fa fa-user-plus" aria-hidden="true"></i>PPDB</a>

        @auth
            <a href="{{ route('home') }}"><i class="fa fa-dashboard" aria-hidden="true"></i>Dashboard</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('frontend-mobile-logout').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>Keluar</a>
        @else
            <a class="school-mobile-login" href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>Masuk</a>
        @endauth
    </nav>
</div>
@auth<form id="frontend-mobile-logout" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>@endauth

@push('scripts')
<script>
    (function () {
        var header = document.querySelector('[data-school-mobile-header]');
        if (!header) return;

        var toggle = header.querySelector('[data-school-mobile-toggle]');
        var navigation = header.querySelector('[data-school-mobile-navigation]');

        function closeMenu() {
            navigation.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Buka menu navigasi');
            header.classList.remove('is-open');
        }

        toggle.addEventListener('click', function () {
            var willOpen = navigation.hidden;
            navigation.hidden = !willOpen;
            toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            toggle.setAttribute('aria-label', willOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
            header.classList.toggle('is-open', willOpen);
        });

        navigation.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeMenu();
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) closeMenu();
        });
    })();
</script>
@endpush
