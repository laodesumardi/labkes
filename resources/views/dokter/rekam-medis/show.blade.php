@extends('layouts.app')

@section('title', 'Detail Rekam Medis')
@section('header', 'Detail Rekam Medis Pasien')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Informasi Pasien -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-user-circle" style="color: #004b23; margin-right: 0.5rem;"></i>
            Informasi Pasien
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Nama Lengkap</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ $rekamMedis->user->nama_lengkap ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">NIP</p>
                <p style="font-size: 0.9rem; font-family: monospace;">{{ $rekamMedis->user->nip ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Jenis Kelamin</p>
                <p style="font-size: 0.9rem;">{{ $rekamMedis->user->jenis_kelamin ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tanggal Lahir</p>
                <p style="font-size: 0.9rem;">
                    @if($rekamMedis->user->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($rekamMedis->user->tanggal_lahir)->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($rekamMedis->user->tanggal_lahir)->age }} tahun)
                    @else
                        -
                    @endif
                </p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">No. Telepon</p>
                <p style="font-size: 0.9rem;">{{ $rekamMedis->user->no_telepon ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Alamat</p>
                <p style="font-size: 0.9rem;">{{ $rekamMedis->user->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Data Pemeriksaan -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-stethoscope" style="color: #004b23; margin-right: 0.5rem;"></i>
            Data Pemeriksaan Fisik
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tanggal Pemeriksaan</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ \Carbon\Carbon::parse($rekamMedis->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tinggi Badan</p>
                <p style="font-size: 0.9rem;">{{ $rekamMedis->tinggi_cm ?? '-' }} cm</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Berat Badan</p>
                <p style="font-size: 0.9rem;">{{ $rekamMedis->berat_kg ?? '-' }} kg</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">IMT (Indeks Massa Tubuh)</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ $rekamMedis->imt ?? '-' }} ({{ $rekamMedis->kategori_imt ?? '-' }})</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Lingkar Perut</p>
                <p style="font-size: 0.9rem;">{{ $rekamMedis->lingkar_perut_cm ?? '-' }} cm</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tekanan Darah</p>
                <p style="font-size: 0.9rem;">{{ $rekamMedis->sistolik }}/{{ $rekamMedis->diastolik }} mmHg</p>
                <p style="font-size: 0.7rem; color: #6b7280;">{{ $rekamMedis->kategori_tekanan ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Hasil Laboratorium -->
    @if($rekamMedis->hasilPemeriksaan && $rekamMedis->hasilPemeriksaan->count() > 0)
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-flask" style="color: #004b23; margin-right: 0.5rem;"></i>
            Hasil Pemeriksaan Laboratorium
        </h3>

        <div style="overflow-x: auto;">
            <table class="data-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding: 0.75rem;">Parameter</th>
                        <th style="padding: 0.75rem;">Hasil</th>
                        <th style="padding: 0.75rem;">Satuan</th>
                        <th style="padding: 0.75rem;">Nilai Normal</th>
                        <th style="padding: 0.75rem;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis->hasilPemeriksaan as $hasil)
                    <tr>
                        <td style="padding: 0.75rem; font-weight: 500;">{{ $hasil->parameter->nama_param ?? '-' }}</td>
                        <td style="padding: 0.75rem;">{{ $hasil->nilai }}</td>
                        <td style="padding: 0.75rem;">{{ $hasil->parameter->satuan ?? '-' }}</td>
                        <td style="padding: 0.75rem;">
                            @if($hasil->parameter->nilai_normal_min && $hasil->parameter->nilai_normal_max)
                                {{ $hasil->parameter->nilai_normal_min }} - {{ $hasil->parameter->nilai_normal_max }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="padding: 0.75rem;">
                            @php
                                $status = $hasil->status;
                                $statusColor = $status == 'Normal' ? '#10b981' : ($status == 'Tinggi' ? '#ef4444' : '#f59e0b');
                                $statusBg = $status == 'Normal' ? '#dcfce7' : ($status == 'Tinggi' ? '#fee2e2' : '#fef3c7');
                            @endphp
                            <span style="padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.7rem; background: {{ $statusBg }}; color: {{ $statusColor }};">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Catatan dan Validasi -->
    <div class="stat-card">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-notes-medical" style="color: #004b23; margin-right: 0.5rem;"></i>
            Catatan Medis
        </h3>

        <div style="margin-bottom: 1rem;">
            <p style="font-size: 0.7rem; color: #6b7280; margin-bottom: 0.25rem;">Catatan Dokter</p>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 12px;">
                <p style="font-size: 0.85rem;">{{ $rekamMedis->catatan ?? 'Tidak ada catatan' }}</p>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Status Validasi</p>
                @if($rekamMedis->status_validasi == 'divalidasi')
                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                        <i class="fas fa-check-circle"></i>
                        Telah Divalidasi oleh Dr. {{ $rekamMedis->dokter->nama_lengkap ?? 'Dokter' }}
                    </span>
                @elseif($rekamMedis->status_validasi == 'dibatalkan')
                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                        <i class="fas fa-times-circle"></i>
                        Dibatalkan
                    </span>
                @else
                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fef3c7; color: #92400e; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                        <i class="fas fa-clock"></i>
                        Menunggu Validasi
                    </span>
                @endif
            </div>

            <div>
                <a href="{{ route('dokter.pemeriksaan.edit', $rekamMedis->id) }}"
                   style="background: #004b23; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.8rem;">
                    <i class="fas fa-edit"></i> Edit Pemeriksaan
                </a>
                <a href="{{ route('dokter.pemeriksaan.index') }}"
                   style="background: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.8rem; margin-left: 0.5rem;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
