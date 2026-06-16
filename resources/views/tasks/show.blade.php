@extends('layouts.app')
@section('title', $task->title)
@section('page-title', 'Detail Tugas')

@push('styles')
<style>
    .detail-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }
    .detail-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px; }
    .meta-item { background: var(--bg3); border-radius: 10px; padding: 12px 14px; }
    .meta-label { font-size: .7rem; color: var(--text3); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 4px; }
    .meta-value { font-size: .9rem; font-weight: 600; }
    .comment-item { display: flex; gap: 10px; margin-bottom: 14px; }
    .comment-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--purple)); display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 700; flex-shrink: 0; }
    .comment-body { background: var(--bg3); border-radius: 10px; padding: 10px 14px; flex: 1; }
    .comment-author { font-size: .75rem; font-weight: 600; margin-bottom: 3px; }
    .comment-text { font-size: .85rem; color: var(--text2); line-height: 1.5; }
    .comment-time { font-size: .7rem; color: var(--text3); margin-top: 4px; }
    .quick-status { display: flex; flex-wrap: wrap; gap: 8px; }
</style>
@endpush

@section('topbar-actions')
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost btn-sm">
        <i class="fas fa-pen"></i> Edit
    </a>
    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')" style="display:inline">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
    </form>
@endsection

@section('content')
<div style="margin-bottom:16px">
    <a href="{{ route('tasks.index') }}" style="color:var(--text3);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left"></i> Semua Tugas
    </a>
</div>

<div class="detail-grid">
    <!-- Left: Main Info -->
    <div>
        <div class="card" style="margin-bottom:16px">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:16px">
                <div>
                    @if($task->is_pinned)
                        <div style="font-size:.7rem;color:var(--yellow);margin-bottom:6px">📌 Disematkan</div>
                    @endif
                    <h1 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:700;line-height:1.3">
                        {{ $task->title }}
                    </h1>
                </div>
                <span class="badge badge-{{ $task->priority }}" style="flex-shrink:0">
                    {{ $task->priority_label }}
                </span>
            </div>

            @if($task->description)
                <p style="color:var(--text2);font-size:.9rem;line-height:1.7;margin-bottom:16px">{{ $task->description }}</p>
            @endif

            <div>
                <div style="display:flex;justify-content:space-between;font-size:.75rem;color:var(--text3);margin-bottom:6px">
                    <span>Progress</span><span style="font-weight:700;color:var(--accent)">{{ $task->progress }}%</span>
                </div>
                <div class="progress-bar" style="height:8px">
                    <div class="progress-fill" style="width:{{ $task->progress }}%"></div>
                </div>
            </div>

            <div class="detail-meta">
                <div class="meta-item">
                    <div class="meta-label">Status</div>
                    <div class="meta-value"><span class="badge badge-{{ $task->status }}">{{ $task->status_label }}</span></div>
                </div>
                @if($task->mata_kuliah)
                <div class="meta-item">
                    <div class="meta-label">Mata Kuliah</div>
                    <div class="meta-value">{{ $task->mata_kuliah }}</div>
                </div>
                @endif
                @if($task->dosen)
                <div class="meta-item">
                    <div class="meta-label">Dosen/Guru</div>
                    <div class="meta-value">{{ $task->dosen }}</div>
                </div>
                @endif
                @if($task->category)
                <div class="meta-item">
                    <div class="meta-label">Kategori</div>
                    <div class="meta-value">{{ $task->category->icon }} {{ $task->category->name }}</div>
                </div>
                @endif
                @if($task->due_date)
                <div class="meta-item {{ $task->isOverdue() ? 'style=border:1px solid rgba(255,94,110,.3)' : '' }}">
                    <div class="meta-label">Deadline</div>
                    <div class="meta-value {{ $task->isOverdue() ? 'style=color:var(--red)' : '' }}">
                        {{ $task->due_date->format('d M Y') }}
                        @if($task->due_time) {{ $task->due_time }} @endif
                        @if($task->isOverdue()) <span style="color:var(--red)">⚠️ Terlambat</span> @endif
                    </div>
                </div>
                @endif
                <div class="meta-item">
                    <div class="meta-label">Dibuat</div>
                    <div class="meta-value" style="font-size:.8rem">{{ $task->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="card">
            <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px">
                <i class="fas fa-comments" style="color:var(--accent)"></i> Catatan & Komentar
                <span style="color:var(--text3);font-weight:400;font-size:.85rem">({{ $task->comments->count() }})</span>
            </h3>

            @forelse($task->comments as $comment)
                <div class="comment-item">
                    <div class="comment-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                    <div class="comment-body">
                        <div class="comment-author">{{ $comment->user->name }}</div>
                        <div class="comment-text">{{ $comment->comment }}</div>
                        <div class="comment-time">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <p style="color:var(--text3);font-size:.85rem;margin-bottom:16px">Belum ada catatan.</p>
            @endforelse

            <div class="divider"></div>
            <form action="{{ route('tasks.addComment', $task) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="comment" class="form-control" rows="3"
                              placeholder="Tambah catatan atau komentar..." required>{{ old('comment') }}</textarea>
                    @error('comment')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-ghost btn-sm">
                    <i class="fas fa-paper-plane"></i> Kirim Catatan
                </button>
            </form>
        </div>
    </div>

    <!-- Right: Quick Actions -->
    <div>
        <div class="card" style="margin-bottom:16px">
            <h3 style="font-size:.9rem;font-weight:700;margin-bottom:14px;color:var(--text2)">
                <i class="fas fa-bolt" style="color:var(--yellow)"></i> Ubah Status Cepat
            </h3>
            <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                @csrf @method('PATCH')
                <div class="quick-status">
                    @foreach(['todo'=>['⏳','Belum Mulai'],'in_progress'=>['⚡','Dikerjakan'],'done'=>['✅','Selesai'],'cancelled'=>['❌','Dibatalkan']] as $s=>$info)
                        <button type="submit" name="status" value="{{ $s }}"
                                class="btn btn-sm {{ $task->status === $s ? 'btn-primary' : 'btn-ghost' }}"
                                style="flex:1">
                            {{ $info[0] }} {{ $info[1] }}
                        </button>
                    @endforeach
                </div>
            </form>
        </div>

        <div class="card" style="margin-bottom:16px">
            <h3 style="font-size:.9rem;font-weight:700;margin-bottom:14px;color:var(--text2)">
                <i class="fas fa-info-circle" style="color:var(--accent)"></i> Ringkasan
            </h3>
            <div style="display:flex;flex-direction:column;gap:10px;font-size:.85rem">
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Prioritas</span>
                    <span class="badge badge-{{ $task->priority }}">{{ $task->priority_label }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Status</span>
                    <span class="badge badge-{{ $task->status }}">{{ $task->status_label }}</span>
                </div>
                @if($task->due_date)
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Sisa waktu</span>
                    <span style="color:{{ $task->isOverdue() ? 'var(--red)' : 'var(--green)' }};font-weight:600">
                        {{ $task->isOverdue() ? 'Terlambat ' . $task->due_date->diffForHumans() : $task->due_date->diffForHumans() }}
                    </span>
                </div>
                @endif
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--text3)">Komentar</span>
                    <span style="font-weight:600">{{ $task->comments->count() }}</span>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px">
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary" style="flex:1;justify-content:center">
                <i class="fas fa-pen"></i> Edit Tugas
            </a>
        </div>
    </div>
</div>
@endsection
