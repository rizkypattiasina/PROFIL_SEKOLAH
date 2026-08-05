@extends('layouts.backend.app')
@section('title','Dashboard')
@push('styles')
<style>
.dash-hero{background:linear-gradient(135deg,#087f5b,#075244);color:#fff;border-radius:18px;padding:28px;position:relative;overflow:hidden}.dash-hero:after{content:"";position:absolute;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,.09);right:-75px;top:-105px}.dash-hero h2,.dash-hero p{color:#fff}.dash-stat{border:0;border-radius:16px;box-shadow:0 8px 26px rgba(34,61,52,.07);transition:.2s}.dash-stat:hover{transform:translateY(-3px)}.dash-icon{width:48px;height:48px;border-radius:14px;display:grid;place-items:center}.chart-card,.event-card{border:0;border-radius:16px;box-shadow:0 8px 26px rgba(34,61,52,.07)}.event-list{display:grid;gap:12px}.event-item{display:flex;gap:14px;padding:13px;border:1px solid #edf1ef;border-radius:13px}.event-date{min-width:58px;height:62px;border-radius:12px;background:#eaf7f2;color:#087f5b;display:grid;place-items:center;text-align:center;font-weight:700;line-height:1.05}.event-date strong{font-size:22px}.event-copy{min-width:0}.event-copy h5{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.quick-link{display:flex;align-items:center;gap:12px;padding:14px;border-radius:13px;background:#f7f9f8;color:#354a43}.quick-link:hover{background:#eaf7f2;color:#087f5b}
</style>
@endpush
@section('content')
<div class="content-wrapper container-xxl p-0"><div class="content-body">
@if(Auth::user()->role === 'Admin')
    <section class="dash-hero mb-2"><p class="mb-50 text-uppercase font-small-3 font-weight-bold">Dashboard Sekolah</p><h2 class="font-weight-bolder mb-50">Selamat datang, {{ Auth::user()->name }}</h2><p class="mb-0">Pantau data akademik, pendaftaran, pembayaran, dan agenda sekolah dalam satu tampilan.</p></section>
    <div class="row">
        @foreach([['Guru',$guru,'users','primary'],['Murid Aktif',$murid,'user-check','warning'],['Alumni',$alumni,'award','success'],['Event Aktif',$acara,'calendar','danger'],['PPDB Diproses',$ppdb,'user-plus','info'],['Pembayaran Menunggu',$paymentPending,'credit-card','warning']] as $stat)
        <div class="col-xl-2 col-md-4 col-6"><div class="card dash-stat"><div class="card-body"><div class="dash-icon bg-light-{{ $stat[3] }} mb-1"><i data-feather="{{ $stat[2] }}"></i></div><h3 class="font-weight-bolder mb-25">{{ $stat[1] }}</h3><p class="mb-0 font-small-3">{{ $stat[0] }}</p></div></div></div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-xl-8 col-12"><div class="card chart-card"><div class="card-header"><div><h4 class="card-title mb-25">Pertumbuhan Pengguna</h4><small class="text-muted">Akun baru dalam 6 bulan terakhir</small></div></div><div class="card-body"><canvas id="userGrowth" height="112"></canvas></div></div></div>
        <div class="col-xl-4 col-12"><div class="card chart-card"><div class="card-header"><div><h4 class="card-title mb-25">Komposisi Pengguna</h4><small class="text-muted">Guru, murid, dan alumni aktif</small></div></div><div class="card-body"><canvas id="roleChart" height="235"></canvas></div></div></div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-12"><div class="card event-card"><div class="card-header"><div><h4 class="card-title mb-25">Event Mendatang</h4><small class="text-muted">Agenda aktif berdasarkan tanggal terdekat</small></div><a href="{{ route('backend-event.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a></div><div class="card-body event-list">
            @forelse($events as $agenda)<a class="event-item text-body" href="{{ route('backend-event.edit',$agenda->id) }}"><div class="event-date"><strong>{{ \Carbon\Carbon::parse($agenda->acara)->format('d') }}</strong><span>{{ \Carbon\Carbon::parse($agenda->acara)->format('M') }}</span></div><div class="event-copy"><h5 class="mb-50">{{ $agenda->title }}</h5><p class="text-muted font-small-3 mb-25"><i data-feather="clock" class="mr-25"></i>{{ \Carbon\Carbon::parse($agenda->acara)->format('H:i') }} WIT</p><p class="text-muted font-small-3 mb-0"><i data-feather="map-pin" class="mr-25"></i>{{ $agenda->lokasi }}</p></div></a>@empty<div class="text-center py-3 text-muted">Belum ada event mendatang.</div>@endforelse
        </div></div></div>
        <div class="col-lg-5 col-12"><div class="card event-card"><div class="card-header"><h4 class="card-title">Akses Cepat</h4></div><div class="card-body d-grid">
            <a class="quick-link mb-1" href="{{ route('data-murid.index') }}"><span class="dash-icon bg-light-primary"><i data-feather="user-plus"></i></span><strong>Kelola PPDB</strong></a>
            <a class="quick-link mb-1" href="{{ route('spp.murid.index') }}"><span class="dash-icon bg-light-warning"><i data-feather="credit-card"></i></span><strong>Kelola Pembayaran</strong></a>
            <a class="quick-link mb-1" href="{{ route('backend-video.index') }}"><span class="dash-icon bg-light-danger"><i data-feather="video"></i></span><strong>Kelola Galeri Video</strong></a>
            <a class="quick-link" href="{{ route('backend-footer.index') }}"><span class="dash-icon bg-light-success"><i data-feather="sliders"></i></span><strong>Kustomisasi Website</strong></a>
        </div></div></div>
    </div>
@else
    <section class="dash-hero"><h2>Selamat datang, {{ Auth::user()->name }}</h2><p class="mb-0">Anda masuk sebagai {{ Auth::user()->role }}.</p></section>
@endif
</div></div>
@endsection
@if(Auth::user()->role === 'Admin')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
 const grid='#edf1ef', colors=['#087f5b','#f59f00','#5c7cfa'];
 new Chart(document.getElementById('userGrowth'),{type:'line',data:{labels:@json($chartLabels),datasets:[{label:'Pengguna baru',data:@json($chartUsers),borderColor:colors[0],backgroundColor:'rgba(8,127,91,.12)',fill:true,tension:.38,pointRadius:4}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{x:{grid:{display:false}},y:{beginAtZero:true,ticks:{precision:0},grid:{color:grid}}}}});
 new Chart(document.getElementById('roleChart'),{type:'doughnut',data:{labels:['Guru','Murid','Alumni'],datasets:[{data:@json($roleChart),backgroundColor:colors,borderWidth:0}]},options:{responsive:true,cutout:'68%',plugins:{legend:{position:'bottom',labels:{usePointStyle:true,padding:18}}}}});
});
</script>
@endpush
@endif
