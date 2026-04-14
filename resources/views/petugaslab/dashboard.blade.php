@extends('layouts.app')

@section('title', 'Dashboard Petugas Lab')
@section('header', 'Dashboard Petugas Laboratorium')

@section('content')
<!-- Statistik Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.75rem;">Total Pemeriksaan</p>
                <p style="font-size: 1.75rem; font-weight: 700;">{{ $totalPemeriksaan ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-microscope" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.75rem;">Pemeriksaan Hari Ini</p>
                <p style="font-size: 1.75rem; font-weight: 700;">{{ $pemeriksaanHariIni ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-calendar-day" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.75rem;">Antrian Menunggu</p>
                <p style="font-size: 1.75rem; font-weight: 700; color: #f59e0b;">{{ $antrianMenunggu ?? 0 }}</p>
            </div>
            <div style="background: #fef3c7; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-clock" style="color: #f59e0b; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.75rem;">Menunggu Validasi</p>
                <p style="font-size: 1.75rem; font-weight: 700; color: #f59e0b;">{{ $pemeriksaanMenunggu ?? 0 }}</p>
            </div>
            <div style="background: #fef3c7; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-file-alt" style="color: #f59e0b; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Antrian Hari Ini -->
<div class="stat-card" style="margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">Antrian Hari Ini</h3>
        <a href="{{ route('petugas_lab.antrian.index') }}" style="color: #004b23; font-size: 0.75rem;">Lihat semua →</a>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 0.5rem;">No. Antrian</th>
                    <th style="text-align: left; padding: 0.5rem;">Pasien</th>
                    <th style="text-align: left; padding: 0.5rem;">Jenis</th>
                    <th style="text-align: left; padding: 0.5rem;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrianHariIni ?? [] as $item)
                <tr>
                    <td style="padding: 0.5rem;">{{ $item->nomor_antrian }}</td>
                    <td style="padding: 0.5rem;">{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 0.5rem;">{{ ucfirst($item->jenis_pemeriksaan) }}</td>
                    <td style="padding: 0.5rem;">
                        @if($item->status == 'menunggu')
                            <span style="background: #fef3c7; color: #92400e; padding: 0.2rem 0.5rem; border-radius: 20px;">Menunggu</span>
                        @elseif($item->status == 'proses')
                            <span style="background: #dbeafe; color: #1e40af; padding: 0.2rem 0.5rem; border-radius: 20px;">Diproses</span>
                        @else
                            <span style="background: #dcfce7; color: #166534; padding: 0.2rem 0.5rem; border-radius: 20px;">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem;">Belum ada antrian hari ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pemeriksaan Terbaru -->
<div class="stat-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">Pemeriksaan Terbaru</h3>
        <a href="{{ route('petugas_lab.pemeriksaan.index') }}" style="color: #004b23; font-size: 0.75rem;">Lihat semua →</a>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 0.5rem;">Tanggal</th>
                    <th style="text-align: left; padding: 0.5rem;">Pasien</th>
                    <th style="text-align: left; padding: 0.5rem;">Status</th>
                    <th style="text-align: left; padding: 0.5rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestPemeriksaan ?? [] as $item)
                <tr>
                    <td style="padding: 0.5rem;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                    <td style="padding: 0.5rem;">{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 0.5rem;">
                        @if($item->status_validasi == 'divalidasi')
                            <span style="background: #dcfce7; color: #166534; padding: 0.2rem 0.5rem; border-radius: 20px;">Divalidasi</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 0.2rem 0.5rem; border-radius: 20px;">Menunggu</span>
                        @endif
                    </td>
                    <td style="padding: 0.5rem;">
                        <a href="{{ route('petugas_lab.pemeriksaan.edit', $item->id) }}" style="color: #004b23;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem;">Belum ada pemeriksaan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
