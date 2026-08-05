@extends('layouts.backend.app')

@section('title', $content->exists ? 'Edit Konten PPDB' : 'Tambah Konten PPDB')

@section('content')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row"><div class="col-12 mb-2"><h2>{{ $content->exists ? 'Edit' : 'Tambah' }} Konten PPDB</h2></div></div>
    <div class="row"><div class="col-lg-8 col-12"><div class="card"><div class="card-body">
        <form action="{{ $content->exists ? route('ppdb-content.update', $content) : route('ppdb-content.store') }}" method="POST">
            @csrf @if($content->exists) @method('PUT') @endif
            <div class="form-group"><label for="section">Bagian Menu</label><select name="section" id="section" class="form-control @error('section') is-invalid @enderror" required>@foreach($sections as $key => $label)<option value="{{ $key }}" {{ old('section', $content->section) === $key ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select>@error('section')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label for="title">Judul</label><input type="text" name="title" id="title" value="{{ old('title', $content->title) }}" class="form-control @error('title') is-invalid @enderror" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label for="content">Isi / Keterangan</label><textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror">{{ old('content', $content->content) }}</textarea>@error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="row"><div class="col-md-6"><div class="form-group"><label for="icon">Nama Ikon Feather</label><input type="text" name="icon" id="icon" value="{{ old('icon', $content->icon ?: 'check-circle') }}" class="form-control"><small class="text-muted">Contoh: award, file-text, check-circle.</small></div></div><div class="col-md-6"><div class="form-group"><label for="sort_order">Nomor Urut</label><input type="number" min="0" name="sort_order" id="sort_order" value="{{ old('sort_order', $content->sort_order ?? 0) }}" class="form-control" required></div></div></div>
            <input type="hidden" name="is_active" value="0"><div class="custom-control custom-switch mb-2"><input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $content->is_active) ? 'checked' : '' }}><label class="custom-control-label" for="is_active">Tampilkan di halaman PPDB</label></div>
            <button class="btn btn-primary">Simpan</button><a href="{{ route('ppdb-content.index', ['section' => old('section', $content->section)]) }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div></div></div></div>
</div>
@endsection
