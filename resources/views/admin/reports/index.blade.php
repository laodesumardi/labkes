@extends('layouts.app')

@section('title', 'Laporan')
@section('header', 'Laporan & Statistik')

@section('content')
<!-- Ringkasan -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem; margin-bottom: 0.25rem;">Total Pemeriksaan</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #1a1a1a;">{{ $totalPemeriksaan ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-microscope" style="color: #004b23;"></i>
            </div>
        </div>
        <div style="margin-top: 0.5rem; font-size: 0.65rem; color: #6b7280;">
            <i class="fas fa-calendar"></i> Sepanjang waktu
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem; margin-bottom: 0.25rem;">Pemeriksaan Bulan Ini</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #1a1a1a;">{{ $pemeriksaanBulanIni ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-chart-line" style="color: #004b23;"></i>
            </div>
        </div>
        <div style="margin-top: 0.5rem; font-size: 0.65rem; color: #6b7280;">
            <i class="fas fa-calendar-alt"></i> {{ date('F Y') }}
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem; margin-bottom: 0.25rem;">Total Pasien</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #1a1a1a;">{{ $totalPasien ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-users" style="color: #004b23;"></i>
            </div>
        </div>
        <div style="margin-top: 0.5rem; font-size: 0.65rem; color: #6b7280;">
            <i class="fas fa-user-plus"></i> Terdaftar di sistem
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem; margin-bottom: 0.25rem;">Rata-rata per Bulan</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #1a1a1a;">{{ $rataPerBulan ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-chart-bar" style="color: #004b23;"></i>
            </div>
        </div>
        <div style="margin-top: 0.5rem; font-size: 0.65rem; color: #6b7280;">
            <i class="fas fa-chart-simple"></i> {{ date('Y') }}
        </div>
    </div>
</div>

<!-- Menu Laporan -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Laporan Harian -->
    <div class="stat-card" style="cursor: pointer;" onclick="window.location='{{ route('admin.reports.harian') }}'">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="background: #e8f3ec; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-day" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Laporan Harian</h3>
                <p style="font-size: 0.7rem; color: #6b7280;">Lihat detail pemeriksaan per hari</p>
            </div>
        </div>
        <div style="border-top: 1px solid #f0f0f0; padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.7rem; color: #6b7280;">Pilih tanggal tertentu</span>
            <i class="fas fa-arrow-right" style="color: #004b23; font-size: 0.8rem;"></i>
        </div>
    </div>

    <!-- Laporan Bulanan -->
    <div class="stat-card" style="cursor: pointer;" onclick="window.location='{{ route('admin.reports.bulanan') }}'">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="background: #e8f3ec; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-alt" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Laporan Bulanan</h3>
                <p style="font-size: 0.7rem; color: #6b7280;">Statistik per bulan</p>
            </div>
        </div>
        <div style="border-top: 1px solid #f0f0f0; padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.7rem; color: #6b7280;">Pilih bulan dan tahun</span>
            <i class="fas fa-arrow-right" style="color: #004b23; font-size: 0.8rem;"></i>
        </div>
    </div>

    <!-- Laporan Tahunan -->
    <div class="stat-card" style="cursor: pointer;" onclick="window.location='{{ route('admin.reports.tahunan') }}'">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="background: #e8f3ec; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-week" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Laporan Tahunan</h3>
                <p style="font-size: 0.7rem; color: #6b7280;">Grafik tren tahunan</p>
            </div>
        </div>
        <div style="border-top: 1px solid #f0f0f0; padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.7rem; color: #6b7280;">Pilih tahun</span>
            <i class="fas fa-arrow-right" style="color: #004b23; font-size: 0.8rem;"></i>
        </div>
    </div>
</div>

<!-- Grafik Pemeriksaan -->
<div class="stat-card" style="margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">Tren Pemeriksaan {{ date('Y') }}</h3>
        <div style="display: flex; gap: 0.5rem;">
            <button onclick="exportChartAsImage()" style="background: none; border: 1px solid #e5e7eb; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.7rem; cursor: pointer;">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
    </div>
    <canvas id="trenChart" height="200"></canvas>
</div>

<!-- Pemeriksaan Terbaru -->
<div class="stat-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">Pemeriksaan Terbaru</h3>
        <a href="#" style="font-size: 0.7rem; color: #004b23; text-decoration: none;">Lihat semua →</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 0.75rem;">Tanggal</th>
                    <th style="padding: 0.75rem;">Pasien</th>
                    <th style="padding: 0.75rem;">NIP</th>
                    <th style="padding: 0.75rem;">IMT</th>
                    <th style="padding: 0.75rem;">Tekanan Darah</th>
                    <th style="padding: 0.75rem;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestPemeriksaan ?? [] as $item)
                <tr>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y') }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem; font-weight: 500;">{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ $item->user->nip ?? '-' }}</td>
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
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #6b7280;">Belum ada data pemeriksaan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('trenChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pemeriksaan',
                data: {{ json_encode($chartData ?? array_fill(0, 12, 0)) }},
                borderColor: '#004b23',
                backgroundColor: 'rgba(0, 75, 35, 0.05)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#004b23',
                pointBorderColor: '#004b23',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { usePointStyle: true }
                },
                tooltip: {
                    backgroundColor: '#004b23',
                    titleColor: 'white',
                    bodyColor: 'rgba(255,255,255,0.8)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    function exportChartAsImage() {
        const canvas = document.getElementById('trenChart');
        const link = document.createElement('a');
        link.download = 'tren-pemeriksaan.png';
        link.href = canvas.toDataURL();
        link.click();
    }
</script>
@endsection
