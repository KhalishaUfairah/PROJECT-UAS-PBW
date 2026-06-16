<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TaskMaster</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
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
        }
        .auth-card {
            background: #13161e;
            border: 1px solid #252a38;
            border-radius: 18px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
        }
        .logo {
            font-family: 'Syne', sans-serif;
            font-size: 1.9rem;
            font-weight: 800;
            background: linear-gradient(135deg, #5b73ff, #a56cfe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 4px;
            text-align: center;
        }
        .auth-sub { color: #8b93ab; font-size: .875rem; margin-bottom: 32px; text-align: center; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: .82rem; font-weight: 600; color: #8b93ab; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 11px 14px 11px 38px;
            background: #1a1e2a; border: 1px solid #252a38;
            border-radius: 10px; color: #e8ecf4;
            font-family: inherit; font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus { outline: none; border-color: #5b73ff; box-shadow: 0 0 0 3px rgba(91,115,255,.15); }
        .form-control::placeholder { color: #5a6278; }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap i { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #5a6278; font-size: .875rem; }
        .form-error { font-size: .75rem; color: #ff5e6e; margin-top: 4px; }
        .btn-submit {
            width: 100%; padding: 12px;
            background: #5b73ff; border: none;
            border-radius: 10px; color: #fff;
            font-family: inherit; font-size: .95rem; font-weight: 700;
            cursor: pointer; transition: all .2s;
            margin-top: 6px;
        }
        .btn-submit:hover { background: #7c8fff; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(91,115,255,.4); }
        .auth-link { text-align: center; margin-top: 18px; font-size: .85rem; color: #5a6278; }
        .auth-link a { color: #7c8fff; text-decoration: none; font-weight: 600; }
        .auth-link a:hover { text-decoration: underline; }
        .alert { padding: 11px 14px; border-radius: 10px; font-size: .85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .alert-danger { background: rgba(255,94,110,.1); border: 1px solid rgba(255,94,110,.2); color: #ff5e6e; }
        .demo-accounts {
            margin-top: 20px; padding: 13px 14px;
            background: rgba(91,115,255,.06); border: 1px solid rgba(91,115,255,.15);
            border-radius: 10px; font-size: .78rem; color: #8b93ab;
        }
        .demo-accounts strong { color: #e8ecf4; display: block; margin-bottom: 5px; }
        .demo-accounts code { background: #1a1e2a; padding: 1px 6px; border-radius: 4px; color: #a56cfe; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo">TaskMaster</div>
        <p class="auth-sub">Masuk ke akun kamu</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama</label>
                <div class="input-icon-wrap">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control"
                           placeholder="Masukkan nama kamu" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-icon-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control"
                           placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-right-to-bracket"></i> Masuk
            </button>
        </form>

        <div class="auth-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>

        <div class="demo-accounts">
            <strong>🔑 Akun Demo (setelah seeder):</strong>
            Admin: <code>Administrator</code> / <code>admin123</code><br>
            Student: <code>Budi Santoso</code> / <code>password</code>
        </div>
    </div>
</body>
</html>
