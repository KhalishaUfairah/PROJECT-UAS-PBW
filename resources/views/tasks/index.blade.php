@extends('layouts.app')
@section('title', 'Tugas Saya')
@section('page-title', 'Dashboard Tugas')

@section('topbar-actions')
    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Tugas
    </a>
@endsection

@push('styles')
<style>
    .filter-bar {
        display: flex; align-items: center; gap: 10px;
        flex-wrap: wrap; margin-bottom: 24px;
    }
    .filter-bar .form-control { width: auto; min-width: 120px; padding: 8px 12px; font-size: .8rem; }
    .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #5a6278; font-size: .8rem; }
    .search-wrap input { padding-left: 34px; width: 100%; }
    .task-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
    .task-card {
        background: var(--bg2); border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 20px;
        transition: all .2s; text-decoration: none; color: var(--text);
        display: flex; flex-direction: column; gap: 12px;
        cursor: pointer;
    }
    .task-card:hover { border-color: var(--accent); transform: translateY(-2px); box-shadow: 0 8px 32px rgba(0,0,0,.3); }
    .task-card.pinned { border-color: rgba(245,197,66,.3); }
    .task-card-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; }
    .task-title { font-weight: 700; font-size: .95rem; line-height: 1.3; flex: 1; }
    .task-meta { display: flex; flex-wrap: wrap; gap: 6px; font-size: .75rem; color: var(--text3); }
    .task-meta-item { display: flex; align-items: center; gap: 4px; }
    .task-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 4px; }
    .task-due { font-size: .75rem; color: var(--text3); }
    .task-due.overdue { color: var(--red); }
    .progress-label { font-size: .7rem; color: var(--text3); margin-bottom: 4px; display: flex; justify-content: space-between; }
    .pagination-wrap { margin-top: 28px; display: flex; justify-content: center; gap: 6px; }
    .pagination-wrap a, .pagination-wrap span {
        padding: 7px 13px; border-radius: 8px; font-size: .8rem;
        background: var(--bg2); border: 1px solid var(--border); color: var(--text2);
        text-decoration: none; transition: all .2s;
    }
    .pagination-wrap a:hover { border-color: var(--accent); color: var(--accent); }
    .pagination-wrap .active { background: var(--accent); border-color: var(--accent); color: #fff; }
</style>
@endpush

@section('content')
<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-label">Total Tugas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-value" style="color:var(--text2)">{{ $stats['todo'] }}</div>
        <div class="stat-label">Belum Mulai</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⚡</div>
        <div class="stat-value" style="color:var(--accent2)">{{ $stats['in_progress'] }}</div>
        <div class="stat-label">Dikerjakan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value" style="color:var(--green)">{{ $stats['done'] }}</div>
        <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🔥</div>
        <div class="stat-value" style="color:var(--red)">{{ $stats['overdue'] }}</div>
        <div class="stat-label">Terlambat</div>
    </div>
</div>

<!-- Filters -->
<form method="GET" class="filter-bar">
    <div class="search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" name="search" class="form-control" placeholder="Cari tugas…" value="{{ request('search') }}">
    </div>
    <select name="status" class="form-control">
        <option value="">Semua Status</option>
        <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>Belum Mulai</option>
        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Dikerjakan</option>
        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
    </select>
    <select name="priority" class="form-control">
        <option value="">Semua Prioritas</option>
        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>🟠 Tinggi</option>
        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>🟢 Rendah</option>
    </select>
    <select name="category" class="form-control">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->icon }} {{ $cat->name }}
            </option>
        @endforeach
    </select>
    <select name="sort" class="form-control">
        <option value="due_date" {{ request('sort','due_date') == 'due_date' ? 'selected' : '' }}>Deadline</option>
        <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Prioritas</option>
        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
    </select>
    <button type="submit" class="btn btn-ghost btn-sm"><i class="fas fa-filter"></i> Filter</button>
    @if(request()->hasAny(['search','status','priority','category','sort']))
        <a href="{{ route('tasks.index') }}" class="btn btn-ghost btn-sm"><i class="fas fa-xmark"></i></a>
    @endif
</form>

<!-- Task Cards -->
@if($tasks->count())
    <div class="task-grid">
        @foreach($tasks as $task)
            <a href="{{ route('tasks.show', $task) }}" class="task-card {{ $task->is_pinned ? 'pinned' : '' }}">
                <div class="task-card-header">
                    <div>
                        @if($task->is_pinned)
                            <span style="font-size:.65rem;color:var(--yellow)">📌 Dipinned</span><br>
                        @endif
                        <div class="task-title">{{ $task->title }}</div>
                    </div>
                    <div>
                        <span class="badge badge-{{ $task->priority }}">{{ $task->priority_label }}</span>
                    </div>
                </div>

                <div class="task-meta">
                    @if($task->mata_kuliah)
                        <span class="task-meta-item"><i class="fas fa-book-open"></i> {{ $task->mata_kuliah }}</span>
                    @endif
                    @if($task->category)
                        <span class="task-meta-item">{{ $task->category->icon }} {{ $task->category->name }}</span>
                    @endif
                </div>

                @if($task->description)
                    <p style="font-size:.8rem;color:var(--text2);line-height:1.5">{{ Str::limit($task->description, 80) }}</p>
                @endif

                <div>
                    <div class="progress-label">
                        <span>Progress</span><span>{{ $task->progress }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:{{ $task->progress }}%"></div>
                    </div>
                </div>

                <div class="task-footer">
                    <span class="badge badge-{{ $task->status }}">{{ $task->status_label }}</span>
                    @if($task->due_date)
                        <span class="task-due {{ $task->isOverdue() ? 'overdue' : '' }}">
                            <i class="fas fa-calendar"></i>
                            {{ $task->isOverdue() ? '⚠️ ' : '' }}{{ $task->due_date->format('d M Y') }}
                        </span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    <div class="pagination-wrap">
        @foreach($tasks->links()->elements[0] ?? [] as $page => $url)
        @endforeach
        {!! $tasks->links() !!}
    </div>
    <p style="text-align:center;font-size:.78rem;color:var(--text3);margin-top:12px">
        Menampilkan {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} dari {{ $tasks->total() }} tugas
    </p>
@else
    <div class="empty-state">
        <div class="icon">📭</div>
        <p style="font-size:1.1rem;font-weight:600;color:var(--text2)">Tidak ada tugas ditemukan</p>
        <p style="margin:8px 0 20px;font-size:.875rem">Mulai dengan menambahkan tugas pertamamu!</p>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Tugas
        </a>
    </div>
@endif
@endsection
