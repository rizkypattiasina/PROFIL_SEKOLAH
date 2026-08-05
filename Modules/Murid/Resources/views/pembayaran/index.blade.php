@extends('layouts.backend.app')

@section('title', 'Pembayaran SPP Saya')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif

    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2"><h2>Pembayaran SPP Saya</h2><p class="text-muted mb-0">Tahun {{ $year }} · unggah bukti transfer pada tagihan yang belum lunas.</p></div>
        <div class="content-header-right col-md-4 col-12 mb-2 text-md-right">
            <form method="GET" action="{{ route('pembayaran.index') }}"><select name="year" class="form-control d-inline-block w-auto" onchange="this.form.submit()">@for($optionYear = date('Y') + 1; $optionYear >= 2020; $optionYear--)<option value="{{ $optionYear }}" {{ (int) $year === $optionYear ? 'selected' : '' }}>{{ $optionYear }}</option>@endfor</select></form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Total Sudah Dibayar</small><h3 class="text-success">Rp {{ number_format($paidAmount, 0, ',', '.') }}</h3></div></div></div>
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Sisa Tagihan</small><h3 class="text-warning">Rp {{ number_format($outstandingAmount, 0, ',', '.') }}</h3></div></div></div>
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Menunggu Verifikasi</small><h3 class="text-info">{{ $pendingCount }} pembayaran</h3></div></div></div>
    </div>

    <div class="card"><div class="card-header border-bottom"><h4 class="card-title">Rincian Bulanan</h4></div><div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>No</th><th>Bulan</th><th>Nominal</th><th>Status</th><th>Tanggal Transfer</th><th>Bukti</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($payment as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td><td>{{ $item->month_label }}</td><td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                <td>@if($item->status === 'paid')<span class="badge badge-success">Lunas</span>@elseif($item->file)<span class="badge badge-info">Menunggu Verifikasi</span>@else<span class="badge badge-warning">Belum Lunas</span>@endif</td>
                <td>{{ optional($item->date_file)->format('d-m-Y') ?: '-' }}</td>
                <td>@if($item->url_file)<a href="{{ $item->url_file }}" target="_blank" rel="noopener">Lihat bukti</a>@else-@endif</td>
                <td>@if($item->status === 'paid')<span class="text-success">Selesai</span>@else<a href="{{ route('pembayaran.edit', $item->id) }}" class="btn btn-primary btn-sm">{{ $item->file ? 'Perbarui Bukti' : 'Bayar' }}</a>@endif</td>
            </tr>
        @endforeach
        </tbody>
    </table></div></div>
</div>
@endsection
