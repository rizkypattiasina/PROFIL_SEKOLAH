<section class="public-video-section" id="galeri-video">

    <div class="container">

        {{-- HEADER SECTION --}}
        <div class="public-video-header">
            <span class="public-video-label">
                Galeri Video
            </span>

            <h2 class="public-video-heading">
                Video SMA Plus Muhammadiyah Merauke
            </h2>

            <p class="public-video-intro">
                Saksikan video profil, kegiatan, informasi, dan dokumentasi
                SMA Plus Muhammadiyah Merauke secara langsung.
            </p>
        </div>

        {{-- DAFTAR VIDEO --}}
        @if (isset($videos) && $videos->count() > 0)

            <div class="row public-video-grid">

                @foreach ($videos as $video)

                    @php
                        $youtubeId = null;

                        if (!empty($video->url)) {
                            $patterns = [
                                '/youtu\.be\/([a-zA-Z0-9_-]{6,})/',
                                '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]{6,})/',
                                '/youtube\.com\/embed\/([a-zA-Z0-9_-]{6,})/',
                                '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{6,})/',
                                '/youtube\.com\/live\/([a-zA-Z0-9_-]{6,})/',
                            ];

                            foreach ($patterns as $pattern) {
                                if (preg_match($pattern, $video->url, $matches)) {
                                    $youtubeId = $matches[1];
                                    break;
                                }
                            }
                        }

                        $thumbnail = $youtubeId
                            ? "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg"
                            : asset('Assets/Frontend/img/banner/1.jpg');
                    @endphp

                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">

                        <article class="public-video-card">

                            {{-- PLAYER / THUMBNAIL --}}
                            <div
                                class="public-video-player"
                                id="video-player-{{ $video->id }}"
                            >

                                @if ($youtubeId)

                                    <button
                                        type="button"
                                        class="public-video-thumbnail-button"
                                        data-video-id="{{ $youtubeId }}"
                                        data-target="video-player-{{ $video->id }}"
                                        aria-label="Putar video {{ $video->title }}"
                                    >
                                        <img
                                            src="{{ $thumbnail }}"
                                            alt="{{ $video->title }}"
                                            class="public-video-thumbnail"
                                            loading="lazy"
                                            onerror="this.onerror=null; this.src='https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg';"
                                        >

                                        <span class="public-video-overlay"></span>

                                        <span class="public-video-play">
                                            <i class="fa fa-play"></i>
                                        </span>

                                        <span class="public-video-type">
                                            <i class="fa fa-youtube-play"></i>
                                            Video
                                        </span>
                                    </button>

                                @else

                                    <div class="public-video-no-thumbnail">
                                        <i class="fa fa-video-camera"></i>

                                        <span>
                                            Video tidak tersedia
                                        </span>
                                    </div>

                                @endif

                            </div>

                            {{-- INFORMASI VIDEO --}}
                            <div class="public-video-body">

                                <div class="public-video-meta">
                                    <span>
                                        <i class="fa fa-play-circle"></i>
                                        Video Sekolah
                                    </span>
                                </div>

                                <h3 class="public-video-title">
                                    {{ $video->title }}
                                </h3>

                                @if (!empty($video->desc))
                                    <p class="public-video-description">
                                        {{ \Illuminate\Support\Str::limit(
                                            strip_tags($video->desc),
                                            150
                                        ) }}
                                    </p>
                                @endif

                                <div class="public-video-footer">

                                    @if ($youtubeId)
                                        <button
                                            type="button"
                                            class="public-video-watch-button"
                                            data-video-id="{{ $youtubeId }}"
                                            data-target="video-player-{{ $video->id }}"
                                        >
                                            <i class="fa fa-play"></i>
                                            Putar Video
                                        </button>
                                    @endif

                                    @if (!empty($video->url))
                                        <a
                                            href="{{ $video->url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="public-video-youtube-link"
                                            title="Buka di YouTube"
                                        >
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                    @endif

                                </div>

                            </div>

                        </article>

                    </div>

                @endforeach

            </div>

        @else

            {{-- JIKA VIDEO KOSONG --}}
            <div class="public-video-empty">

                <div class="public-video-empty-icon">
                    <i class="fa fa-video-camera"></i>
                </div>

                <h3>Video belum tersedia</h3>

                <p>
                    Video sekolah akan ditampilkan pada bagian ini setelah
                    ditambahkan melalui halaman administrator.
                </p>

            </div>

        @endif

    </div>

</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const videoButtons = document.querySelectorAll(
            '.public-video-thumbnail-button, .public-video-watch-button'
        );

        videoButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                const youtubeId = this.getAttribute('data-video-id');
                const targetId = this.getAttribute('data-target');
                const playerContainer = document.getElementById(targetId);

                if (!youtubeId || !playerContainer) {
                    return;
                }

                const iframe = document.createElement('iframe');

                iframe.src =
                    'https://www.youtube.com/embed/' +
                    encodeURIComponent(youtubeId) +
                    '?autoplay=1&rel=0';

                iframe.title = 'Pemutar video YouTube';
                iframe.allow =
                    'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
                iframe.allowFullscreen = true;
                iframe.loading = 'lazy';
                iframe.className = 'public-video-iframe';

                playerContainer.innerHTML = '';
                playerContainer.appendChild(iframe);

                const card = playerContainer.closest('.public-video-card');

                if (card) {
                    card.classList.add('is-playing');
                }
            });

        });

    });
</script>
@endpush
