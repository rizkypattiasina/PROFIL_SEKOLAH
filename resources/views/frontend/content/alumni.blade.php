@extends('layouts.Frontend.app')
@section('title','Alumni')
@section('content')
<section class="school-page-hero"><div class="container"><span>Jejaring Sekolah</span><h1>Alumni Kami</h1><p>Generasi yang tumbuh, berkarya, dan membawa nilai Muhammadiyah di tengah masyarakat.</p></div></section>
<section class="alumni-directory"><div class="container"><div class="row">@forelse($alumni as $item)<div class="col-lg-3 col-md-4 col-sm-6"><article class="alumni-card"><div class="alumni-avatar">{{ strtoupper(substr($item->name,0,1)) }}</div><h3>{{ $item->name }}</h3><p>Alumni {{ $footer->school_name ?? 'SMA Plus Muhammadiyah Merauke' }}</p></article></div>@empty<div class="col-12"><div class="public-video-empty"><h3>Data alumni belum tersedia</h3><p>Data akan tampil setelah dikelola oleh administrator.</p></div></div>@endforelse</div>{{ $alumni->links() }}</div></section>
@endsection
