@php
    $footerLogo = !empty(optional($footer)->logo)
        ? asset('storage/'.(\Illuminate\Support\Str::contains($footer->logo, '/') ? $footer->logo : 'images/logo/'.$footer->logo))
        : asset('Assets/Frontend/img/logo-footer.png');
    $schoolName = optional($footer)->school_name ?: 'SMA Plus Muhammadiyah Merauke';
    $whatsappNumber = preg_replace('/\D+/', '', (string) optional($footer)->whatsapp);
    if ($whatsappNumber && substr($whatsappNumber, 0, 1) === '0') {
        $whatsappNumber = '62'.substr($whatsappNumber, 1);
    }
    $contactUrl = $whatsappNumber
        ? 'https://wa.me/'.$whatsappNumber
        : (optional($footer)->email ? 'mailto:'.$footer->email : route('frontend.home').'#media-sosial');
    $footerSocials = [
        'facebook' => ['label' => 'Facebook', 'icon' => 'facebook'],
        'instagram' => ['label' => 'Instagram', 'icon' => 'instagram'],
        'youtube' => ['label' => 'YouTube', 'icon' => 'youtube-play'],
        'tiktok' => ['label' => 'TikTok', 'icon' => 'music'],
        'twitter' => ['label' => 'X / Twitter', 'icon' => 'twitter'],
        'linkedin' => ['label' => 'LinkedIn', 'icon' => 'linkedin'],
    ];
@endphp

<div class="school-footer">
    <div class="container">
        <div class="school-footer-intro">
            <div class="school-footer-brand">
                <a href="{{ route('frontend.home') }}" aria-label="Kembali ke beranda {{ $schoolName }}">
                    <img src="{{ $footerLogo }}" alt="Logo {{ $schoolName }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('Assets/Frontend/img/logo-footer.png') }}';">
                </a>
                <div>
                    <h2>{{ $schoolName }}</h2>
                    @if(optional($footer)->address)<p><i class="fa fa-map-marker" aria-hidden="true"></i>{{ $footer->address }}</p>@endif
                    <ul>
                        @if(optional($footer)->telp)<li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $footer->telp) }}"><i class="fa fa-phone" aria-hidden="true"></i>{{ $footer->telp }}</a></li>@endif
                        @if(optional($footer)->email)<li><a href="mailto:{{ $footer->email }}"><i class="fa fa-envelope-o" aria-hidden="true"></i>{{ $footer->email }}</a></li>@endif
                    </ul>
                </div>
            </div>
            <a class="school-footer-contact" href="{{ $contactUrl }}" @if($whatsappNumber) target="_blank" rel="noopener" @endif>
                <i class="fa fa-comments-o" aria-hidden="true"></i> Hubungi Kami
            </a>
        </div>

        <div class="school-footer-links">
            <section>
                <h3>Tentang Sekolah</h3>
                <ul>
                    <li><a href="{{ route('profile.sekolah') }}">Profil Sekolah</a></li>
                    <li><a href="{{ route('visimisi.sekolah') }}">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('frontend.home') }}#pengajar">Pengajar</a></li>
                    <li><a href="{{ route('alumni') }}">Alumni</a></li>
                </ul>
            </section>
            <section>
                <h3>Akademik</h3>
                <ul>
                    @foreach(($footerPrograms ?? collect())->take(3) as $program)
                        <li><a href="{{ route('program.detail', $program->slug) }}">{{ $program->nama }}</a></li>
                    @endforeach
                    @foreach(($footerActivities ?? collect())->take(3) as $activity)
                        <li><a href="{{ route('kegiatan.detail', $activity->slug) }}">{{ $activity->nama }}</a></li>
                    @endforeach
                    @if(($footerPrograms ?? collect())->isEmpty() && ($footerActivities ?? collect())->isEmpty())
                        <li><a href="{{ route('frontend.home') }}#galeri-video">Kegiatan Sekolah</a></li>
                    @endif
                </ul>
            </section>
            <section>
                <h3>Informasi Publik</h3>
                <ul>
                    <li><a href="{{ route('berita') }}">Berita Terbaru</a></li>
                    <li><a href="{{ route('event') }}">Agenda Sekolah</a></li>
                    @if(\Illuminate\Support\Facades\Route::has('ppdb.index'))<li><a href="{{ route('ppdb.index') }}">Pengumuman PPDB</a></li>@endif
                    <li><a href="{{ route('frontend.home') }}#galeri-video">Galeri Video</a></li>
                </ul>
            </section>
            <section>
                <h3>Media Sosial</h3>
                <div class="school-footer-socials">
                    @foreach($footerSocials as $field => $social)
                        @if(!empty(data_get($footer, $field)))
                            <a href="{{ data_get($footer, $field) }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }} {{ $schoolName }}" title="{{ $social['label'] }}">
                                <i class="fa fa-{{ $social['icon'] }}" aria-hidden="true"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
                <p>Ikuti kanal resmi kami untuk memperoleh informasi sekolah terbaru.</p>
                <a class="school-footer-feed-link" href="{{ route('frontend.home') }}#media-sosial">Lihat feed media sosial <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </section>
        </div>

        <div class="school-footer-news">
            <div class="school-footer-news-title">
                <div><span>Dokumentasi</span><h3>Foto Berita Terbaru</h3></div>
                <a href="{{ route('berita') }}">Semua Berita <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="school-footer-news-grid">
                @forelse($footerNews ?? collect() as $news)
                    <a href="{{ route('detail.berita', $news->slug) }}" title="{{ $news->title }}">
                        <img src="{{ asset('storage/images/berita/'.$news->thumbnail) }}" alt="{{ $news->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('Assets/Frontend/img/footer/'.min($loop->iteration, 6).'.jpg') }}';">
                        <span>{{ $news->title }}</span>
                    </a>
                @empty
                    <p>Foto berita akan muncul setelah berita aktif diterbitkan.</p>
                @endforelse
            </div>
        </div>

        <div class="school-footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $schoolName }}. Hak cipta dilindungi.</p>
            <a href="{{ route('frontend.home') }}">Beranda</a>
        </div>
    </div>
</div>
