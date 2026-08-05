@extends('layouts.backend.app')

@section('title', 'Biodata PPDB')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif
    <div class="content-header row"><div class="col-12 mb-2"><h2>1. Biodata Calon Murid</h2><p class="text-muted mb-0">Lengkapi data dengan benar sesuai dokumen resmi.</p></div></div>
    <div class="card"><div class="card-body">
        <form action="{{ route('ppdb.form-pendaftaran.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6"><div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', optional($user->muridDetail)->tempat_lahir) }}" class="form-control @error('tempat_lahir') is-invalid @enderror" required>@error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', optional($user->muridDetail)->tgl_lahir) }}" class="form-control @error('tgl_lahir') is-invalid @enderror" required>@error('tgl_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>Agama</label><select name="agama" class="form-control @error('agama') is-invalid @enderror" required><option value="">-- Pilih --</option>@foreach(['Islam','Kristen Katolik','Kristen Protestan','Hindu','Budha','Konghucu'] as $agama)<option value="{{ $agama }}" {{ old('agama', optional($user->muridDetail)->agama) === $agama ? 'selected' : '' }}>{{ $agama }}</option>@endforeach</select>@error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>Asal Sekolah</label><input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', optional($user->muridDetail)->asal_sekolah) }}" class="form-control @error('asal_sekolah') is-invalid @enderror" required>@error('asal_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>No. Telepon</label><input type="text" inputmode="numeric" name="telp" value="{{ old('telp', optional($user->muridDetail)->telp) }}" class="form-control @error('telp') is-invalid @enderror" required>@error('telp')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-md-6"><div class="form-group"><label>No. WhatsApp</label><input type="text" inputmode="numeric" name="whatsapp" value="{{ old('whatsapp', optional($user->muridDetail)->whatsapp) }}" class="form-control @error('whatsapp') is-invalid @enderror" required>@error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="col-12"><div class="form-group"><label>Alamat Lengkap</label><textarea name="alamat" rows="4" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', optional($user->muridDetail)->alamat) }}</textarea>@error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
            </div>
            <button class="btn btn-primary">Simpan & Lanjutkan</button><a href="{{ route('home') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div></div>
</div>
@endsection
