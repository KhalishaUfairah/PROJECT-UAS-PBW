@extends('layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('topbar-actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
@endsection

@section('content')
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Warna</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <span style="font-size:1.3rem">{{ $cat->icon }}</span>
                                <span style="font-weight:600">{{ $cat->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:18px;height:18px;border-radius:50%;background:{{ $cat->color }}"></div>
                                <code style="font-size:.75rem;color:var(--text3)">{{ $cat->color }}</code>
                            </div>
                        </td>
                        <td style="font-size:.85rem;color:var(--text2)">{{ Str::limit($cat->description, 50) ?: '—' }}</td>
                        <td><span style="font-weight:700;color:var(--accent)">{{ $cat->tasks_count }}</span></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-ghost btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text3)">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
