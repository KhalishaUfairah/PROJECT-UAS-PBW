@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div style="margin-bottom:16px">
    <a href="{{ route('admin.users.show', $user) }}" style="color:var(--text3);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left"></i> Kembali ke Detail
    </a>
</div>

<div class="card" style="max-width:600px">
    <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:22px">Edit: {{ $user->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">NIM / NIS</label>
                <input type="text" name="nim" class="form-control" value="{{ old('nim', $user->nim) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-control">
                    <option value="">Pilih semester</option>
                    @for($i=1;$i<=8;$i++)
                        <option value="{{ $i }}" {{ old('semester',$user->semester)==$i?'selected':'' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group" style="grid-column:1/-1">
                <label class="form-label">Jurusan / Program Studi</label>
                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $user->jurusan) }}">
            </div>
        </div>

        <div class="divider"></div>
        <p style="font-size:.8rem;color:var(--text3);margin-bottom:16px">Kosongkan password jika tidak ingin mengubah.</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter">
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
            </div>
        </div>

        <div class="divider"></div>
        <div style="display:flex;gap:10px;justify-content:flex-end">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
