@extends('layouts.app')
@section('title', 'Edit Tugas')
@section('page-title', 'Edit Tugas')

@push('styles')
<style>
    .form-card { max-width: 720px; }
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
    .toggle { position: relative; width: 44px; height: 24px; }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0; background: var(--bg3);
        border-radius: 99px; cursor: pointer; transition: .2s;
        border: 1px solid var(--border);
    }
    .toggle-slider::before {
        content: ''; position: absolute; width: 18px; height: 18px;
        border-radius: 50%; background: var(--text3);
        top: 2px; left: 2px; transition: .2s;
    }
    .toggle input:checked + .toggle-slider { background: rgba(91,115,255,.3); border-color: var(--accent); }
    .toggle input:checked + .toggle-slider::before { transform: translateX(20px); background: var(--accent); }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Edit Tugas</div>
        <p style="color:var(--text3);font-size:.85rem;margin-top:4px">{{ $task->title }}</p>
    </div>
    <a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card form-card">
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Judul Tugas *</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $task->title) }}" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Mata Kuliah / Pelajaran</label>
                <input type="text" name="mata_kuliah" class="form-control"
                       value="{{ old('mata_kuliah', $task->mata_kuliah) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Dosen / Guru</label>
                <input type="text" name="dosen" class="form-control"
                       value="{{ old('dosen', $task->dosen) }}">
            </div>
        </div>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Prioritas *</label>
                <select name="priority" class="form-control" required>
                    @foreach(['low'=>'🟢 Rendah','medium'=>'🟡 Sedang','high'=>'🟠 Tinggi','urgent'=>'🔴 Urgent'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('priority', $task->priority) == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="status" class="form-control" required>
                    @foreach(['todo'=>'⏳ Belum Mulai','in_progress'=>'⚡ Dikerjakan','done'=>'✅ Selesai','cancelled'=>'❌ Dibatalkan'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('status', $task->status) == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="">— Pilih —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $task->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Tanggal Deadline</label>
                <input type="date" name="due_date" class="form-control"
                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Jam Deadline</label>
                <input type="time" name="due_time" class="form-control"
                       value="{{ old('due_time', $task->due_time) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Progress: <span id="progress-val">{{ old('progress', $task->progress) }}%</span></label>
            <input type="range" name="progress" id="progress" min="0" max="100"
                   value="{{ old('progress', $task->progress) }}" step="5"
                   style="width:100%;accent-color:var(--accent)">
        </div>

        <div class="form-group">
            <label style="display:flex;align-items:center;gap:10px;font-size:.85rem;color:var(--text2);cursor:pointer">
                <label class="toggle">
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $task->is_pinned) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
                📌 Sematkan tugas ini
            </label>
        </div>

        <div class="divider"></div>

        <div style="display:flex;justify-content:space-between;align-items:center">
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin hapus tugas ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
            <div style="display:flex;gap:10px">
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const slider = document.getElementById('progress');
    const val = document.getElementById('progress-val');
    slider.addEventListener('input', () => val.textContent = slider.value + '%');
</script>
@endpush
