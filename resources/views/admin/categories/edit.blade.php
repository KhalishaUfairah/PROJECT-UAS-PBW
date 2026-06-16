@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div style="margin-bottom:16px">
    <a href="{{ route('admin.categories') }}" style="color:var(--text3);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
<div class="card" style="max-width:500px">
    <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:22px">Edit: {{ $category->icon }} {{ $category->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Nama Kategori *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
                <label class="form-label">Ikon (Emoji) *</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Warna *</label>
                <input type="color" name="color" class="form-control" value="{{ old('color', $category->color) }}" style="height:42px;padding:4px" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="divider"></div>
        <div style="display:flex;gap:10px;justify-content:flex-end">
            <a href="{{ route('admin.categories') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
