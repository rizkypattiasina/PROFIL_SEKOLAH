@extends('layouts.backend.app')

@section('title', 'Pembayaran Murid')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif

    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <h2 class="content-header-title">Pembayaran Murid {{ $year }}</h2>
            <p class="text-muted mb-0">Status lunas dan sisa tagihan dihitung dari 12 bulan SPP.</p>
        </div>
        <div class="content-header-right col-md-4 col-12 mb-2 text-md-right">
            <form method="GET" action="{{ route('spp.murid.index') }}" class="form-inline justify-content-md-end">
                <select name="year" class="form-control" onchange="this.form.submit()">
                    @for($optionYear = date('Y') + 1; $optionYear >= 2020; $optionYear--)
                        <option value="{{ $optionYear }}" {{ (int) $year === $optionYear ? 'selected' : '' }}>{{ $optionYear }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-header border-bottom"><h4 class="card-title">Daftar Pembayaran Murid</h4></div>
            <div class="table-responsive">
                <table class="dt-responsive table table-hover">
                    <thead><tr><th>No</th><th>NISN</th><th>Nama</th><th>Bulan Ini</th><th>Lunas</th><th>Sisa</th><th>Sisa Tagihan</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @forelse($payment as $key => $student)
                        @php
                            $bill = $student->payments->first();
                            $details = $bill ? $bill->detailPayment : collect();
                            $current = $details->firstWhere('month', date('F'));
                            $paidMonths = $details->where('status', 'paid')->count();
                            $unpaidMonths = $details->where('status', 'unpaid')->count();
                            $remaining = $details->where('status', 'unpaid')->sum('amount');
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ optional($student->muridDetail)->nisn ?: '-' }}</td>
                            <td><strong>{{ $student->name }}</strong><br><small>{{ $student->email }}</small></td>
                            <td><span class="badge badge-{{ optional($current)->status === 'paid' ? 'success' : 'warning' }}">{{ optional($current)->status === 'paid' ? 'Lunas' : 'Belum Lunas' }}</span></td>
                            <td>{{ $paidMonths }} bulan</td>
                            <td>{{ $unpaidMonths }} bulan</td>
                            <td>Rp {{ number_format($remaining, 0, ',', '.') }}</td>
                            <td>@if($bill)<a href="{{ route('spp.murid.detail', $bill->id) }}" class="btn btn-primary btn-sm">Detail</a>@else<span class="text-muted">Belum ada tagihan</span>@endif</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-3">Belum ada murid aktif.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
