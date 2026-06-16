@extends('layouts.app')
@section('title', $user->name)
@section('page-title', 'Detail Pengguna')

@section('content')
<div style="margin-bottom:16px">
    <a href="{{ route('admin.users') }}" style="color:var(--text3);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengguna
    </a>
</div>

<div style="display:grid;grid-template-columns:320px 1fr;gap:20px">
    <div>
        <div class="card">
            <div style="text-align:center;padding-bottom:20px;border-bottom:1px solid var(--border);margin-bottom:20px">
                <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--purple));display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:700;margin:0 auto 12px">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div style="font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:700">{{ $user->name }}</div>
                <div style="font-size:.8rem;color:var(--text3)">{{ $user->email }}</div>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;font-size:.875rem">
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">NIM/NIS</span>
                    <span style="font-weight:600">{{ $user->nim ?: '—' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Jurusan</span>
                    <span style="font-weight:600">{{ $user->jurusan ?: '—' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Semester</span>
                    <span style="font-weight:600">{{ $user->semester ? 'Semester '.$user->semester : '—' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Bergabung</span>
                    <span style="font-weight:600">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <div style="margin-top:20px;display:flex;gap:8px">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm" style="flex:1;justify-content:center">
                    <i class="fas fa-pen"></i> Edit
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                      onsubmit="return confirm('Hapus pengguna ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="card" style="margin-top:16px">
            <h3 style="font-size:.9rem;font-weight:700;margin-bottom:14px;color:var(--text2)">Statistik Tugas</h3>
            @php $stats = $user->task_stats; @endphp
            <div style="display:flex;flex-direction:column;gap:10px;font-size:.85rem">
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Total</span>
                    <span style="font-weight:700">{{ $stats['total'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Belum Mulai</span>
                    <span style="font-weight:600;color:var(--text2)">{{ $stats['todo'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Dikerjakan</span>
                    <span style="font-weight:600;color:var(--accent2)">{{ $stats['in_progress'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Selesai</span>
                    <span style="font-weight:600;color:var(--green)">{{ $stats['done'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Terlambat</span>
                    <span style="font-weight:600;color:var(--red)">{{ $stats['overdue'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks -->
    <div class="card">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px">Daftar Tugas ({{ $user->tasks->count() }})</h3>
        @forelse($user->tasks as $task)
            <div style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;justify-content:space-between;gap:10px">
                <div>
                    <div style="font-size:.875rem;font-weight:600;margin-bottom:4px">{{ $task->title }}</div>
                    <div style="display:flex;gap:8px;font-size:.75rem;color:var(--text3)">
                        @if($task->mata_kuliah)<span>📚 {{ $task->mata_kuliah }}</span>@endif
                        @if($task->due_date)<span>📅 {{ $task->due_date->format('d M Y') }}</span>@endif
                    </div>
                </div>
                <div style="display:flex;gap:6px;flex-shrink:0">
                    <span class="badge badge-{{ $task->priority }}">{{ $task->priority_label }}</span>
                    <span class="badge badge-{{ $task->status }}">{{ $task->status_label }}</span>
                </div>
            </div>
        @empty
            <p style="color:var(--text3);font-size:.85rem">Pengguna ini belum memiliki tugas.</p>
        @endforelse
    </div>
</div>
@endsection
