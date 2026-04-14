@extends('layouts.app')

@section('title', 'Laporan Harian')
@section('header', 'Laporan Pemeriksaan Harian')

@section('content')
<div class="stat-card">
    <!-- Form Pilih Tanggal -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <form method="GET" action="{{ route('admin.reports.harian') }}" style="display: flex; gap: 0.5rem; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 0.7rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Pilih Tanggal</label>
                <input type="date" name="date" value="{{ $date ?? date('Y-m-d') }}"
                       style="padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem;">
            </div>
            <button type="submit" style="background: #004b23; color: white; padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer;">
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </form>

        <div>
            <button onclick="window.print()" style="background: none; border: 1px solid #e5e7eb; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Informasi Tanggal -->
    <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #004b23;">Tanggal Laporan</p>
                <h3 style="font-size: 1.1rem; font-weight: 600;">{{ \Carbon\Carbon::parse($date ?? date('Y-m-d'))->format('d F Y') }}</h3>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #004b23;">Total Pemeriksaan</p>
                <p style="font-size: 1.5rem; font-weight: 700;">{{ $reports->count() }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #004b23;">Divalidasi</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #10b981;">{{ $reports->where('status_validasi', 'divalidasi')->count() }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #004b23;">Menunggu</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">{{ $reports->where('status_validasi', 'draft')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    @if($reports->count() > 0)
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 0.75rem;">No</th>
                    <th style="padding: 0.75rem;">Waktu</th>
                    <th style="padding: 0.75rem;">Nama Pasien</th>
                    <th style="padding: 0.75rem;">NIP</th>
                    <th style="padding: 0.75rem;">Jenis Kelamin</th>
                    <th style="padding: 0.75rem;">Usia</th>
                    <th style="padding: 0.75rem;">IMT</th>
                    <th style="padding: 0.75rem;">Tekanan Darah</th>
                    <th style="padding: 0.75rem;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $index => $item)
                <tr>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ $loop->iteration }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('H:i') }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem; font-weight: 500;">{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ $item->user->nip ?? '-' }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ $item->user->jenis_kelamin ?? '-' }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ $item->user->usia ?? '-' }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ $item->imt ?? '-' }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ $item->sistolik }}/{{ $item->diastolik }}</td>
                    <td style="padding: 0.75rem;">
                        @php
                            $statusClass = $item->status_validasi == 'divalidasi' ? '#dcfce7' : '#fef3c7';
                            $statusColor = $item->status_validasi == 'divalidasi' ? '#166534' : '#92400e';
                        @endphp
                        <span style="padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.65rem; background: {{ $statusClass }}; color: {{ $statusColor }};">
                            {{ ucfirst($item->status_validasi) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 3rem;">
        <i class="fas fa-calendar-day" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
        <p style="color: #6b7280;">Tidak ada pemeriksaan pada tanggal {{ \Carbon\Carbon::parse($date ?? date('Y-m-d'))->format('d F Y') }}</p>
    </div>
    @endif
</div>

<style>
    @media print {
        .sidebar, .top-navbar, button, form, .filter-section {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .stat-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>
@endsection
