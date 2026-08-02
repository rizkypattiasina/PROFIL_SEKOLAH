@extends('layouts.Frontend.app')

@section('title')
    Profil Sekolah
@endsection

@section('content')

    @section('about')
        <div class="container">
            @if ($profile)
                <div class="profile-image-wrapper">
                    <img
                        src="{{ asset('storage/images/profileSekolah/' . $profile->image) }}"
                        class="img-responsive profile-image"
                        alt="{{ $profile->title }}"
                    >
                </div>

                <h2 class="title-center">
                    {{ $profile->title }}
                </h2>

                <div class="profile-content">
                    {!! $profile->content !!}
                </div>
            @else
                <div class="profile-empty">
                    <img
                        src="{{ asset('Assets/Frontend/img/empty.svg') }}"
                        class="img-responsive"
                        alt="Data profil sekolah belum tersedia"
                    >

                    <p>Data profil sekolah belum tersedia.</p>
                </div>
            @endif
        </div>

        <style>
            .profile-image-wrapper {
                margin-top: 5%;
                margin-bottom: 3%;
            }

            .profile-image {
                width: 100%;
                max-height: 500px;
                object-fit: cover;
                border-radius: 4px;
            }

            .profile-content {
                color: #333;
                font-size: 16px;
                line-height: 1.8;
                margin-bottom: 30px;
                overflow-wrap: break-word;
            }

            .profile-content p {
                margin-bottom: 15px;
            }

            .profile-content h1,
            .profile-content h2,
            .profile-content h3,
            .profile-content h4,
            .profile-content h5,
            .profile-content h6 {
                margin-top: 24px;
                margin-bottom: 12px;
                line-height: 1.4;
                color: #222;
            }

            .profile-content ul,
            .profile-content ol {
                margin-bottom: 18px;
                padding-left: 30px;
            }

            .profile-content li {
                margin-bottom: 8px;
            }

            .profile-content img {
                max-width: 100%;
                height: auto;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .profile-content table {
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
            }

            .profile-content table,
            .profile-content th,
            .profile-content td {
                border: 1px solid #ddd;
            }

            .profile-content th,
            .profile-content td {
                padding: 10px;
                vertical-align: top;
            }

            .profile-content a {
                color: #007bff;
                text-decoration: underline;
            }

            .profile-content blockquote {
                padding: 12px 20px;
                margin: 15px 0;
                border-left: 4px solid #ddd;
                background-color: #f8f8f8;
            }

            .profile-empty {
                margin-top: 5%;
                margin-bottom: 5%;
                text-align: center;
            }

            .profile-empty img {
                display: block;
                max-width: 400px;
                margin: 0 auto 20px;
            }

            @media (max-width: 767px) {
                .profile-content {
                    font-size: 15px;
                    line-height: 1.7;
                }

                .profile-image {
                    max-height: 300px;
                }
            }
        </style>
    @endsection

    {{-- Guru --}}
    @section('guru')
        @include('frontend.content.guru')
    @endsection

@endsection