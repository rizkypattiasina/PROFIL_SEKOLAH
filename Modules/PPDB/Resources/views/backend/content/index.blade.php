@extends('layouts.backend.app')

@section('title', 'Konten PPDB')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2"><h2>Konten Halaman PPDB</h2><p class="text-muted mb-0">Kelola menu Program, Alur, Berkas, dan Informasi yang tampil di halaman publik.</p></div>
        <div class="content-header-right col-md-4 col-12 mb-2 text-md-right"><a href="{{ route('ppdb-content.create', ['section' => $section]) }}" class="btn btn-primary">Tambah Konten</a></div>
    </div>

    <div class="card"><div class="card-body pb-0">
        <ul class="nav nav-pills mb-2">
            <li class="nav-item"><a class="nav-link {{ !$section ? 'active' : '' }}" href="{{ route('ppdb-content.index') }}">Semua</a></li>
            @foreach($sections as $key => $label)<li class="nav-item"><a class="nav-link {{ $section === $key ? 'active' : '' }}" href="{{ route('ppdb-content.index', ['section' => $key]) }}">{{ $label }}</a></li>@endforeach
        </ul>
    </div><div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>Urutan</th><th>Bagian</th><th>Judul</th><th>Isi</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($contents as $item)
            <tr><td>{{ $item->sort_order }}</td><td><span class="badge badge-light-primary">{{ $sections[$item->section] ?? ucfirst($item->section) }}</span></td><td><strong>{{ $item->title }}</strong><br><small>Ikon: {{ $item->icon }}</small></td><td>{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 110) }}</td><td><span class="badge badge-{{ $item->is_active ? 'success' : 'secondary' }}">{{ $item->is_active ? 'Tampil' : 'Disembunyikan' }}</span></td><td><a href="{{ route('ppdb-content.edit', $item) }}" class="btn btn-info btn-sm">Edit</a><form action="{{ route('ppdb-content.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten PPDB ini?')">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">Hapus</button></form></td></tr>
        @empty<tr><td colspan="6" class="text-center text-muted py-3">Belum ada konten pada bagian ini.</td></tr>@endforelse
        </tbody>
    </table></div><div class="card-body">{{ $contents->links() }}</div></div>
</div>
@endsection
