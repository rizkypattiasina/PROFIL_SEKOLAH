<section class="home-news-events">
    <div class="container">
        <div class="home-section-head"><div><span class="section-kicker">Informasi Sekolah</span><h2>Berita Terbaru</h2><p>Ikuti kabar, prestasi, dan aktivitas terbaru sekolah.</p></div><a href="{{ route('berita') }}">Lihat semua berita <i class="fa fa-arrow-right"></i></a></div>
        <div class="row home-news-grid">
            @forelse($berita as $item)
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"><article class="home-news-card">
                <a class="home-news-thumb" href="{{ route('detail.berita',$item->slug) }}"><img src="{{ asset('storage/images/berita/'.$item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy"><span>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span></a>
                <div class="home-news-body"><small>{{ optional($item->kategori)->nama ?? 'Berita Sekolah' }}</small><h3><a href="{{ route('detail.berita',$item->slug) }}">{{ $item->title }}</a></h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($item->desc ?: $item->content),100) }}</p><a class="home-news-more" href="{{ route('detail.berita',$item->slug) }}">Baca selengkapnya <i class="fa fa-arrow-right"></i></a></div>
            </article></div>
            @empty<div class="col-xs-12"><div class="home-empty">Belum ada berita yang dipublikasikan.</div></div>@endforelse
        </div>
        <div class="home-event-block"><div class="home-section-head compact"><div><span class="section-kicker">Kalender Sekolah</span><h2>Event Mendatang</h2></div><a href="{{ route('event') }}">Semua event <i class="fa fa-arrow-right"></i></a></div>
            <div class="row">
            @forelse($event as $agenda)<div class="col-lg-6 col-md-6 col-xs-12"><a class="dynamic-event-card" href="{{ route('detail.event',$agenda->slug) }}"><div class="dynamic-event-date"><strong>{{ \Carbon\Carbon::parse($agenda->acara)->format('d') }}</strong><span>{{ \Carbon\Carbon::parse($agenda->acara)->format('M Y') }}</span></div><div class="dynamic-event-copy"><h3>{{ $agenda->title }}</h3><p><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($agenda->acara)->format('H:i') }} WIT &nbsp; <i class="fa fa-map-marker"></i> {{ $agenda->lokasi }}</p><span>{{ \Illuminate\Support\Str::limit($agenda->desc,95) }}</span></div><i class="fa fa-chevron-right dynamic-event-arrow"></i></a></div>
            @empty<div class="col-xs-12"><div class="home-empty">Belum ada event mendatang.</div></div>@endforelse
            </div>
        </div>
    </div>
</section>
