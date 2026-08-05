@extends('layouts.Frontend.app')

@section('title')
    Berita
@endsection

@section('content')
    @section('about')
    <section class="school-page-hero news-page-hero">
        <div class="container">
            <span>Informasi Sekolah</span>
            <h1>Berita Terbaru</h1>
            <p>Ikuti kabar, prestasi, kegiatan, dan informasi terkini dari sekolah kami.</p>
            <form class="public-news-search" action="{{ route('berita') }}" method="GET">
                <label class="sr-only" for="news-search">Cari berita</label>
                <input id="news-search" type="search" name="q" value="{{ $search ?? request('q') }}" placeholder="Cari judul atau isi berita...">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
            </form>
        </div>
    </section>
    <div class="news-page-area">
        <div class="container">
            <div class="row news-page-layout">
                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                    @if(!empty($search))
                        <div class="public-news-result">Hasil pencarian untuk <strong>“{{ $search }}”</strong>: {{ $berita->total() }} berita</div>
                    @endif
                    <div class="row news-card-grid">
                        @foreach ($berita as $beritas)
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 news-card-column">
                                <article class="public-news-card">
                                    <a class="public-news-image" href="{{route('detail.berita', $beritas->slug)}}">
                                        <img src="{{asset('storage/images/berita/' .$beritas->thumbnail)}}" alt="{{$beritas->title}}" loading="lazy">
                                        <span class="public-news-date">
                                            <strong>{{Carbon\Carbon::parse($beritas->created_at)->format('d')}}</strong>
                                            {{Carbon\Carbon::parse($beritas->created_at)->format('M Y')}}
                                        </span>
                                    </a>
                                    <div class="public-news-body">
                                        <div class="public-news-meta">
                                            <span><i class="fa fa-tags" aria-hidden="true"></i> {{optional($beritas->kategori)->nama ?? 'Berita'}}</span>
                                            <span><i class="fa fa-user" aria-hidden="true"></i> {{optional($beritas->user)->name ?? 'Admin'}}</span>
                                        </div>
                                        <h2 class="public-news-title">
                                            <a href="{{route('detail.berita', $beritas->slug)}}">{{$beritas->title}}</a>
                                        </h2>
                                        <p class="public-news-excerpt">{{Str::limit(strip_tags($beritas->content), 135)}}</p>
                                        <a class="public-news-link" href="{{route('detail.berita', $beritas->slug)}}">
                                            Baca selengkapnya <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                        @if ($berita->isEmpty())
                            <div class="col-xs-12 public-news-empty">
                                <img src="{{asset('Assets/Frontend/img/empty.svg')}}" class="img-responsive" alt="Belum ada berita">
                                <h3>Belum ada berita</h3>
                                <p>Informasi terbaru akan segera ditampilkan di halaman ini.</p>
                            </div>
                        @endif
                    </div>
                    <div class="public-news-pagination">{{ $berita->links('frontend.content.paginate') }}</div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="sidebar">
                        <div class="sidebar-box">
                            <div class="sidebar-box-inner">
                                <h3 class="sidebar-title">Kategori</h3>
                                <ul class="sidebar-categories">
                                    @foreach ($kategori as $kategoris)
                                        <li><span>{{$kategoris->nama}}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-box">
                            <div class="sidebar-box-inner">
                                <h3 class="sidebar-title">Berita Terbaru</h3>
                                <div class="sidebar-latest-research-area">
                                    <ul>
                                        @foreach ($berita->take(5) as $beritas)
                                            <li>
                                                <div class="latest-research-img">
                                                    <a href="{{route('detail.berita', $beritas->slug)}}"><img src="{{asset('storage/images/berita/' .$beritas->thumbnail)}}" class="img-responsive" alt="skilled"></a>
                                                </div>
                                                <div class="latest-research-content">
                                                    <h6>{{Carbon\Carbon::parse($beritas->created_at)->format('d M, Y')}}</h6>
                                                    <p><a href="{{route('detail.berita', $beritas->slug)}}">{{Str::limit($beritas->title, 62)}}</a></p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@endsection
