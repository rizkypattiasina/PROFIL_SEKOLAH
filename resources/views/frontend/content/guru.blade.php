<section class="school-teachers" id="pengajar" aria-labelledby="teacher-section-title">
    <div class="container">
        <div class="school-teachers-heading">
            <span>Tenaga Pendidik</span>
            <h2 id="teacher-section-title">Pengajar</h2>
            <p>Guru profesional yang mendampingi siswa bertumbuh, berprestasi, dan berkarakter.</p>
        </div>

        @if(isset($pengajar) && $pengajar->count())
            <div class="school-teacher-grid" data-count="{{ $pengajar->count() }}">
                @foreach ($pengajar as $pengajars)
                    @php
                        $teacherFallback = asset('Assets/Frontend/img/logo-footer.png');
                        $teacherPhoto = !empty($pengajars->foto_profile)
                            ? asset('storage/images/profile/'.$pengajars->foto_profile)
                            : $teacherFallback;
                        $teacherDetail = $pengajars->userDetail;
                        $teacherSocial = [
                            ['value' => optional($teacherDetail)->website, 'icon' => 'globe', 'label' => 'Website', 'base' => 'https://'],
                            ['value' => optional($teacherDetail)->linkidln, 'icon' => 'linkedin', 'label' => 'LinkedIn', 'base' => 'https://www.linkedin.com/in/'],
                            ['value' => optional($teacherDetail)->twitter, 'icon' => 'twitter', 'label' => 'Twitter', 'base' => 'https://www.twitter.com/'],
                            ['value' => optional($teacherDetail)->facebook, 'icon' => 'facebook', 'label' => 'Facebook', 'base' => 'https://www.facebook.com/'],
                            ['value' => optional($teacherDetail)->instagram, 'icon' => 'instagram', 'label' => 'Instagram', 'base' => 'https://www.instagram.com/'],
                            ['value' => optional($teacherDetail)->youtube, 'icon' => 'youtube-play', 'label' => 'YouTube', 'base' => 'https://www.youtube.com/'],
                        ];
                    @endphp

                    <article class="school-teacher-card">
                        <div class="school-teacher-photo">
                            <img src="{{ $teacherPhoto }}" alt="Foto {{ $pengajars->name }}" loading="lazy" onerror="this.onerror=null;this.classList.add('is-fallback');this.src='{{ $teacherFallback }}';">
                        </div>
                        <div class="school-teacher-content">
                            <h3>{{ $pengajars->name }}</h3>
                            <p>{{ optional($teacherDetail)->mengajar ?? 'Pengajar' }}</p>
                            <div class="school-teacher-socials" aria-label="Kontak {{ $pengajars->name }}">
                                @if(!empty($pengajars->email))
                                    <a href="mailto:{{ $pengajars->email }}" aria-label="Email {{ $pengajars->name }}" title="Email"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                @endif
                                @foreach($teacherSocial as $social)
                                    @php
                                        $socialValue = trim((string) $social['value']);
                                        $socialUrl = $socialValue && filter_var($socialValue, FILTER_VALIDATE_URL)
                                            ? $socialValue
                                            : ($socialValue ? $social['base'].ltrim($socialValue, '@/') : null);
                                    @endphp
                                    @if($socialUrl)
                                        <a href="{{ $socialUrl }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }} {{ $pengajars->name }}" title="{{ $social['label'] }}"><i class="fa fa-{{ $social['icon'] }}" aria-hidden="true"></i></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="school-teachers-empty">Data pengajar belum tersedia.</div>
        @endif
    </div>
</section>
