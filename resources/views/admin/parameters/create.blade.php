@extends('layouts.app')

@section('title', 'Tambah Parameter')
@section('header', 'Tambah Parameter Baru')

@section('content')
<div class="stat-card" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.parameters.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Kode Parameter <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" name="kode_param" value="{{ old('kode_param') }}" required
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;"
                   placeholder="Contoh: GLU_PUASA, LDL, HBSAG">
            <p style="font-size: 0.7rem; color: #6b7280; margin-top: 0.25rem;">Gunakan huruf besar dan underscore (contoh: GLU_PUASA)</p>
            @error('kode_param')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Nama Parameter <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" name="nama_param" value="{{ old('nama_param') }}" required
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;"
                   placeholder="Contoh: Gula Darah Puasa, LDL, HBsAg">
            @error('nama_param')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Kategori <span style="color: #ef4444;">*</span>
            </label>
            <select name="kategori" required
                    style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none; background: white;">
                <option value="">Pilih Kategori</option>
                <option value="kimia_darah" {{ old('kategori') == 'kimia_darah' ? 'selected' : '' }}>Kimia Darah</option>
                <option value="urin" {{ old('kategori') == 'urin' ? 'selected' : '' }}>Urinalisis</option>
                <option value="serologi" {{ old('kategori') == 'serologi' ? 'selected' : '' }}>Serologi</option>
                <option value="narkoba" {{ old('kategori') == 'narkoba' ? 'selected' : '' }}>Narkoba</option>
                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('kategori')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                Satuan
            </label>
            <input type="text" name="satuan" value="{{ old('satuan') }}"
                   style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;"
                   placeholder="Contoh: mg/dL, U/L, mL">
            @error('satuan')
                <p style="color: #ef4444; font-size: 0.7rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                    Nilai Normal Minimum
                </label>
                <input type="number" step="any" name="nilai_normal_min" value="{{ old('nilai_normal_min') }}"
                       style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                    Nilai Normal Maksimum
                </label>
                <input type="number" step="any" name="nilai_normal_max" value="{{ old('nilai_normal_max') }}"
                       style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       style="width: 16px; height: 16px; accent-color: #004b23;">
                <span style="font-size: 0.85rem;">Aktifkan parameter ini</span>
            </label>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid #f0f0f0; padding-top: 1.5rem;">
            <a href="{{ route('admin.parameters.index') }}"
               style="padding: 0.6rem 1.25rem; border: 1.5px solid #e5e7eb; border-radius: 10px; color: #374151; text-decoration: none; font-size: 0.85rem;">
                Batal
            </a>
            <button type="submit"
                    style="background: #004b23; color: white; padding: 0.6rem 1.5rem; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 500; cursor: pointer;">
                Simpan Parameter
            </button>
        </div>
    </form>
</div>
@endsection
