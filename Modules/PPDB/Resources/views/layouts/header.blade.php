@php
    $schoolName = @$footer->school_name ?: 'SMA Plus Muhammadiyah Merauke';
    $logoUrl = @$footer->logo
        ? asset('storage/'.(str_contains($footer->logo, '/') ? $footer->logo : 'images/logo/'.$footer->logo))
        : asset('Assets/Frontend/img/logo-footer.png');
@endphp
<div id="header1" class="header1-area ppdb-header">
    <div class="main-menu-area" id="sticker">
        <div class="container">
            <div class="row ppdb-nav-row">
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="logo-area ppdb-brand">
                        <a href="{{ route('frontend.home') }}">
                            <img class="img-responsive" src="{{ $logoUrl }}" alt="Logo {{ $schoolName }}">
                            <span>{{ $schoolName }}</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-8">
                    <nav id="desktop-nav">
                        <ul>
                            <li><a href="#program">Program</a></li>
                            <li><a href="#alur">Alur</a></li>
                            <li><a href="#berkas">Berkas</a></li>
                            <li><a href="#informasi">Informasi</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-4 col-md-4 hidden-sm">
                    <div class="apply-btn-area">
                        @auth
                            <a href="{{ route('home') }}" class="apply-now-btn3">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline-block;margin:0;">@csrf<button type="submit" class="apply-now-btn">Keluar</button></form>
                        @else
                            <a href="{{ route('login') }}" class="apply-now-btn3">Login</a>
                            <a href="{{ route('ppdb.register') }}" class="apply-now-btn">Daftar PPDB</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mobile-menu-area ppdb-mobile-menu">
    <div class="container">
        <div class="ppdb-mobile-logo">
            <a href="{{ route('frontend.home') }}"><img src="{{ $logoUrl }}" alt="Logo {{ $schoolName }}"><span>{{ $schoolName }}</span></a>
        </div>
        <div class="row"><div class="col-md-12"><div class="mobile-menu">
            <nav id="dropdown"><ul>
                <li><a href="#program">Program</a></li>
                <li><a href="#alur">Alur Pendaftaran</a></li>
                <li><a href="#berkas">Berkas</a></li>
                <li><a href="#informasi">Informasi</a></li>
                @auth<li><a href="{{ route('home') }}">Dashboard</a></li><li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('ppdb-mobile-logout').submit();">Keluar</a></li>
                @else<li><a href="{{ route('login') }}">Login</a></li><li><a href="{{ route('ppdb.register') }}">Daftar PPDB</a></li>@endauth
            </ul></nav>
        </div></div></div>
    </div>
</div>
@auth<form id="ppdb-mobile-logout" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>@endauth
