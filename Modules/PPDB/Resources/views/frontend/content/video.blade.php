<section id="informasi" class="ppdb-managed-section ppdb-information-section">
    <div class="container">
        <span class="ppdb-section-kicker">Informasi Penting</span>
        <h1 class="about-title">Informasi PPDB</h1>
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                @forelse($ppdbContents->get('informasi', collect()) as $item)
                    <div class="ppdb-info-item"><i class="fa fa-{{ $item->icon ?: 'info-circle' }}"></i><div><h3>{{ $item->title }}</h3><p>{{ $item->content }}</p></div></div>
                @empty
                    <div class="alert alert-info">Informasi PPDB sedang diperbarui.</div>
                @endforelse
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="ppdb-video-card">
                    <h3>Kenali Sekolah Kami</h3>
                    <p>Tonton video sekolah untuk melihat lingkungan belajar dan kegiatan peserta didik.</p>
                    @if($ppdbVideo && $ppdbVideo->url)
                        <a class="default-big-btn popup-youtube" href="{{ $ppdbVideo->url }}"><i class="fa fa-play"></i> Tonton Video</a>
                    @else
                        <span class="text-muted">Video sekolah belum tersedia.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
