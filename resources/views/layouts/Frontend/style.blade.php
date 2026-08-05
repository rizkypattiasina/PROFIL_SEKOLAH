<!-- Normalize CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/normalize.css')}}">
<!-- Main CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/main.css')}}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/bootstrap.min.css')}}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/animate.min.css')}}">
<!-- Font-awesome CSS-->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/font-awesome.min.css')}}">
<!-- Owl Caousel CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/vendor/OwlCarousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('Assets/Frontend/vendor/OwlCarousel/owl.theme.default.min.css')}}">
<!-- Main Menu CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/meanmenu.min.css')}}">
<!-- nivo slider CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/vendor/slider/css/nivo-slider.css')}}" type="text/css" />
<link rel="stylesheet" href="{{asset('Assets/Frontend/vendor/slider/css/preview.css')}}" type="text/css" media="screen" />
<!-- Datetime Picker Style CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/jquery.datetimepicker.css')}}">
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/select2.min.css')}}">
<!-- Magic popup CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/magnific-popup.css')}}">
<!-- Switch Style CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/hover-min.css')}}">
<!-- ReImageGrid CSS -->
<link rel="stylesheet" href="{{asset('Assets/Frontend/css/reImageGrid.css')}}">
<!-- Custom CSS -->
@php
    $mainCssPath = public_path('Assets/Frontend/style.css');
    $socialFooterCssPath = public_path('Assets/Frontend/css/social-footer.css');
    $responsiveModernCssPath = public_path('Assets/Frontend/css/responsive-modern.css');
@endphp
<link rel="stylesheet" href="{{ asset('Assets/Frontend/style.css') }}?v={{ file_exists($mainCssPath) ? filemtime($mainCssPath) : '1' }}">
<!-- Media Social & Footer CSS (dipisahkan agar tidak memakai cache lama) -->
<link rel="stylesheet" href="{{ asset('Assets/Frontend/css/social-footer.css') }}?v={{ file_exists($socialFooterCssPath) ? filemtime($socialFooterCssPath) : '1' }}">
<!-- Lapisan responsif terakhir untuk header, pengajar, halaman utama, dan footer -->
<link rel="stylesheet" href="{{ asset('Assets/Frontend/css/responsive-modern.css') }}?v={{ file_exists($responsiveModernCssPath) ? filemtime($responsiveModernCssPath) : '1' }}">
<!-- Modernizr Js -->
<script src="{{asset('Assets/Frontend/js/modernizr-2.8.3.min.js')}}"></script>
