@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Pengguna</div>
        <p style="color:var(--text3);font-size:.85rem">Total {{ $users->total() }} mahasiswa terdaftar</p>
    </div>
</div>

<!-- Search -->
<form method="GET" style="margin-bottom:20px;display:flex;gap:10px">
    <div style="position:relative;flex:1;max-width:360px">
        <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:.8rem"></i>
        <input type="text" name="search" class="form-control" style="padding-left:34px"
               placeholder="Cari nama, email, NIM…" value="{{ request('search') }}">
    </div>
    <button type="submit" class="btn btn-ghost btn-sm"><i class="fas fa-search"></i> Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.users') }}" class="btn btn-ghost btn-sm"><i class="fas fa-xmark"></i></a>
    @endif
</form>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIM/NIS</th>
                    <th>Jurusan</th>
                    <th>Semester</th>
                    <th>Tugas</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--purple));display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;flex-shrink:0">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:.875rem">{{ $user->name }}</div>
                                    <div style="font-size:.73rem;color:var(--text3)">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:.85rem">{{ $user->nim ?: '—' }}</td>
                        <td style="font-size:.85rem">{{ $user->jurusan ?: '—' }}</td>
                        <td style="font-size:.85rem">{{ $user->semester ? 'Sem. '.$user->semester : '—' }}</td>
                        <td>
                            <span style="font-weight:700;color:var(--accent)">{{ $user->tasks_count }}</span>
                        </td>
                        <td style="font-size:.78rem;color:var(--text3)">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-ghost btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ghost btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px;color:var(--text3)">
                            Tidak ada pengguna ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="padding:16px 0 0;display:flex;justify-content:center">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
