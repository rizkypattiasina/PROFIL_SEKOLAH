@extends('layouts.backend.app')

@section('title', 'Berkas PPDB')

@section('content')
@php
    $documents = [
        'kartu_keluarga' => 'Kartu Keluarga', 'akte_kelahiran' => 'Akta Kelahiran',
        'surat_kelakuan_baik' => 'Surat Kelakuan Baik', 'surat_sehat' => 'Surat Sehat',
        'surat_tidak_buta_warna' => 'Surat Tidak Buta Warna', 'rapor' => 'Rapor',
        'foto' => 'Pas Foto', 'ijazah' => 'Ijazah (opsional)',
    ];
@endphp
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif
    <div class="content-header row"><div class="col-12 mb-2"><h2>3. Unggah Berkas PPDB</h2><p class="text-muted mb-0">Format JPG, JPEG, PNG, atau PDF; maksimal 2 MB per file. Berkas lama tetap tersimpan jika tidak diganti.</p></div></div>
    <div class="card"><div class="card-body"><form action="{{ route('ppdb.form-berkas.update') }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
        <div class="row">
            @foreach($documents as $field => $label)
                <div class="col-md-6"><div class="form-group">
                    <label for="{{ $field }}">{{ $label }} @if($field !== 'ijazah' && !$berkas->{$field})<span class="text-danger">*</span>@endif</label>
                    @if($berkas->{$field})<div class="mb-50"><a href="{{ asset('storage/images/berkas_murid/'.$berkas->{$field}) }}" target="_blank" rel="noopener">Lihat berkas tersimpan</a></div>@endif
                    <input type="file" id="{{ $field }}" name="{{ $field }}" accept="{{ $field === 'foto' ? '.jpg,.jpeg,.png' : '.jpg,.jpeg,.png,.pdf' }}" class="form-control @error($field) is-invalid @enderror">
                    @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div></div>
            @endforeach
        </div>
        <button class="btn btn-primary">Kirim Berkas</button><a href="{{ route('ppdb.form-orangtua') }}" class="btn btn-outline-secondary">Kembali</a>
    </form></div></div>
</div>
@endsection
