@extends('layouts.app')
@section('title', 'Monitor Semua Tugas')
@section('page-title', 'Monitor Tugas')

@section('content')
<form method="GET" style="margin-bottom:20px;display:flex;gap:10px;flex-wrap:wrap">
    <div style="position:relative;flex:1;min-width:200px">
        <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:.8rem"></i>
        <input type="text" name="search" class="form-control" style="padding-left:34px" placeholder="Cari judul atau nama siswa…" value="{{ request('search') }}">
    </div>
    <select name="status" class="form-control" style="width:auto">
        <option value="">Semua Status</option>
        <option value="todo" {{ request('status')=='todo'?'selected':'' }}>Belum Mulai</option>
        <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>Dikerjakan</option>
        <option value="done" {{ request('status')=='done'?'selected':'' }}>Selesai</option>
        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Dibatalkan</option>
    </select>
    <select name="priority" class="form-control" style="width:auto">
        <option value="">Semua Prioritas</option>
        <option value="urgent" {{ request('priority')=='urgent'?'selected':'' }}>Urgent</option>
        <option value="high" {{ request('priority')=='high'?'selected':'' }}>Tinggi</option>
        <option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Sedang</option>
        <option value="low" {{ request('priority')=='low'?'selected':'' }}>Rendah</option>
    </select>
    <button type="submit" class="btn btn-ghost btn-sm"><i class="fas fa-filter"></i> Filter</button>
    @if(request()->hasAny(['search','status','priority']))
        <a href="{{ route('admin.tasks') }}" class="btn btn-ghost btn-sm"><i class="fas fa-xmark"></i></a>
    @endif
</form>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul Tugas</th>
                    <th>Mahasiswa</th>
                    <th>Mata Kuliah</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Deadline</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:.875rem">{{ Str::limit($task->title,45) }}</div>
                            @if($task->category)
                                <div style="font-size:.7rem;color:var(--text3)">{{ $task->category->icon }} {{ $task->category->name }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:.85rem;font-weight:500">{{ $task->user->name }}</div>
                            <div style="font-size:.72rem;color:var(--text3)">{{ $task->user->nim ?: $task->user->email }}</div>
                        </td>
                        <td style="font-size:.85rem;color:var(--text2)">{{ $task->mata_kuliah ?: '—' }}</td>
                        <td><span class="badge badge-{{ $task->priority }}">{{ $task->priority_label }}</span></td>
                        <td><span class="badge badge-{{ $task->status }}">{{ $task->status_label }}</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div class="progress-bar" style="width:60px">
                                    <div class="progress-fill" style="width:{{ $task->progress }}%"></div>
                                </div>
                                <span style="font-size:.75rem;color:var(--text3)">{{ $task->progress }}%</span>
                            </div>
                        </td>
                        <td style="font-size:.8rem;color:{{ $task->isOverdue() ? 'var(--red)' : 'var(--text3)' }}">
                            {{ $task->due_date ? $task->due_date->format('d M Y') : '—' }}
                            @if($task->isOverdue()) <span>⚠️</span> @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text3)">Tidak ada tugas ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tasks->hasPages())
        <div style="padding:16px 0 0;display:flex;justify-content:center">{{ $tasks->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
