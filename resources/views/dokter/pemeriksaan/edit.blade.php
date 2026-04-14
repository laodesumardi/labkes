@extends('layouts.app')

@section('title', 'Edit Pemeriksaan')
@section('header', 'Edit Data Pemeriksaan')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('dokter.pemeriksaan.update', $pemeriksaan->id) }}">
        @csrf
        @method('PUT')

        <!-- Informasi Pasien -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-user" style="color: #004b23; margin-right: 0.5rem;"></i>
                Informasi Pasien
            </h3>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                    <p style="font-size: 0.7rem; color: #6b7280;">Nama Pasien</p>
                    <p style="font-size: 0.9rem; font-weight: 500;">{{ $pemeriksaan->user->nama_lengkap ?? '-' }}</p>
                </div>
                <div>
                    <p style="font-size: 0.7rem; color: #6b7280;">NIP</p>
                    <p style="font-size: 0.9rem; font-family: monospace;">{{ $pemeriksaan->user->nip ?? '-' }}</p>
                </div>
                <div>
                    <p style="font-size: 0.7rem; color: #6b7280;">Tanggal Pemeriksaan</p>
                    <p style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p style="font-size: 0.7rem; color: #6b7280;">Petugas Lab</p>
                    <p style="font-size: 0.9rem;">{{ $pemeriksaan->petugas->nama_lengkap ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Data Antropometri -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-ruler" style="color: #004b23; margin-right: 0.5rem;"></i>
                Data Antropometri
            </h3>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Tinggi Badan (cm)
                    </label>
                    <input type="number" step="0.1" name="tinggi_cm" value="{{ old('tinggi_cm', $pemeriksaan->tinggi_cm) }}"
                           style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Berat Badan (kg)
                    </label>
                    <input type="number" step="0.1" name="berat_kg" value="{{ old('berat_kg', $pemeriksaan->berat_kg) }}"
                           style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Lingkar Perut (cm)
                    </label>
                    <input type="number" step="0.1" name="lingkar_perut_cm" value="{{ old('lingkar_perut_cm', $pemeriksaan->lingkar_perut_cm) }}"
                           style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
                </div>
            </div>
        </div>

        <!-- Tekanan Darah -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-heartbeat" style="color: #004b23; margin-right: 0.5rem;"></i>
                Tekanan Darah
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Sistolik (mmHg)
                    </label>
                    <input type="number" name="sistolik" value="{{ old('sistolik', $pemeriksaan->sistolik) }}"
                           style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Diastolik (mmHg)
                    </label>
                    <input type="number" name="diastolik" value="{{ old('diastolik', $pemeriksaan->diastolik) }}"
                           style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">
                </div>
            </div>
        </div>

        <!-- Hasil Laboratorium -->
        @if($pemeriksaan->hasilPemeriksaan && $pemeriksaan->hasilPemeriksaan->count() > 0)
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-flask" style="color: #004b23; margin-right: 0.5rem;"></i>
                Hasil Laboratorium
            </h3>

            <div style="overflow-x: auto;">
                <table class="data-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding: 0.75rem;">Parameter</th>
                            <th style="padding: 0.75rem;">Hasil</th>
                            <th style="padding: 0.75rem;">Satuan</th>
                            <th style="padding: 0.75rem;">Nilai Normal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemeriksaan->hasilPemeriksaan as $hasil)
                        <tr>
                            <td style="padding: 0.75rem; font-weight: 500;">{{ $hasil->parameter->nama_param ?? '-' }}</td>
                            <td style="padding: 0.75rem;">
                                <input type="text" name="hasil[{{ $hasil->parameter_id }}]" value="{{ $hasil->nilai }}"
                                       style="width: 100%; padding: 0.4rem; border: 1.5px solid #e5e7eb; border-radius: 6px; font-size: 0.8rem;">
                            </td>
                            <td style="padding: 0.75rem;">{{ $hasil->parameter->satuan ?? '-' }}</td>
                            <td style="padding: 0.75rem;">
                                @if($hasil->parameter->nilai_normal_min && $hasil->parameter->nilai_normal_max)
                                    {{ $hasil->parameter->nilai_normal_min }} - {{ $hasil->parameter->nilai_normal_max }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Catatan Medis -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-notes-medical" style="color: #004b23; margin-right: 0.5rem;"></i>
                Catatan Medis
            </h3>

            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                    Catatan (Opsional)
                </label>
                <textarea name="catatan" rows="4" style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none;">{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
            </div>
        </div>

        <!-- Status Validasi -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-check-circle" style="color: #004b23; margin-right: 0.5rem;"></i>
                Status Validasi
            </h3>

            <div>
                <select name="status_validasi" style="width: 100%; padding: 0.75rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem;">
                    <option value="draft" {{ $pemeriksaan->status_validasi == 'draft' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="divalidasi" {{ $pemeriksaan->status_validasi == 'divalidasi' ? 'selected' : '' }}>Divalidasi</option>
                    <option value="dibatalkan" {{ $pemeriksaan->status_validasi == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('dokter.pemeriksaan.index') }}"
               style="padding: 0.7rem 1.5rem; border: 1.5px solid #e5e7eb; border-radius: 10px; color: #374151; text-decoration: none; font-size: 0.85rem;">
                Batal
            </a>
            <button type="submit"
                    style="background: #004b23; color: white; padding: 0.7rem 2rem; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 500; cursor: pointer;">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    // Hitung IMT otomatis
    const tinggiInput = document.querySelector('input[name="tinggi_cm"]');
    const beratInput = document.querySelector('input[name="berat_kg"]');
    const imtDisplay = document.getElementById('imtDisplay');

    function hitungIMT() {
        const tinggi = parseFloat(tinggiInput?.value);
        const berat = parseFloat(beratInput?.value);

        if (tinggi && berat && tinggi > 0) {
            const imt = berat / ((tinggi / 100) * (tinggi / 100));
            console.log('IMT:', imt.toFixed(2));
        }
    }

    if (tinggiInput && beratInput) {
        tinggiInput.addEventListener('input', hitungIMT);
        beratInput.addEventListener('input', hitungIMT);
    }
</script>
@endsection
