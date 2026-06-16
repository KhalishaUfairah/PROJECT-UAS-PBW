<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — TaskMaster</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #0d0f14;
            color: #e8ecf4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }
        .auth-card {
            background: #13161e;
            border: 1px solid #252a38;
            border-radius: 18px;
            padding: 40px;
            width: 100%;
            max-width: 520px;
        }
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: #8b93ab; font-size: .8rem; text-decoration: none; margin-bottom: 24px; }
        .back-link:hover { color: #e8ecf4; }
        .auth-logo { font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 800; background: linear-gradient(135deg, #5b73ff, #a56cfe); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 4px; }
        .auth-title { font-family: 'Syne', sans-serif; font-size: 1.7rem; font-weight: 700; margin-bottom: 4px; }
        .auth-sub { color: #8b93ab; font-size: .875rem; margin-bottom: 28px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 16px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { display: block; font-size: .8rem; font-weight: 600; color: #8b93ab; margin-bottom: 5px; }
        .form-control {
            width: 100%; padding: 10px 13px;
            background: #1a1e2a; border: 1px solid #252a38;
            border-radius: 9px; color: #e8ecf4;
            font-family: inherit; font-size: .875rem;
            transition: border-color .2s;
        }
        .form-control:focus { outline: none; border-color: #5b73ff; }
        .form-control::placeholder { color: #5a6278; }
        .form-error { font-size: .73rem; color: #ff5e6e; margin-top: 3px; }
        .section-label { font-size: .7rem; text-transform: uppercase; letter-spacing: .12em; color: #5a6278; font-weight: 600; margin-bottom: 12px; margin-top: 20px; }
        .btn-submit {
            width: 100%; padding: 12px;
            background: #5b73ff; border: none; border-radius: 10px;
            color: #fff; font-family: inherit; font-size: .95rem; font-weight: 700;
            cursor: pointer; transition: all .2s; margin-top: 6px;
        }
        .btn-submit:hover { background: #7c8fff; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(91,115,255,.4); }
        .auth-link { text-align: center; margin-top: 16px; font-size: .85rem; color: #5a6278; }
        .auth-link a { color: #7c8fff; text-decoration: none; font-weight: 600; }
        .alert { padding: 10px 14px; border-radius: 9px; font-size: .83rem; margin-bottom: 16px; }
        .alert-danger { background: rgba(255,94,110,.1); border: 1px solid rgba(255,94,110,.2); color: #ff5e6e; }
    </style>
</head>
<body>
<div class="auth-card">
    <a href="{{ route('login') }}" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke login</a>
    <div class="auth-logo">TaskMaster</div>
    <h1 class="auth-title">Buat Akun Baru</h1>
    <p class="auth-sub">Daftarkan diri kamu sebagai mahasiswa/siswa</p>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
                <div>• {{ $err }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="section-label">Informasi Akun</div>
        <div class="form-group">
            <label class="form-label">Nama Lengkap *</label>
            <input type="text" name="name" class="form-control" placeholder="Nama lengkap" value="{{ old('name') }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
        </div>

        <div class="section-label">Informasi Akademik (Opsional)</div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">NIM / NIS</label>
                <input type="text" name="nim" class="form-control" placeholder="Nomor induk" value="{{ old('nim') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-control">
                    <option value="">Pilih semester</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Jurusan / Program Studi</label>
            <input type="text" name="jurusan" class="form-control" placeholder="Contoh: Teknik Informatika" value="{{ old('jurusan') }}">
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-user-plus"></i> Buat Akun
        </button>
    </form>

    <div class="auth-link">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
    </div>
</div>
</body>
</html>
