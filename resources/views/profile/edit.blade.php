@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header', 'Informasi Profil')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Informasi Profil -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-user-circle" style="color: #004b23; margin-right: 0.5rem;"></i>
            Informasi Dasar
        </h3>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}" required
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
                @error('nama_lengkap')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">NIP</label>
                <input type="text" value="{{ Auth::user()->nip }}" disabled
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem; background: #f9fafb;">
                <p style="font-size: 0.65rem; color: #6b7280; margin-top: 0.25rem;">NIP tidak dapat diubah</p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">No. Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', Auth::user()->no_telepon) }}"
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Alamat</label>
                <textarea name="alamat" rows="3" style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">{{ old('alamat', Auth::user()->alamat) }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                <button type="submit" style="background: #004b23; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Ubah Password -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-key" style="color: #004b23; margin-right: 0.5rem;"></i>
            Ubah Password
        </h3>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Password Saat Ini</label>
                <input type="password" name="current_password" required
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Password Baru</label>
                <input type="password" name="password" required
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                <button type="submit" style="background: #004b23; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

    @if(session('status') === 'password-updated')
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            Password berhasil diubah!
        </div>
    @endif
</div>
@endsection
