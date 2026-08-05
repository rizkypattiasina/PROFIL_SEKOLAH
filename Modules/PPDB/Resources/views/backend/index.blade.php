@extends('layouts.backend.app')

@section('title', 'Dashboard PPDB')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif
    <div class="content-header row"><div class="col-12 mb-2"><h2>Dashboard PPDB</h2><p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}.</p></div></div>

    @if(Auth::user()->role === 'PPDB')
        <div class="row"><div class="col-md-4"><div class="card"><div class="card-body"><small>Total Pendaftar Aktif</small><h2 class="text-primary">{{ $register }}</h2></div></div></div><div class="col-md-4"><div class="card"><div class="card-body"><small>Perlu Verifikasi</small><h2 class="text-warning">{{ $needVerif }}</h2></div></div></div><div class="col-md-4"><div class="card"><div class="card-body"><a href="{{ route('data-murid.index') }}" class="btn btn-primary btn-block">Buka Data Calon Murid</a><a href="{{ route('ppdb-content.index') }}" class="btn btn-outline-primary btn-block">Kelola Konten PPDB</a></div></div></div></div>
    @else
        @php $process = optional($candidate)->proses ?: 'Pendaftaran'; @endphp
        <div class="row"><div class="col-lg-7 col-12"><div class="card"><div class="card-body">
            <span class="badge badge-{{ $process === 'Murid' ? 'success' : ($process === 'Ditolak' ? 'danger' : 'warning') }} mb-1">Status: {{ $process }}</span>
            <h3>Lengkapi Pendaftaran Anda</h3>
            @if($process === 'Ditolak')<div class="alert alert-danger">Pendaftaran Anda belum dapat diterima. Silakan hubungi petugas PPDB untuk informasi lebih lanjut.</div>
            @elseif($process === 'Berkas')<div class="alert alert-info">Berkas telah dikirim dan sedang menunggu verifikasi petugas.</div>
            @else<p class="text-muted">Selesaikan tiga tahap berikut agar data dapat diverifikasi.</p>@endif
            <div class="list-group"><a href="{{ route('ppdb.form-pendaftaran') }}" class="list-group-item list-group-item-action">1. Biodata Calon Murid</a><a href="{{ route('ppdb.form-orangtua') }}" class="list-group-item list-group-item-action">2. Data Orang Tua</a><a href="{{ route('ppdb.form-berkas') }}" class="list-group-item list-group-item-action">3. Unggah Berkas</a></div>
        </div></div></div></div>
    @endif
</div>
@endsection
