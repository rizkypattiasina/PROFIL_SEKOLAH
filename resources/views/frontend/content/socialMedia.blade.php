@php
    $socialFooter = $footer ?? null;
    $instagramProfile = optional($socialFooter)->instagram;
    $tiktokProfile = optional($socialFooter)->tiktok;
    $youtubeProfile = optional($socialFooter)->youtube;

    $cleanHandle = function ($value, $fallback = '') {
        $value = trim((string) $value);
        return $value !== '' ? '@'.ltrim($value, '@/') : $fallback;
    };
    $profileUsername = function ($url) {
        $path = trim((string) parse_url((string) $url, PHP_URL_PATH), '/');
        return $path !== '' ? ltrim(explode('/', $path)[0], '@') : '';
    };

    $instagramUsername = trim((string) optional($socialFooter)->instagram_handle)
        ?: $profileUsername($instagramProfile);
    if (in_array(strtolower($instagramUsername), ['p', 'reel', 'tv', 'explore'], true)) {
        $instagramUsername = '';
    }
    $tiktokUsername = trim((string) optional($socialFooter)->tiktok_handle)
        ?: $profileUsername($tiktokProfile);
    $instagramHandle = $cleanHandle($instagramUsername, '@instagram');
    $tiktokHandle = $cleanHandle($tiktokUsername, '@tiktok');
    $youtubeHandleValue = trim((string) optional($socialFooter)->youtube_handle);
    $youtubeHandle = $youtubeHandleValue !== ''
        ? $youtubeHandleValue
        : (optional($socialFooter)->school_name ?? 'Channel Sekolah');

    $instagramPermalink = null;
    $instagramFeedUrl = trim((string) optional($socialFooter)->instagram_embed_url);
    if (preg_match('#https?://(?:www\.)?instagram\.com/(?:p|reel|tv)/[A-Za-z0-9_-]+/?#i', $instagramFeedUrl, $matches)) {
        $instagramPermalink = rtrim($matches[0], '/').'/';
    }

    $tiktokVideoId = null;
    $tiktokFeedUrl = trim((string) optional($socialFooter)->tiktok_embed_url);
    if (preg_match('#tiktok\.com/@[^/]+/video/([0-9]+)#i', $tiktokFeedUrl, $matches)) {
        $tiktokVideoId = $matches[1];
    }

    $latestVideoUrl = isset($videos) && $videos->count() ? optional($videos->first())->url : null;
    $youtubeFeedUrl = trim((string) (optional($socialFooter)->youtube_embed_url ?: $latestVideoUrl));
    $youtubeVideoId = null;
    $youtubePatterns = [
        '/youtu\.be\/([a-zA-Z0-9_-]{6,})/',
        '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]{6,})/',
        '/youtube\.com\/embed\/([a-zA-Z0-9_-]{6,})/',
        '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{6,})/',
        '/youtube\.com\/live\/([a-zA-Z0-9_-]{6,})/',
    ];
    foreach ($youtubePatterns as $pattern) {
        if (preg_match($pattern, $youtubeFeedUrl, $matches)) {
            $youtubeVideoId = $matches[1];
            break;
        }
    }

    $tiktokCreator = ltrim($tiktokUsername, '@/');
@endphp

<section class="school-social-section" id="media-sosial" aria-labelledby="social-media-title">
    <div class="container">
        <div class="school-social-heading">
            <span>Terhubung dengan kami</span>
            <h2 id="social-media-title">Media Sosial</h2>
            <p>Ikuti informasi, prestasi, dan kegiatan terbaru sekolah melalui kanal resmi kami.</p>
        </div>

        <div class="school-social-layout" data-social-tabs>
            <div class="school-social-tabs" role="tablist" aria-label="Pilih media sosial">
                <button class="school-social-tab is-active" type="button" role="tab" aria-selected="true" aria-controls="social-instagram" id="tab-instagram" data-social-target="social-instagram">
                    <span class="school-social-icon instagram"><i class="fa fa-instagram" aria-hidden="true"></i></span>
                    <span><strong>Instagram</strong><small>{{ $instagramHandle }}</small></span>
                </button>
                <button class="school-social-tab" type="button" role="tab" aria-selected="false" aria-controls="social-tiktok" id="tab-tiktok" data-social-target="social-tiktok">
                    <span class="school-social-icon tiktok"><i class="fa fa-music" aria-hidden="true"></i></span>
                    <span><strong>TikTok</strong><small>{{ $tiktokHandle }}</small></span>
                </button>
                <button class="school-social-tab" type="button" role="tab" aria-selected="false" aria-controls="social-youtube" id="tab-youtube" data-social-target="social-youtube">
                    <span class="school-social-icon youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></span>
                    <span><strong>YouTube</strong><small>{{ $youtubeHandle }}</small></span>
                </button>
            </div>

            <div class="school-social-panels">
                <article class="school-social-panel" id="social-instagram" role="tabpanel" aria-labelledby="tab-instagram">
                    <header>
                        <strong>Instagram Feed</strong>
                        @if($instagramProfile)<a href="{{ $instagramProfile }}" target="_blank" rel="noopener">Lihat Profil <i class="fa fa-external-link" aria-hidden="true"></i></a>@endif
                    </header>
                    <div class="school-social-content instagram-content">
                        @if($instagramPermalink)
                            <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="{{ $instagramPermalink }}" data-instgrm-version="14"></blockquote>
                        @else
                            <div class="school-social-empty">
                                <span class="school-social-icon instagram"><i class="fa fa-instagram" aria-hidden="true"></i></span>
                                <h3>Feed Instagram siap ditampilkan</h3>
                                <p>Admin dapat menempel URL Post atau Reel publik melalui menu Pengaturan Website.</p>
                                @if($instagramProfile)<a href="{{ $instagramProfile }}" target="_blank" rel="noopener">Buka Instagram</a>@endif
                            </div>
                        @endif
                    </div>
                </article>

                <article class="school-social-panel" id="social-tiktok" role="tabpanel" aria-labelledby="tab-tiktok" hidden>
                    <header>
                        <strong>TikTok Feed</strong>
                        @if($tiktokProfile)<a href="{{ $tiktokProfile }}" target="_blank" rel="noopener">Lihat Profil <i class="fa fa-external-link" aria-hidden="true"></i></a>@endif
                    </header>
                    <div class="school-social-content tiktok-content">
                        @if($tiktokVideoId)
                            <div class="school-tiktok-player">
                                <iframe src="https://www.tiktok.com/player/v1/{{ $tiktokVideoId }}?music_info=1&amp;description=1" title="Video TikTok {{ $tiktokHandle }}" loading="lazy" allow="fullscreen; autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @elseif($tiktokCreator)
                            <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@{{ $tiktokCreator }}" data-unique-id="{{ $tiktokCreator }}" data-embed-type="creator">
                                <section><a target="_blank" rel="noopener" href="https://www.tiktok.com/@{{ $tiktokCreator }}">{{ '@'.$tiktokCreator }}</a></section>
                            </blockquote>
                        @else
                            <div class="school-social-empty">
                                <span class="school-social-icon tiktok"><i class="fa fa-music" aria-hidden="true"></i></span>
                                <h3>Feed TikTok siap ditampilkan</h3>
                                <p>Isi username atau URL video TikTok publik melalui menu Pengaturan Website.</p>
                                @if($tiktokProfile)<a href="{{ $tiktokProfile }}" target="_blank" rel="noopener">Buka TikTok</a>@endif
                            </div>
                        @endif
                    </div>
                </article>

                <article class="school-social-panel" id="social-youtube" role="tabpanel" aria-labelledby="tab-youtube" hidden>
                    <header>
                        <strong>YouTube Channel</strong>
                        @if($youtubeProfile)<a href="{{ $youtubeProfile }}" target="_blank" rel="noopener">Lihat Profil <i class="fa fa-external-link" aria-hidden="true"></i></a>@endif
                    </header>
                    <div class="school-social-content youtube-content">
                        @if($youtubeVideoId)
                            <div class="school-youtube-player">
                                <iframe src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?rel=0&amp;playsinline=1" title="Video YouTube {{ $youtubeHandle }}" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="school-social-empty">
                                <span class="school-social-icon youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></span>
                                <h3>Video YouTube belum tersedia</h3>
                                <p>Tambahkan video aktif pada menu Video atau isi URL video di Pengaturan Website.</p>
                                @if($youtubeProfile)<a href="{{ $youtubeProfile }}" target="_blank" rel="noopener">Buka YouTube</a>@endif
                            </div>
                        @endif
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    @if($instagramPermalink)<script async src="https://www.instagram.com/embed.js"></script>@endif
    @if($tiktokCreator && !$tiktokVideoId)<script async src="https://www.tiktok.com/embed.js"></script>@endif
    <script>
        (function () {
            var tabGroups = document.querySelectorAll('[data-social-tabs]');
            Array.prototype.forEach.call(tabGroups, function (group) {
                var tabs = group.querySelectorAll('[data-social-target]');
                Array.prototype.forEach.call(tabs, function (tab) {
                    tab.addEventListener('click', function () {
                        var targetId = tab.getAttribute('data-social-target');
                        Array.prototype.forEach.call(tabs, function (item) {
                            var active = item === tab;
                            item.classList.toggle('is-active', active);
                            item.setAttribute('aria-selected', active ? 'true' : 'false');
                        });
                        Array.prototype.forEach.call(group.querySelectorAll('.school-social-panel'), function (panel) {
                            panel.hidden = panel.id !== targetId;
                        });
                        if (targetId === 'social-instagram' && window.instgrm && window.instgrm.Embeds) {
                            window.instgrm.Embeds.process();
                        }
                    });
                });
            });
        })();
    </script>
@endpush
