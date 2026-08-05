<section id="program" class="ppdb-managed-section">
    <div class="container">
        <span class="ppdb-section-kicker">Program Pendidikan</span>
        <h1 class="about-title">Program Unggulan Sekolah</h1>
        <p class="about-sub-title">Program dapat diperbarui oleh admin dan petugas PPDB melalui dashboard.</p>
        <div class="row">
            @forelse($ppdbContents->get('program', collect()) as $item)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="1s">
                    <div class="service-box2 ppdb-content-card">
                        <div class="service-box-icon"><i class="fa fa-{{ $item->icon ?: 'graduation-cap' }}" aria-hidden="true"></i></div>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->content }}</p>
                    </div>
                </div>
            @empty
                <div class="col-xs-12"><div class="alert alert-info">Informasi program sedang diperbarui.</div></div>
            @endforelse
        </div>
    </div>
</section>
