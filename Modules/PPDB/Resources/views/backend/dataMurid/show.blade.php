@extends('layouts.backend.app')

@section('title', 'Detail Calon Murid')

@section('content')
@php
    $detail = $murid->muridDetail;
    $ortu = $murid->dataOrtu;
    $berkas = $murid->berkas;
    $documents = [
        'kartu_keluarga' => 'Kartu Keluarga', 'akte_kelahiran' => 'Akta Kelahiran',
        'surat_kelakuan_baik' => 'Surat Kelakuan Baik', 'surat_sehat' => 'Surat Sehat',
        'surat_tidak_buta_warna' => 'Surat Tidak Buta Warna', 'rapor' => 'Rapor',
        'foto' => 'Pas Foto', 'ijazah' => 'Ijazah',
    ];
    $ready = $detail && $detail->agama && $ortu && $ortu->nama_ayah && $berkas && $berkas->kartu_keluarga;
@endphp
<div class="content-wrapper container-xxl p-0">
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif
    <div class="content-header row"><div class="col-md-8 col-12 mb-2"><h2>Detail Pendaftaran</h2><p class="text-muted mb-0">{{ $murid->name }} · {{ $murid->email }}</p></div><div class="col-md-4 col-12 mb-2 text-md-right"><span class="badge badge-{{ optional($detail)->proses === 'Murid' ? 'success' : (optional($detail)->proses === 'Ditolak' ? 'danger' : 'warning') }} p-1">{{ optional($detail)->proses ?: 'Pendaftaran' }}</span></div></div>

    @if(!$ready)<div class="alert alert-warning"><div class="alert-body"><strong>Data belum lengkap.</strong> Penerimaan baru dapat dilakukan setelah biodata, data orang tua, dan berkas utama tersedia.</div></div>@endif

    <div class="row">
        <div class="col-lg-6 col-12"><div class="card"><div class="card-header border-bottom"><h4 class="card-title">Biodata Calon Murid</h4></div><div class="card-body"><dl class="row mb-0">
            <dt class="col-sm-4">Nama</dt><dd class="col-sm-8">{{ $murid->name }}</dd><dt class="col-sm-4">Tempat/Tgl. Lahir</dt><dd class="col-sm-8">{{ optional($detail)->tempat_lahir ?: '-' }} / {{ optional($detail)->tgl_lahir ?: '-' }}</dd><dt class="col-sm-4">Agama</dt><dd class="col-sm-8">{{ optional($detail)->agama ?: '-' }}</dd><dt class="col-sm-4">WhatsApp</dt><dd class="col-sm-8">{{ optional($detail)->whatsapp ?: '-' }}</dd><dt class="col-sm-4">Asal Sekolah</dt><dd class="col-sm-8">{{ optional($detail)->asal_sekolah ?: '-' }}</dd><dt class="col-sm-4">Alamat</dt><dd class="col-sm-8">{{ optional($detail)->alamat ?: '-' }}</dd>
        </dl></div></div></div>
        <div class="col-lg-6 col-12"><div class="card"><div class="card-header border-bottom"><h4 class="card-title">Data Orang Tua</h4></div><div class="card-body"><dl class="row mb-0">
            <dt class="col-sm-4">Nama Ayah</dt><dd class="col-sm-8">{{ optional($ortu)->nama_ayah ?: '-' }}</dd><dt class="col-sm-4">Pekerjaan Ayah</dt><dd class="col-sm-8">{{ optional($ortu)->pekerjaan_ayah ?: '-' }}</dd><dt class="col-sm-4">Kontak Ayah</dt><dd class="col-sm-8">{{ optional($ortu)->telp_ayah ?: '-' }}</dd><dt class="col-sm-4">Nama Ibu</dt><dd class="col-sm-8">{{ optional($ortu)->nama_ibu ?: '-' }}</dd><dt class="col-sm-4">Pekerjaan Ibu</dt><dd class="col-sm-8">{{ optional($ortu)->pekerjaan_ibu ?: '-' }}</dd><dt class="col-sm-4">Kontak Ibu</dt><dd class="col-sm-8">{{ optional($ortu)->telp_ibu ?: '-' }}</dd>
        </dl></div></div></div>
    </div>

    <div class="card"><div class="card-header border-bottom"><h4 class="card-title">Berkas Pendaftaran</h4></div><div class="card-body"><div class="row">
        @foreach($documents as $field => $label)<div class="col-md-3 col-sm-6 mb-1"><strong>{{ $label }}</strong><br>@if(optional($berkas)->{$field})<a href="{{ asset('storage/images/berkas_murid/'.$berkas->{$field}) }}" target="_blank" rel="noopener" class="btn btn-outline-info btn-sm mt-50">Lihat Berkas</a>@else<span class="text-danger">Belum diunggah</span>@endif</div>@endforeach
    </div></div></div>

    @if($murid->role === 'Guest' && optional($detail)->proses !== 'Ditolak')
        <div class="card"><div class="card-body"><h4>Keputusan PPDB</h4><form action="{{ route('data-murid.update', $murid->id) }}" method="POST" class="row align-items-end">@csrf @method('PUT')
            <div class="col-md-4"><div class="form-group mb-md-0"><label>NIS</label><input type="text" inputmode="numeric" name="nis" value="{{ old('nis', optional($detail)->nis) }}" class="form-control @error('nis') is-invalid @enderror" required>@error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
            <div class="col-md-4"><div class="form-group mb-md-0"><label>NISN</label><input type="text" inputmode="numeric" name="nisn" value="{{ old('nisn', optional($detail)->nisn) }}" class="form-control @error('nisn') is-invalid @enderror" required>@error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
            <div class="col-md-4"><button class="btn btn-success" {{ $ready ? '' : 'disabled' }}>Terima Menjadi Murid</button></div>
        </form><hr><form action="{{ route('data-murid.reject', $murid->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran calon murid ini?')">@csrf @method('PUT')<button class="btn btn-outline-danger">Tolak Pendaftaran</button></form></div></div>
    @endif
    <a href="{{ route('data-murid.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
@endsection
