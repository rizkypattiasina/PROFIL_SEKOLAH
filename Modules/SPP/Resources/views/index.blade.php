@extends('layouts.backend.app')

@section('title', 'Dashboard SPP')

@section('content')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <h2 class="content-header-title">Dashboard SPP {{ $year }}</h2>
            <p class="text-muted mb-0">Ringkasan tagihan, pembayaran, dan sisa SPP seluruh murid.</p>
        </div>
        <div class="content-header-right col-md-4 col-12 mb-2 text-md-right">
            <form method="GET" action="{{ route('spp.index') }}" class="form-inline justify-content-md-end">
                <label class="mr-1" for="year">Tahun</label>
                <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                    @for($optionYear = date('Y') + 1; $optionYear >= 2020; $optionYear--)
                        <option value="{{ $optionYear }}" {{ (int) $year === $optionYear ? 'selected' : '' }}>{{ $optionYear }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            @foreach([
                ['value' => $studentCount, 'label' => 'Murid Ditagihkan', 'icon' => 'users', 'color' => 'primary'],
                ['value' => $currentMonthBills, 'label' => 'Tagihan Bulan Ini', 'icon' => 'calendar', 'color' => 'info'],
                ['value' => $paid, 'label' => 'Bulan Sudah Lunas', 'icon' => 'check-circle', 'color' => 'success'],
                ['value' => $unpaid, 'label' => 'Bulan Belum Lunas', 'icon' => 'alert-circle', 'color' => 'warning'],
            ] as $card)
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div><h2 class="font-weight-bolder mb-0">{{ $card['value'] }}</h2><p class="card-text mb-0">{{ $card['label'] }}</p></div>
                            <div class="avatar bg-light-{{ $card['color'] }} p-50"><div class="avatar-content"><i data-feather="{{ $card['icon'] }}" class="font-medium-5"></i></div></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card border-left-primary">
                    <div class="card-body"><small>Total Pembayaran Diterima</small><h3 class="text-success mt-50">Rp {{ number_format($paidAmount, 0, ',', '.') }}</h3></div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card border-left-warning">
                    <div class="card-body"><small>Total Sisa Tagihan</small><h3 class="text-warning mt-50">Rp {{ number_format($outstandingAmount, 0, ',', '.') }}</h3></div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card border-left-info">
                    <div class="card-body"><small>Bukti Menunggu Verifikasi</small><h3 class="text-info mt-50">{{ $pending }}</h3></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div><h4 class="mb-25">Kelola pembayaran murid</h4><p class="text-muted mb-0">Buka daftar murid untuk melihat rincian lunas, sisa tagihan, dan bukti transfer.</p></div>
                <a href="{{ route('spp.murid.index', ['year' => $year]) }}" class="btn btn-primary mt-1 mt-md-0">Pembayaran Murid</a>
            </div>
        </div>
    </div>
</div>
@endsection
