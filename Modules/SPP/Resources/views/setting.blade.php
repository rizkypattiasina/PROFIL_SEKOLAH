@extends('layouts.backend.app')

@section('title', 'Nominal SPP')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    <div class="content-header row"><div class="col-12 mb-2"><h2>Nominal SPP</h2><p class="text-muted mb-0">Atur nominal tagihan bulanan untuk murid.</p></div></div>
    <div class="content-body">
        <div class="row"><div class="col-lg-7 col-md-9 col-12"><div class="card"><div class="card-body">
            <form action="{{ route('spp.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="amount">Biaya SPP per bulan</label>
                    <div class="input-group"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                        <input type="number" min="0" step="1000" name="amount" id="amount" value="{{ old('amount', optional($setting)->amount ?? 0) }}" class="form-control @error('amount') is-invalid @enderror" required>
                    </div>
                    @error('amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input type="hidden" name="apply_existing" value="0">
                    <input type="checkbox" class="custom-control-input" id="apply_existing" name="apply_existing" value="1" checked>
                    <label class="custom-control-label" for="apply_existing">Terapkan juga ke seluruh tagihan belum lunas tahun {{ date('Y') }}</label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Nominal</button>
                <a href="{{ route('spp.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
            @if($setting)<hr><small class="text-muted">Terakhir diperbarui {{ optional($setting->updated_at)->format('d-m-Y H:i') }} oleh {{ optional($setting->updateBy)->name ?: '-' }}.</small>@endif
        </div></div></div></div>
    </div>
</div>
@endsection
