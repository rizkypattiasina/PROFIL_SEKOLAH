@php
    $identity = \App\Models\Footer::first();
    $schoolName = $identity->school_name ?? 'SMA Plus Muhammadiyah Merauke';
    $tagline = $identity->tagline ?? 'Unggul, Islami, dan Berkemajuan';
    $logo = !empty($identity->logo)
        ? asset('storage/'.(\Illuminate\Support\Str::contains($identity->logo, '/') ? $identity->logo : 'images/logo/'.$identity->logo))
        : null;
    $primary = $identity->primary_color ?? '#087f5b';
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ $schoolName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--primary:{{ $primary }};--ink:#10231d;--muted:#66756f;--line:#e1e9e6;--surface:#fff}
        *{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,sans-serif;color:var(--ink);background:#edf5f2;min-height:100vh}
        .login-shell{min-height:100vh;display:grid;grid-template-columns:minmax(0,1.1fr) minmax(420px,.9fr);padding:24px;gap:24px}
        .login-story{position:relative;overflow:hidden;border-radius:30px;padding:clamp(36px,6vw,84px);display:flex;flex-direction:column;justify-content:space-between;color:#fff;background:linear-gradient(145deg,var(--primary),#063f34)}
        .login-story:before,.login-story:after{content:"";position:absolute;border-radius:50%;background:rgba(255,255,255,.1)}.login-story:before{width:440px;height:440px;right:-170px;top:-120px}.login-story:after{width:260px;height:260px;left:-100px;bottom:-100px}
        .brand,.story-copy{position:relative;z-index:1}.brand{display:flex;align-items:center;gap:14px;color:#fff;text-decoration:none}.brand-logo{width:60px;height:60px;border-radius:17px;background:#fff;padding:8px;object-fit:contain;box-shadow:0 12px 30px rgba(0,0,0,.14)}.brand-mark{width:60px;height:60px;border-radius:17px;background:#fff;color:var(--primary);display:grid;place-items:center;font-size:25px;font-weight:800}.brand strong{display:block;font-size:18px}.brand span{font-size:12px;opacity:.76}
        .story-copy{max-width:650px}.story-copy small{display:inline-block;padding:8px 13px;border:1px solid rgba(255,255,255,.24);border-radius:999px;background:rgba(255,255,255,.1);font-weight:700}.story-copy h1{font-size:clamp(36px,5vw,68px);line-height:1.05;margin:20px 0}.story-copy p{font-size:17px;line-height:1.75;max-width:560px;color:rgba(255,255,255,.82)}
        .login-panel{display:flex;align-items:center;justify-content:center;border-radius:30px;background:var(--surface);padding:clamp(28px,5vw,70px);box-shadow:0 25px 70px rgba(22,66,52,.08)}.login-box{width:min(100%,470px)}.mobile-brand{display:none}.eyebrow{color:var(--primary);font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:.12em}.login-box h2{font-size:34px;letter-spacing:-.03em;margin:10px 0}.intro{color:var(--muted);line-height:1.65;margin:0 0 30px}.alert{padding:13px 15px;border-radius:12px;margin-bottom:18px;font-size:14px}.alert-danger{background:#fff0f0;color:#a62525}.alert-success{background:#eafaf2;color:#16714a}
        .field{margin-bottom:18px}.field label{display:block;font-size:13px;font-weight:700;margin-bottom:8px}.input-wrap{position:relative}.field input{width:100%;height:54px;border:1px solid var(--line);border-radius:14px;padding:0 48px 0 16px;font:inherit;outline:none;transition:.2s}.field input:focus{border-color:var(--primary);box-shadow:0 0 0 4px color-mix(in srgb,var(--primary) 12%,transparent)}.toggle{position:absolute;right:8px;top:8px;width:38px;height:38px;border:0;background:transparent;border-radius:10px;cursor:pointer;color:#71817b}.invalid{font-size:12px;color:#c52d2d;margin-top:6px}.options{display:flex;justify-content:space-between;align-items:center;margin:4px 0 24px;font-size:13px}.options label{display:flex;align-items:center;gap:8px}.options a{color:var(--primary);font-weight:700;text-decoration:none}.submit{height:55px;width:100%;border:0;border-radius:14px;background:var(--primary);color:#fff;font:700 15px Inter;cursor:pointer;box-shadow:0 14px 28px color-mix(in srgb,var(--primary) 26%,transparent);transition:.2s}.submit:hover{transform:translateY(-2px);filter:brightness(.95)}.back{display:block;text-align:center;margin-top:20px;color:var(--muted);font-size:13px;text-decoration:none}.back strong{color:var(--primary)}
        @media(max-width:900px){.login-shell{grid-template-columns:1fr;padding:14px}.login-story{display:none}.login-panel{min-height:calc(100vh - 28px);padding:42px 24px}.mobile-brand{display:flex;justify-content:center;margin-bottom:34px}.mobile-brand .brand{color:var(--ink)}.mobile-brand .brand span{color:var(--muted)}}
        @media(max-width:480px){.login-panel{border-radius:22px;align-items:flex-start;padding-top:38px}.login-box h2{font-size:28px}.brand-logo,.brand-mark{width:52px;height:52px}.options{align-items:flex-start;gap:12px}}
    </style>
</head>
<body>
<main class="login-shell">
    <section class="login-story">
        <a class="brand" href="{{ url('/') }}">
            @if($logo)<img class="brand-logo" src="{{ $logo }}" alt="Logo {{ $schoolName }}">@else<span class="brand-mark">S+</span>@endif
            <span><strong>{{ $schoolName }}</strong><span>{{ $tagline }}</span></span>
        </a>
        <div class="story-copy"><small>PORTAL AKADEMIK TERINTEGRASI</small><h1>Satu akses untuk seluruh layanan sekolah.</h1><p>Kelola pembelajaran, pembayaran, PPDB, perpustakaan, dan informasi akademik dengan aman dan nyaman.</p></div>
    </section>
    <section class="login-panel">
        <div class="login-box">
            <div class="mobile-brand"><a class="brand" href="{{ url('/') }}">@if($logo)<img class="brand-logo" src="{{ $logo }}" alt="Logo">@else<span class="brand-mark">S+</span>@endif<span><strong>{{ $schoolName }}</strong><span>{{ $tagline }}</span></span></a></div>
            <span class="eyebrow">Selamat datang</span><h2>Masuk ke akun Anda</h2><p class="intro">Gunakan email dan kata sandi yang telah terdaftar untuk melanjutkan.</p>
            @if($message = Session::get('error'))<div class="alert alert-danger">{{ $message }}</div>@elseif($message = Session::get('success'))<div class="alert alert-success">{{ $message }}</div>@endif
            <form action="{{ route('login') }}" method="POST">@csrf
                <div class="field"><label for="email">Alamat email</label><div class="input-wrap"><input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@sekolah.sch.id" autocomplete="email" autofocus></div>@error('email')<div class="invalid">{{ $message }}</div>@enderror</div>
                <div class="field"><label for="password">Kata sandi</label><div class="input-wrap"><input id="password" type="password" name="password" placeholder="Masukkan kata sandi" autocomplete="current-password"><button class="toggle" type="button" id="togglePassword" aria-label="Tampilkan kata sandi">●</button></div>@error('password')<div class="invalid">{{ $message }}</div>@enderror</div>
                <div class="options"><label><input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}> Ingat saya</label>@if(Route::has('password.request'))<a href="{{ route('password.request') }}">Lupa kata sandi?</a>@endif</div>
                <button class="submit" type="submit">Masuk ke Dashboard</button>
            </form>
            <a class="back" href="{{ url('/') }}">← Kembali ke <strong>halaman utama</strong></a>
        </div>
    </section>
</main>
<script>document.getElementById('togglePassword').addEventListener('click',function(){const p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.textContent=p.type==='password'?'●':'◉';});</script>
</body></html>
