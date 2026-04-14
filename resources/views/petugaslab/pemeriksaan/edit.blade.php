@extends('layouts.app')

@section('title', 'Edit Pemeriksaan')
@section('header', 'Edit Data Pemeriksaan')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('petugas_lab.pemeriksaan.update', $pemeriksaan->id) }}">
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
                    <p style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksanaan)->format('d/m/Y H:i') }}</p>
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
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-flask" style="color: #004b23; margin-right: 0.5rem;"></i>
                Hasil Laboratorium
            </h3>

            @php
                $groupedParams = $parameters->groupBy('kategori');
                $existingHasil = $pemeriksaan->hasilPemeriksaan->keyBy('parameter_id');
            @endphp

            @foreach($groupedParams as $kategori => $params)
            <div style="margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.75rem; color: #004b23;">
                    @if($kategori == 'kimia_darah')
                        <i class="fas fa-tint"></i> Kimia Darah
                    @elseif($kategori == 'urin')
                        <i class="fas fa-fill-drip"></i> Urinalisis
                    @elseif($kategori == 'serologi')
                        <i class="fas fa-syringe"></i> Serologi
                    @elseif($kategori == 'narkoba')
                        <i class="fas fa-capsules"></i> Narkoba
                    @else
                        <i class="fas fa-ellipsis-h"></i> Lainnya
                    @endif
                </h4>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 0.75rem;">
                    @foreach($params as $param)
                    @php
                        $existing = $existingHasil->get($param->id);
                        $nilai = $existing ? $existing->nilai : '';
                    @endphp
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">
                            {{ $param->nama_param }}
                            @if($param->satuan)
                                <span style="font-size: 0.65rem; color: #6b7280;">({{ $param->satuan }})</span>
                            @endif
                        </label>
                        <input type="text" name="hasil[{{ $param->id }}]" value="{{ old('hasil.' . $param->id, $nilai) }}"
                               style="width: 100%; padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem; outline: none;">
                        @if($param->nilai_normal_min && $param->nilai_normal_max)
                        <p style="font-size: 0.6rem; color: #6b7280; margin-top: 0.2rem;">
                            Normal: {{ $param->nilai_normal_min }} - {{ $param->nilai_normal_max }}
                        </p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tombol Aksi -->
        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('petugas_lab.pemeriksaan.index') }}"
               style="padding: 0.7rem 1.5rem; border: 1.5px solid #e5e7eb; border-radius: 10px; color: #374151; text-decoration: none; font-size: 0.85rem;">
                Batal
            </a>
            <button type="submit"
                    style="background: #004b23; color: white; padding: 0.7rem 2rem; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 500; cursor: pointer;">
                <i class="fas fa-save"></i> Update Pemeriksaan
            </button>
        </div>
    </form>
</div>

<script>
    // Hitung IMT otomatis jika diperlukan
    const tinggiInput = document.querySelector('input[name="tinggi_cm"]');
    const beratInput = document.querySelector('input[name="berat_kg"]');

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
