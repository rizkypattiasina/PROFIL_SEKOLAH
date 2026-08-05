@extends('layouts.backend.app')

@section('title', 'Data Calon Murid')

@section('content')
<div class="content-wrapper container-xxl p-0">
    @if(session('success'))<div class="alert alert-success"><div class="alert-body"><strong>{{ session('success') }}</strong></div></div>@endif
    @if(session('error'))<div class="alert alert-danger"><div class="alert-body"><strong>{{ session('error') }}</strong></div></div>@endif
    <div class="content-header row"><div class="col-12 mb-2"><h2>Data Calon Murid</h2><p class="text-muted mb-0">Verifikasi pendaftar, lihat berkas, lalu terima atau tolak pendaftaran.</p></div></div>
    <div class="card"><div class="card-body pb-0"><ul class="nav nav-pills mb-2">
        <li class="nav-item"><a class="nav-link {{ !$status ? 'active' : '' }}" href="{{ route('data-murid.index') }}">Semua</a></li>
        @foreach($allowed as $itemStatus)<li class="nav-item"><a class="nav-link {{ $status === $itemStatus ? 'active' : '' }}" href="{{ route('data-murid.index', ['status' => $itemStatus]) }}">{{ $itemStatus }}</a></li>@endforeach
    </ul></div><div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>No</th><th>Nama</th><th>Kontak</th><th>Asal Sekolah</th><th>Proses</th><th>Akun</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($murid as $student)
            <tr>
                <td>{{ ($murid->currentPage() - 1) * $murid->perPage() + $loop->iteration }}</td>
                <td><strong>{{ $student->name }}</strong><br><small>{{ $student->email }}</small></td>
                <td>{{ optional($student->muridDetail)->whatsapp ?: '-' }}</td>
                <td>{{ optional($student->muridDetail)->asal_sekolah ?: '-' }}</td>
                <td><span class="badge badge-{{ optional($student->muridDetail)->proses === 'Murid' ? 'success' : (optional($student->muridDetail)->proses === 'Ditolak' ? 'danger' : 'warning') }}">{{ optional($student->muridDetail)->proses ?: 'Pendaftaran' }}</span></td>
                <td>{{ $student->role }}</td>
                <td><a href="{{ route('data-murid.show', $student->id) }}" class="btn btn-primary btn-sm">Detail & Verifikasi</a></td>
            </tr>
        @empty<tr><td colspan="7" class="text-center text-muted py-3">Belum ada data pendaftar.</td></tr>@endforelse
        </tbody>
    </table></div><div class="card-body">{{ $murid->links() }}</div></div>
</div>
@endsection
