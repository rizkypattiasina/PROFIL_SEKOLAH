<section id="berkas" class="ppdb-managed-section ppdb-requirements-section">
    <div class="container">
        <span class="ppdb-section-kicker">Persyaratan Administrasi</span>
        <h1 class="about-title">Berkas yang Disiapkan</h1>
        <p class="about-sub-title">Berkas dapat diunggah dalam format JPG, JPEG, PNG, atau PDF dengan ukuran maksimal 2 MB per file.</p>
        <div class="row">
            @forelse($ppdbContents->get('berkas', collect()) as $item)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="ppdb-requirement-card">
                        <i class="fa fa-{{ $item->icon ?: 'file-text-o' }}"></i>
                        <div><h3>{{ $item->title }}</h3><p>{{ $item->content }}</p></div>
                    </div>
                </div>
            @empty
                <div class="col-xs-12"><div class="alert alert-info">Daftar berkas sedang diperbarui.</div></div>
            @endforelse
        </div>
    </div>
</section>
