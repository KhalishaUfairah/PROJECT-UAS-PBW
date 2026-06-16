@extends('layouts.app')
@section('title', 'Tambah Tugas')
@section('page-title', 'Tambah Tugas Baru')

@push('styles')
<style>
    .form-card { max-width: 720px; }
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
    .range-wrap { display: flex; align-items: center; gap: 12px; }
    .range-wrap input[type=range] { flex: 1; accent-color: var(--accent); }
    .range-val { min-width: 40px; text-align: center; font-weight: 700; color: var(--accent); font-size: .9rem; }
    .toggle-wrap { display: flex; align-items: center; gap: 10px; }
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
        <div class="page-title">Tambah Tugas Baru</div>
        <p style="color:var(--text3);font-size:.85rem;margin-top:4px">Isi detail tugas kuliah/sekolah kamu</p>
    </div>
    <a href="{{ route('tasks.index') }}" class="btn btn-ghost">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card form-card">
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Judul Tugas *</label>
            <input type="text" name="title" class="form-control"
                   placeholder="Contoh: Laporan Praktikum Jaringan Komputer"
                   value="{{ old('title') }}" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4"
                      placeholder="Jelaskan detail tugas, apa yang perlu dikerjakan, referensi, dll.">{{ old('description') }}</textarea>
            @error('description')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Mata Kuliah / Pelajaran</label>
                <input type="text" name="mata_kuliah" class="form-control"
                       placeholder="Contoh: Basis Data" value="{{ old('mata_kuliah') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Dosen / Guru</label>
                <input type="text" name="dosen" class="form-control"
                       placeholder="Contoh: Dr. Budi Santoso" value="{{ old('dosen') }}">
            </div>
        </div>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Prioritas *</label>
                <select name="priority" class="form-control" required>
                    <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>🟢 Rendah</option>
                    <option value="medium" {{ old('priority','medium') == 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                    <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>🟠 Tinggi</option>
                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                </select>
                @error('priority')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="status" class="form-control" required>
                    <option value="todo"        {{ old('status','todo') == 'todo'        ? 'selected' : '' }}>⏳ Belum Mulai</option>
                    <option value="in_progress" {{ old('status') == 'in_progress'         ? 'selected' : '' }}>⚡ Dikerjakan</option>
                    <option value="done"        {{ old('status') == 'done'               ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="cancelled"   {{ old('status') == 'cancelled'          ? 'selected' : '' }}>❌ Dibatalkan</option>
                </select>
                @error('status')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="">— Pilih kategori —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Tanggal Deadline</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                @error('due_date')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Jam Deadline</label>
                <input type="time" name="due_time" class="form-control" value="{{ old('due_time') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Progress: <span id="progress-val">{{ old('progress', 0) }}%</span></label>
            <div class="range-wrap">
                <input type="range" name="progress" id="progress" min="0" max="100"
                       value="{{ old('progress', 0) }}" step="5">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" style="display:flex;align-items:center;gap:10px">
                <label class="toggle">
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
                📌 Sematkan tugas ini (tampil di atas)
            </label>
        </div>

        <div class="divider"></div>

        <div style="display:flex;gap:12px;justify-content:flex-end">
            <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Simpan Tugas
            </button>
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
