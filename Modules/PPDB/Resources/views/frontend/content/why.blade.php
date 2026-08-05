<section id="alur" class="faq-page-area ppdb-managed-section">
    <div class="container">
        <span class="ppdb-section-kicker">Tahapan Pendaftaran</span>
        <h1 class="about-title">Alur PPDB Online</h1>
        <p class="about-sub-title">Ikuti setiap tahap agar data pendaftaran dapat diverifikasi oleh petugas.</p>
        <div class="row">
            @forelse($ppdbContents->get('alur', collect()) as $index => $item)
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="faq-box-wrapper">
                        <div class="faq-box-item panel panel-default">
                            <div class="panel-heading active"><div class="panel-title faq-box-title"><h3>
                                <span class="faq-box-count">{{ $index + 1 }}</span>{{ $item->title }}
                            </h3></div></div>
                            <div class="panel-collapse collapse in"><div class="panel-body faq-box-body"><p>{{ $item->content }}</p></div></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-xs-12"><div class="alert alert-info">Alur pendaftaran sedang diperbarui.</div></div>
            @endforelse
        </div>
        <div class="text-center" style="margin-top: 20px;"><a href="{{ route('ppdb.register') }}" class="default-big-btn">Mulai Pendaftaran</a></div>
    </div>
</section>
