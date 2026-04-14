@extends('layouts.app')

@section('title', 'Detail Riwayat Pemeriksaan')
@section('header', 'Detail Pemeriksaan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Informasi Pasien -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-user" style="color: #004b23; margin-right: 0.5rem;"></i>
            Informasi Pasien
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Nama Lengkap</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ $pemeriksaan->user->nama_lengkap ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">NIP</p>
                <p style="font-size: 0.9rem; font-family: monospace;">{{ $pemeriksaan->user->nip ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Jenis Kelamin</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->user->jenis_kelamin ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tanggal Lahir</p>
                <p style="font-size: 0.9rem;">
                    @if($pemeriksaan->user->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($pemeriksaan->user->tanggal_lahir)->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($pemeriksaan->user->tanggal_lahir)->age }} tahun)
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Informasi Pemeriksaan -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-stethoscope" style="color: #004b23; margin-right: 0.5rem;"></i>
            Informasi Pemeriksaan
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tanggal Pemeriksaan</p>
                <p style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Petugas Lab</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->petugas->nama_lengkap ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Dokter Pemeriksa</p>
                <p style="font-size: 0.9rem;">
                    @if($pemeriksaan->dokter)
                        {{ $pemeriksaan->dokter->nama_lengkap ?? '-' }}
                    @else
                        <span style="color: #f59e0b;">Belum divalidasi</span>
                    @endif
                </p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Status</p>
                @if($pemeriksaan->status_validasi == 'divalidasi')
                    <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 20px;">
                        <i class="fas fa-check-circle"></i> Divalidasi
                    </span>
                @elseif($pemeriksaan->status_validasi == 'dibatalkan')
                    <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 20px;">
                        <i class="fas fa-times-circle"></i> Dibatalkan
                    </span>
                @else
                    <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.5rem; border-radius: 20px;">
                        <i class="fas fa-clock"></i> Menunggu Validasi
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Pemeriksaan Fisik -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-heartbeat" style="color: #004b23; margin-right: 0.5rem;"></i>
            Data Pemeriksaan Fisik
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tinggi Badan</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->tinggi_cm ?? '-' }} cm</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Berat Badan</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->berat_kg ?? '-' }} kg</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Lingkar Perut</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->lingkar_perut_cm ?? '-' }} cm</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">IMT (Indeks Massa Tubuh)</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ $pemeriksaan->imt ?? '-' }}</p>
                <p style="font-size: 0.7rem; color: #6b7280;">{{ $pemeriksaan->kategori_imt ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tekanan Darah</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->sistolik }}/{{ $pemeriksaan->diastolik }} mmHg</p>
                <p style="font-size: 0.7rem; color: #6b7280;">{{ $pemeriksaan->kategori_tekanan ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Hasil Laboratorium -->
    @if($pemeriksaan->hasilPemeriksaan && $pemeriksaan->hasilPemeriksaan->count() > 0)
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
                    @foreach($pemeriksaan->hasilPemeriksaan as $hasil)
                    @php
                        $status = $hasil->status;
                        $statusColor = $status == 'Normal' ? '#10b981' : ($status == 'Tinggi' ? '#ef4444' : '#f59e0b');
                        $statusBg = $status == 'Normal' ? '#dcfce7' : ($status == 'Tinggi' ? '#fee2e2' : '#fef3c7');
                    @endphp
                    <tr>
                        <td style="padding: 0.75rem; font-weight: 500;">{{ $hasil->parameter->nama_param ?? '-' }}</td>
                        <td style="padding: 0.75rem; font-weight: 500;">{{ $hasil->nilai }}</td>
                        <td style="padding: 0.75rem;">{{ $hasil->parameter->satuan ?? '-' }}</td>
                        <td style="padding: 0.75rem;">
                            @if($hasil->parameter->nilai_normal_min && $hasil->parameter->nilai_normal_max)
                                {{ $hasil->parameter->nilai_normal_min }} - {{ $hasil->parameter->nilai_normal_max }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="padding: 0.75rem;">
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

    <!-- Catatan Medis -->
    <div class="stat-card">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-notes-medical" style="color: #004b23; margin-right: 0.5rem;"></i>
            Catatan Medis
        </h3>

        <div style="margin-bottom: 1rem;">
            <div style="background: #f9fafb; padding: 1rem; border-radius: 12px;">
                <p style="font-size: 0.85rem;">{{ $pemeriksaan->catatan ?? 'Tidak ada catatan' }}</p>
            </div>
        </div>

        <!-- Tanda Tangan Digital (Jika sudah divalidasi) -->
        @if($pemeriksaan->status_validasi == 'divalidasi' && $pemeriksaan->dokter)
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
            <div style="display: flex; justify-content: flex-end;">
                <div style="text-align: center;">
                    <p style="font-size: 0.7rem; color: #6b7280;">Divalidasi oleh</p>
                    <p style="font-size: 0.85rem; font-weight: 600;">Dr. {{ $pemeriksaan->dokter->nama_lengkap }}</p>
                    <p style="font-size: 0.7rem; color: #6b7280;">NIP: {{ $pemeriksaan->dokter->nip }}</p>
                    <div style="width: 100px; height: 40px; margin-top: 0.5rem;">
                        <i class="fas fa-stamp" style="font-size: 2rem; color: #004b23; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Tombol Aksi -->
    <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
        <a href="{{ route('pasien.riwayat.index') }}"
           style="background: #6b7280; color: white; padding: 0.6rem 1.5rem; border-radius: 8px; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        @if($pemeriksaan->status_validasi == 'divalidasi')
        <a href="{{ route('pasien.hasil.pdf', $pemeriksaan->id) }}"
           style="background: #004b23; color: white; padding: 0.6rem 1.5rem; border-radius: 8px; text-decoration: none;">
            <i class="fas fa-print"></i> Cetak PDF
        </a>
        @endif
    </div>
</div>
@endsection
