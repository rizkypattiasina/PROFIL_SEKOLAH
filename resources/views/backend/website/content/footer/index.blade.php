@extends('layouts.backend.app')
@section('title','Pengaturan Website')
@section('content')
<div class="content-wrapper container-xxl p-0">
  <div class="content-header row"><div class="col-12 mb-2">
    <h2 class="content-header-title">Pengaturan Website</h2>
    <p class="text-muted">Kelola identitas sekolah, logo, warna, kontak, profil media sosial, dan feed halaman utama dari satu tempat.</p>
  </div></div>
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  @if($errors->any())<div class="alert alert-danger"><strong>Periksa kembali data:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
  <form action="{{ $footer ? route('backend-footer.update',$footer->id) : route('backend-footer.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($footer) @method('PUT') @endif
    <div class="row">
      <div class="col-lg-8">
        <div class="card"><div class="card-header"><h4 class="card-title">Identitas Sekolah</h4></div><div class="card-body"><div class="row">
          <div class="form-group col-md-7"><label>Nama Sekolah *</label><input class="form-control" name="school_name" value="{{ old('school_name',$footer->school_name ?? 'SMA Plus Muhammadiyah Merauke') }}" required></div>
          <div class="form-group col-md-5"><label>Tagline</label><input class="form-control" name="tagline" value="{{ old('tagline',$footer->tagline ?? '') }}"></div>
          <div class="form-group col-12"><label>Deskripsi Singkat</label><textarea class="form-control" name="desc" rows="3">{{ old('desc',$footer->desc ?? '') }}</textarea></div>
          <div class="form-group col-12"><label>Alamat</label><textarea class="form-control" name="address" rows="2">{{ old('address',$footer->address ?? '') }}</textarea></div>
          <div class="form-group col-md-4"><label>Email</label><input type="email" class="form-control" name="email" value="{{ old('email',$footer->email ?? '') }}"></div>
          <div class="form-group col-md-4"><label>Telepon</label><input class="form-control" name="telp" value="{{ old('telp',$footer->telp ?? '') }}"></div>
          <div class="form-group col-md-4"><label>WhatsApp</label><input class="form-control" name="whatsapp" value="{{ old('whatsapp',$footer->whatsapp ?? '') }}"></div>
        </div></div></div>
        <div class="card"><div class="card-header"><div><h4 class="card-title">Media Sosial &amp; Feed</h4><small class="text-muted">Feed tampil di halaman utama tepat di bawah bagian Pengajar.</small></div></div><div class="card-body">
          <h5 class="mb-1">Tautan profil</h5>
          <div class="row">
            @foreach(['facebook'=>'Facebook','instagram'=>'Instagram','tiktok'=>'TikTok','youtube'=>'YouTube','twitter'=>'X / Twitter','linkedin'=>'LinkedIn'] as $field=>$label)
            <div class="form-group col-md-6"><label>{{ $label }}</label><input type="url" class="form-control" name="{{ $field }}" placeholder="https://..." value="{{ old($field,$footer->{$field} ?? '') }}"></div>
            @endforeach
          </div>
          <hr>
          <h5 class="mb-1">Identitas akun</h5>
          <p class="text-muted small">Digunakan sebagai nama akun di tombol feed. Tanda @ boleh ditulis atau dihilangkan. Username Instagram/TikTok akan dibaca dari tautan profil bila kolom ini kosong.</p>
          <div class="row">
            <div class="form-group col-md-4"><label>Username Instagram</label><input class="form-control" name="instagram_handle" placeholder="contoh: sekolahku" value="{{ old('instagram_handle',$footer->instagram_handle ?? '') }}"></div>
            <div class="form-group col-md-4"><label>Username TikTok</label><input class="form-control" name="tiktok_handle" placeholder="contoh: sekolahku" value="{{ old('tiktok_handle',$footer->tiktok_handle ?? '') }}"></div>
            <div class="form-group col-md-4"><label>Nama Channel YouTube</label><input class="form-control" name="youtube_handle" placeholder="contoh: Sekolahku Official" value="{{ old('youtube_handle',$footer->youtube_handle ?? '') }}"></div>
          </div>
          <hr>
          <h5 class="mb-1">Konten yang ditampilkan</h5>
          <p class="text-muted small">Tempel tautan konten publik. Konten harus mengizinkan penyematan (embed). Jika URL YouTube dikosongkan, sistem memakai video aktif terbaru dari menu Video.</p>
          <div class="form-group"><label>URL Post/Reel Instagram</label><input type="url" class="form-control" name="instagram_embed_url" placeholder="https://www.instagram.com/p/... atau /reel/..." value="{{ old('instagram_embed_url',$footer->instagram_embed_url ?? '') }}"></div>
          <div class="form-group"><label>URL Video TikTok</label><input type="url" class="form-control" name="tiktok_embed_url" placeholder="https://www.tiktok.com/@username/video/..." value="{{ old('tiktok_embed_url',$footer->tiktok_embed_url ?? '') }}"></div>
          <div class="form-group mb-0"><label>URL Video YouTube</label><input type="url" class="form-control" name="youtube_embed_url" placeholder="https://www.youtube.com/watch?v=..." value="{{ old('youtube_embed_url',$footer->youtube_embed_url ?? '') }}"></div>
        </div></div>
      </div>
      <div class="col-lg-4">
        <div class="card"><div class="card-header"><h4 class="card-title">Branding</h4></div><div class="card-body">
          @if(!empty($footer->logo))<div class="text-center mb-2"><img src="{{ asset('storage/'.(\Illuminate\Support\Str::contains($footer->logo, '/') ? $footer->logo : 'images/logo/'.$footer->logo)) }}" style="max-height:100px;max-width:100%" alt="Logo saat ini"></div>@endif
          <div class="form-group"><label>Logo {{ $footer ? '' : '*' }}</label><input type="file" class="form-control-file" name="logo" accept="image/png,image/jpeg,image/webp"><small class="text-muted">PNG/JPG/WEBP, maksimal 2 MB.</small></div>
          <div class="form-group"><label>Favicon</label><input type="file" class="form-control-file" name="favicon" accept="image/*"></div>
          <div class="row"><div class="form-group col-6"><label>Warna Utama</label><input type="color" class="form-control" name="primary_color" value="{{ old('primary_color',$footer->primary_color ?? '#087f5b') }}"></div>
          <div class="form-group col-6"><label>Warna Aksen</label><input type="color" class="form-control" name="secondary_color" value="{{ old('secondary_color',$footer->secondary_color ?? '#f59f00') }}"></div></div>
          <button class="btn btn-primary btn-block" type="submit"><i data-feather="save" class="mr-50"></i>Simpan Pengaturan</button>
          <a href="{{ route('frontend.home') }}" target="_blank" class="btn btn-outline-secondary btn-block">Lihat Website</a>
        </div></div>
      </div>
    </div>
  </form>
</div>
@endsection
