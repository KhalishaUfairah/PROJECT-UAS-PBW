<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TaskMaster') — Manajemen Tugas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg:         #0d0f14;
            --bg2:        #13161e;
            --bg3:        #1a1e2a;
            --border:     #252a38;
            --border2:    #2e3447;
            --text:       #e8ecf4;
            --text2:      #8b93ab;
            --text3:      #5a6278;
            --accent:     #5b73ff;
            --accent2:    #7c8fff;
            --green:      #22d3a0;
            --yellow:     #f5c542;
            --red:        #ff5e6e;
            --orange:     #ff8c42;
            --purple:     #a56cfe;
            --radius:     12px;
            --radius-lg:  18px;
            --shadow:     0 4px 24px rgba(0,0,0,.4);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }
        /* ─── Sidebar ─────────────────────────────── */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--bg2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 100;
            transition: transform .3s;
        }
        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }
        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--accent), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .logo-sub { font-size: .7rem; color: var(--text3); letter-spacing: .12em; text-transform: uppercase; margin-top: 2px; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-section-label {
            font-size: .65rem; color: var(--text3); text-transform: uppercase;
            letter-spacing: .15em; padding: 8px 12px 6px; font-weight: 600;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 10px;
            color: var(--text2); text-decoration: none;
            font-size: .875rem; font-weight: 500;
            transition: all .2s; margin-bottom: 2px;
        }
        .nav-item:hover { background: var(--bg3); color: var(--text); }
        .nav-item.active { background: rgba(91,115,255,.15); color: var(--accent2); }
        .nav-item i { width: 18px; text-align: center; font-size: .9rem; }
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }
        .user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            background: var(--bg3);
        }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--purple));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .875rem; flex-shrink: 0;
        }
        .user-name { font-size: .85rem; font-weight: 600; color: var(--text); }
        .user-role { font-size: .7rem; color: var(--text3); }
        .logout-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 12px; border-radius: 8px; width: 100%;
            background: none; border: none; cursor: pointer;
            color: var(--text3); font-size: .8rem; font-family: inherit;
            transition: all .2s; margin-top: 6px;
        }
        .logout-btn:hover { background: rgba(255,94,110,.1); color: var(--red); }
        /* ─── Main Content ────────────────────────── */
        .main-wrapper { margin-left: 250px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 32px;
            border-bottom: 1px solid var(--border);
            background: var(--bg);
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 700; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .main-content { padding: 28px 32px; flex: 1; }
        /* ─── Cards ───────────────────────────────── */
        .card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 24px;
        }
        /* ─── Buttons ─────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 9px; font-size: .85rem;
            font-weight: 600; font-family: inherit; cursor: pointer;
            border: none; text-decoration: none; transition: all .2s;
        }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent2); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(91,115,255,.35); }
        .btn-danger { background: rgba(255,94,110,.15); color: var(--red); border: 1px solid rgba(255,94,110,.25); }
        .btn-danger:hover { background: rgba(255,94,110,.25); }
        .btn-ghost { background: var(--bg3); color: var(--text2); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--border); color: var(--text); }
        .btn-sm { padding: 6px 12px; font-size: .78rem; border-radius: 7px; }
        .btn-green { background: rgba(34,211,160,.15); color: var(--green); border: 1px solid rgba(34,211,160,.25); }
        .btn-green:hover { background: rgba(34,211,160,.25); }
        /* ─── Badges ──────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
        }
        .badge-urgent  { background: rgba(255,94,110,.15);  color: var(--red);    border: 1px solid rgba(255,94,110,.2); }
        .badge-high    { background: rgba(255,140,66,.15);  color: var(--orange); border: 1px solid rgba(255,140,66,.2); }
        .badge-medium  { background: rgba(245,197,66,.15);  color: var(--yellow); border: 1px solid rgba(245,197,66,.2); }
        .badge-low     { background: rgba(34,211,160,.15);  color: var(--green);  border: 1px solid rgba(34,211,160,.2); }
        .badge-todo        { background: rgba(139,147,171,.15); color: var(--text3); }
        .badge-in_progress { background: rgba(91,115,255,.15);  color: var(--accent2); }
        .badge-done        { background: rgba(34,211,160,.15);  color: var(--green); }
        .badge-cancelled   { background: rgba(255,94,110,.1);   color: var(--red); }
        /* ─── Forms ───────────────────────────────── */
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: .82rem; font-weight: 600; color: var(--text2); margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px;
            background: var(--bg3); border: 1px solid var(--border2);
            border-radius: 9px; color: var(--text);
            font-family: inherit; font-size: .875rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(91,115,255,.15); }
        .form-control::placeholder { color: var(--text3); }
        .form-error { font-size: .75rem; color: var(--red); margin-top: 4px; }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        /* ─── Alerts ──────────────────────────────── */
        .alert {
            padding: 12px 16px; border-radius: 10px;
            display: flex; align-items: center; gap: 10px;
            font-size: .85rem; margin-bottom: 20px;
        }
        .alert-success { background: rgba(34,211,160,.1); border: 1px solid rgba(34,211,160,.2); color: var(--green); }
        .alert-danger  { background: rgba(255,94,110,.1);  border: 1px solid rgba(255,94,110,.2);  color: var(--red); }
        /* ─── Progress ────────────────────────────── */
        .progress-bar { height: 6px; background: var(--bg3); border-radius: 99px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--accent), var(--purple)); transition: width .5s; }
        /* ─── Stat Cards ──────────────────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card {
            background: var(--bg2); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 20px;
            transition: border-color .2s, transform .2s;
        }
        .stat-card:hover { border-color: var(--border2); transform: translateY(-2px); }
        .stat-icon { font-size: 1.4rem; margin-bottom: 10px; }
        .stat-value { font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 800; }
        .stat-label { font-size: .75rem; color: var(--text3); margin-top: 2px; }
        /* ─── Table ───────────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        thead th { padding: 10px 14px; text-align: left; color: var(--text3); font-size: .72rem; text-transform: uppercase; letter-spacing: .08em; border-bottom: 1px solid var(--border); }
        tbody td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:hover td { background: var(--bg3); }
        /* ─── Misc ────────────────────────────────── */
        .tag { display: inline-block; padding: 2px 8px; border-radius: 6px; font-size: .7rem; background: var(--bg3); color: var(--text2); border: 1px solid var(--border); }
        .empty-state { text-align: center; padding: 64px 20px; color: var(--text3); }
        .empty-state .icon { font-size: 3rem; margin-bottom: 12px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .page-title { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 700; }
        .divider { height: 1px; background: var(--border); margin: 20px 0; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-text">TaskMaster</div>
        <div class="logo-sub">Manajemen Tugas</div>
    </div>

    <nav class="sidebar-nav">
        @if(Auth::user()->isAdmin())
            <div class="nav-section-label">Admin</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Pengguna
            </a>
            <a href="{{ route('admin.categories') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="{{ route('admin.tasks') }}" class="nav-item {{ request()->routeIs('admin.tasks') ? 'active' : '' }}">
                <i class="fas fa-list-check"></i> Semua Tugas
            </a>
        @else
            <div class="nav-section-label">Menu</div>
            <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                <i class="fas fa-house"></i> Dashboard
            </a>
            <a href="{{ route('tasks.create') }}" class="nav-item {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i> Tambah Tugas
            </a>
            <div class="nav-section-label" style="margin-top:12px">Filter Cepat</div>
            <a href="{{ route('tasks.index', ['status' => 'todo']) }}" class="nav-item">
                <i class="fas fa-circle-dot"></i> Belum Mulai
            </a>
            <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}" class="nav-item">
                <i class="fas fa-spinner"></i> Dikerjakan
            </a>
            <a href="{{ route('tasks.index', ['status' => 'done']) }}" class="nav-item">
                <i class="fas fa-circle-check"></i> Selesai
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ Str::limit(Auth::user()->name, 18) }}</div>
                <div class="user-role">{{ Auth::user()->isAdmin() ? 'Administrator' : 'Mahasiswa' }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i> Keluar
            </button>
        </form>
    </div>
</aside>

<div class="main-wrapper">
    <header class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-actions">@yield('topbar-actions')</div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-triangle-exclamation"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
