@extends('layouts.backend.app')

@section('title', 'Data Orang Tua PPDB')

@section('content')
@php
    $educations = ['SD','SMP','SMA/SMK','S1','S2','S3'];
    $fatherJobs = ['Wiraswasta','Wirausaha','ASN','Buruh'];
    $motherJobs = ['Ibu Rumah Tangga','Wiraswasta','Wirausaha','ASN','Buruh'];
@endphp
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif
    <div class="content-header row"><div class="col-12 mb-2"><h2>2. Data Orang Tua</h2><p class="text-muted mb-0">Isi data ayah dan ibu calon murid.</p></div></div>
    <div class="card"><div class="card-body"><form action="{{ route('ppdb.form-orangtua.update') }}" method="POST">@csrf @method('PUT')
        @foreach(['ayah' => ['label' => 'Ayah', 'jobs' => $fatherJobs], 'ibu' => ['label' => 'Ibu', 'jobs' => $motherJobs]] as $key => $parent)
            <h4>Data {{ $parent['label'] }}</h4><hr><div class="row">
                <div class="col-md-6"><div class="form-group"><label>Nama {{ $parent['label'] }}</label><input type="text" name="nama_{{ $key }}" value="{{ old('nama_'.$key, $ortu->{'nama_'.$key}) }}" class="form-control @error('nama_'.$key) is-invalid @enderror" required>@error('nama_'.$key)<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>No. Telepon/WhatsApp</label><input type="text" inputmode="numeric" name="telp_{{ $key }}" value="{{ old('telp_'.$key, $ortu->{'telp_'.$key}) }}" class="form-control @error('telp_'.$key) is-invalid @enderror" required>@error('telp_'.$key)<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>Pendidikan</label><select name="pendidikan_{{ $key }}" class="form-control" required><option value="">-- Pilih --</option>@foreach($educations as $education)<option value="{{ $education }}" {{ old('pendidikan_'.$key, $ortu->{'pendidikan_'.$key}) === $education ? 'selected' : '' }}>{{ $education }}</option>@endforeach</select></div></div>
                <div class="col-md-6"><div class="form-group"><label>Pekerjaan</label><select name="pekerjaan_{{ $key }}" class="form-control" required><option value="">-- Pilih --</option>@foreach($parent['jobs'] as $job)<option value="{{ $job }}" {{ old('pekerjaan_'.$key, $ortu->{'pekerjaan_'.$key}) === $job ? 'selected' : '' }}>{{ $job }}</option>@endforeach</select></div></div>
                <div class="col-12"><div class="form-group"><label>Alamat {{ $parent['label'] }}</label><textarea name="alamat_{{ $key }}" rows="3" class="form-control @error('alamat_'.$key) is-invalid @enderror" required>{{ old('alamat_'.$key, $ortu->{'alamat_'.$key}) }}</textarea>@error('alamat_'.$key)<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
            </div>
        @endforeach
        <button class="btn btn-primary">Simpan & Lanjutkan</button><a href="{{ route('ppdb.form-pendaftaran') }}" class="btn btn-outline-secondary">Kembali</a>
    </form></div></div>
</div>
@endsection
