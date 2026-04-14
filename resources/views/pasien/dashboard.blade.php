@extends('layouts.app')

@section('title', 'Dashboard Pasien')
@section('header', 'Dashboard Pasien')

@section('content')
<!-- Selamat Datang -->
<div class="stat-card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #004b23 0%, #003518 100%); color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.25rem;">
                Selamat Datang, {{ Auth::user()->nama_lengkap }}
            </h2>
            <p style="font-size: 0.8rem; opacity: 0.9;">
                NIP: {{ Auth::user()->nip }}
            </p>
        </div>
        <div style="background: rgba(255,255,255,0.15); padding: 0.5rem 1rem; border-radius: 12px;">
            <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem;">Total Pemeriksaan</p>
                <p style="font-size: 1.5rem; font-weight: 700;">{{ $totalPemeriksaan ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-microscope" style="color: #004b23; font-size: 1rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem;">Sudah Divalidasi</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #10b981;">{{ $pemeriksaanDivalidasi ?? 0 }}</p>
            </div>
            <div style="background: #dcfce7; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem;">Menunggu Validasi</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">{{ $pemeriksaanMenunggu ?? 0 }}</p>
            </div>
            <div style="background: #fef3c7; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-clock" style="color: #f59e0b; font-size: 1rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.7rem;">Dibatalkan</p>
                <p style="font-size: 1.5rem; font-weight: 700; color: #ef4444;">{{ $pemeriksaanDibatalkan ?? 0 }}</p>
            </div>
            <div style="background: #fee2e2; padding: 0.6rem; border-radius: 10px;">
                <i class="fas fa-times-circle" style="color: #ef4444; font-size: 1rem;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Antrian Aktif -->
@if($antrianAktif)
<div class="stat-card" style="margin-bottom: 1.5rem; background: #fef3c7; border-left: 4px solid #f59e0b;">
    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <div style="background: #f59e0b; padding: 0.5rem 1rem; border-radius: 10px;">
            <i class="fas fa-clock" style="color: white;"></i>
        </div>
        <div style="flex: 1;">
            <p style="font-size: 0.7rem; color: #92400e;">Antrian Aktif</p>
            <p style="font-size: 0.9rem; font-weight: 600;">
                Nomor Antrian: <strong style="font-size: 1.2rem;">{{ $antrianAktif->nomor_antrian }}</strong>
                - Status: {{ ucfirst($antrianAktif->status) }}
            </p>
        </div>
        <a href="{{ route('pasien.riwayat.index') }}" style="color: #92400e; font-size: 0.7rem;">Lihat Riwayat →</a>
    </div>
</div>
@endif

<!-- Pemeriksaan Terbaru -->
<div class="stat-card" style="margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">
            <i class="fas fa-history" style="color: #004b23; margin-right: 0.5rem;"></i>
            Pemeriksaan Terbaru
        </h3>
        <a href="{{ route('pasien.riwayat.index') }}" style="color: #004b23; font-size: 0.75rem;">Lihat semua →</a>
    </div>

    @if($pemeriksaanTerbaru && $pemeriksaanTerbaru->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 0.5rem;">Tanggal</th>
                    <th style="text-align: left; padding: 0.5rem;">Petugas Lab</th>
                    <th style="text-align: left; padding: 0.5rem;">Status</th>
                    <th style="text-align: left; padding: 0.5rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemeriksaanTerbaru as $item)
                <tr>
                    <td style="padding: 0.5rem;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                    <td style="padding: 0.5rem;">{{ $item->petugas->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 0.5rem;">
                        @if($item->status_validasi == 'divalidasi')
                            <span style="background: #dcfce7; color: #166534; padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Divalidasi</span>
                        @elseif($item->status_validasi == 'dibatalkan')
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Dibatalkan</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Menunggu</span>
                        @endif
                    </td>
                    <td style="padding: 0.5rem;">
                        <a href="{{ route('pasien.riwayat.show', $item->id) }}" style="color: #004b23;">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 2rem;">
        <i class="fas fa-folder-open" style="font-size: 2rem; color: #d1d5db;"></i>
        <p style="color: #6b7280; margin-top: 0.5rem;">Belum ada pemeriksaan</p>
        <a href="{{ route('petugas_lab.pemeriksaan.create') }}" style="color: #004b23; font-size: 0.8rem;">Lakukan pemeriksaan sekarang</a>
    </div>
    @endif
</div>

<!-- Hasil Lab Terbaru -->
<div class="stat-card" style="margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">
            <i class="fas fa-file-medical" style="color: #004b23; margin-right: 0.5rem;"></i>
            Hasil Laboratorium Terbaru
        </h3>
        <a href="{{ route('pasien.hasil.index') }}" style="color: #004b23; font-size: 0.75rem;">Lihat semua →</a>
    </div>

    @if($hasilTerbaru && $hasilTerbaru->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 0.5rem;">Tanggal</th>
                    <th style="text-align: left; padding: 0.5rem;">Dokter</th>
                    <th style="text-align: left; padding: 0.5rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilTerbaru as $item)
                <tr>
                    <td style="padding: 0.5rem;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                    <td style="padding: 0.5rem;">{{ $item->dokter->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 0.5rem;">
                        <a href="{{ route('pasien.hasil.show', $item->id) }}" style="color: #004b23;">
                            <i class="fas fa-eye"></i> Lihat Hasil
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 2rem;">
        <i class="fas fa-flask" style="font-size: 2rem; color: #d1d5db;"></i>
        <p style="color: #6b7280; margin-top: 0.5rem;">Belum ada hasil laboratorium</p>
    </div>
    @endif
</div>

<!-- Grafik Pemeriksaan -->
<div class="stat-card">
    <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">
        <i class="fas fa-chart-line" style="color: #004b23; margin-right: 0.5rem;"></i>
        Grafik Pemeriksaan 6 Bulan Terakhir
    </h3>
    <canvas id="pemeriksaanChart" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($chartData);

    const ctx = document.getElementById('pemeriksaanChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(d => d.bulan),
            datasets: [{
                label: 'Jumlah Pemeriksaan',
                data: chartData.map(d => d.jumlah),
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
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });
</script>
@endsection
