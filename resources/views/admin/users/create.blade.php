@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('header', 'Tambah Pengguna Baru')

@section('content')
<div class="stat-card" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                NIP <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" name="nip" value="{{ old('nip') }}" required
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none; transition: all 0.2s;">
            @error('nip')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Nama Lengkap <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
            @error('nama_lengkap')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Email
            </label>
            <input type="email" name="email" value="{{ old('email') }}"
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
            @error('email')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Password <span style="color: #ef4444;">*</span>
            </label>
            <input type="password" name="password" required
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
            @error('password')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Role <span style="color: #ef4444;">*</span>
            </label>
            <select name="role" required
                    style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none; background: white;">
                <option value="">Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                <option value="petugas_lab" {{ old('role') == 'petugas_lab' ? 'selected' : '' }}>Petugas Laboratorium</option>
                <option value="pasien" {{ old('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
            </select>
            @error('role')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Nomor Telepon
            </label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Alamat
            </label>
            <textarea name="alamat" rows="3"
                      style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">{{ old('alamat') }}</textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Tanggal Lahir
            </label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Jenis Kelamin
            </label>
            <select name="jenis_kelamin"
                    style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none; background: white;">
                <option value="">Pilih</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       style="width: 16px; height: 16px; accent-color: #004b23;">
                <span style="font-size: 0.85rem;">Aktifkan akun ini</span>
            </label>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid #f0f0f0; padding-top: 1.5rem;">
            <a href="{{ route('admin.users.index') }}"
               style="padding: 0.6rem 1.25rem; border: 1.5px solid #e5e7eb; border-radius: 10px; color: #374151; text-decoration: none; font-size: 0.85rem;">
                Batal
            </a>
            <button type="submit"
                    style="background: #004b23; color: white; padding: 0.6rem 1.5rem; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 500; cursor: pointer;">
                Simpan Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
