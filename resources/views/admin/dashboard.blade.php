@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="stats-grid" style="grid-template-columns:repeat(5,1fr)">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value" style="color:var(--accent2)">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total Mahasiswa</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-value">{{ $stats['total_tasks'] }}</div>
        <div class="stat-label">Total Tugas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value" style="color:var(--green)">{{ $stats['done_tasks'] }}</div>
        <div class="stat-label">Tugas Selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🔥</div>
        <div class="stat-value" style="color:var(--red)">{{ $stats['overdue_tasks'] }}</div>
        <div class="stat-label">Terlambat</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🏷️</div>
        <div class="stat-value" style="color:var(--purple)">{{ $stats['total_categories'] }}</div>
        <div class="stat-label">Kategori</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
    <!-- Recent Users -->
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
            <h3 style="font-size:1rem;font-weight:700">Pengguna Terbaru</h3>
            <a href="{{ route('admin.users') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
        </div>
        @forelse($recentUsers as $user)
            <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)">
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--purple));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div style="flex:1">
                    <div style="font-size:.875rem;font-weight:600">{{ $user->name }}</div>
                    <div style="font-size:.75rem;color:var(--text3)">{{ $user->email }}</div>
                </div>
                @if($user->jurusan)
                    <span class="tag">{{ $user->jurusan }}</span>
                @endif
            </div>
        @empty
            <p style="color:var(--text3);font-size:.85rem">Belum ada pengguna.</p>
        @endforelse
    </div>

    <!-- Recent Tasks -->
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
            <h3 style="font-size:1rem;font-weight:700">Tugas Terbaru</h3>
            <a href="{{ route('admin.tasks') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
        </div>
        @forelse($recentTasks as $task)
            <div style="padding:10px 0;border-bottom:1px solid var(--border)">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
                    <div>
                        <div style="font-size:.875rem;font-weight:600">{{ Str::limit($task->title, 40) }}</div>
                        <div style="font-size:.75rem;color:var(--text3)">{{ $task->user->name }}</div>
                    </div>
                    <span class="badge badge-{{ $task->priority }}">{{ $task->priority_label }}</span>
                </div>
            </div>
        @empty
            <p style="color:var(--text3);font-size:.85rem">Belum ada tugas.</p>
        @endforelse
    </div>
</div>

<!-- Quick Links -->
<div style="margin-top:20px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
    <a href="{{ route('admin.users') }}" class="card" style="text-decoration:none;display:flex;align-items:center;gap:16px;transition:all .2s"
       onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border)'">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(91,115,255,.15);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">👥</div>
        <div>
            <div style="font-weight:700;font-size:.95rem">Kelola Pengguna</div>
            <div style="font-size:.75rem;color:var(--text3)">CRUD mahasiswa/siswa</div>
        </div>
    </a>
    <a href="{{ route('admin.categories') }}" class="card" style="text-decoration:none;display:flex;align-items:center;gap:16px;transition:all .2s"
       onmouseover="this.style.borderColor='var(--purple)'" onmouseout="this.style.borderColor='var(--border)'">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(165,108,254,.15);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">🏷️</div>
        <div>
            <div style="font-weight:700;font-size:.95rem">Kelola Kategori</div>
            <div style="font-size:.75rem;color:var(--text3)">Tambah/edit kategori tugas</div>
        </div>
    </a>
    <a href="{{ route('admin.tasks') }}" class="card" style="text-decoration:none;display:flex;align-items:center;gap:16px;transition:all .2s"
       onmouseover="this.style.borderColor='var(--green)'" onmouseout="this.style.borderColor='var(--border)'">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(34,211,160,.15);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">📊</div>
        <div>
            <div style="font-weight:700;font-size:.95rem">Monitor Tugas</div>
            <div style="font-size:.75rem;color:var(--text3)">Lihat semua tugas siswa</div>
        </div>
    </a>
</div>
@endsection
