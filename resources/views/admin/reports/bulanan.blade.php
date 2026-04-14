@extends('layouts.app')

@section('title', 'Laporan Bulanan')
@section('header', 'Laporan Pemeriksaan Bulanan')

@section('content')
<div class="stat-card">
    <!-- Form Pilih Bulan -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <form method="GET" action="{{ route('admin.reports.bulanan') }}" style="display: flex; gap: 0.5rem; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 0.7rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Bulan</label>
                <select name="month" style="padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem;">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ (int)($month ?? date('m')) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.7rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Tahun</label>
                <select name="year" style="padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem;">
                    @for($y = date('Y')-3; $y <= date('Y')+1; $y++)
                        <option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
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

    <!-- Statistik Bulanan -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Total Pemeriksaan</p>
            <p style="font-size: 1.5rem; font-weight: 700;">{{ $reports->count() }}</p>
        </div>
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Rata-rata per Hari</p>
            <p style="font-size: 1.5rem; font-weight: 700;">
                @php
                    $daysInMonth = \Carbon\Carbon::create((int)($year ?? date('Y')), (int)($month ?? date('m')))->daysInMonth;
                    $avgPerDay = $daysInMonth > 0 ? round($reports->count() / $daysInMonth, 1) : 0;
                @endphp
                {{ $avgPerDay }}
            </p>
        </div>
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Tertinggi per Hari</p>
            <p style="font-size: 1.5rem; font-weight: 700;">{{ $tertinggiPerHari ?? 0 }}</p>
        </div>
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Divalidasi</p>
            <p style="font-size: 1.5rem; font-weight: 700; color: #10b981;">{{ $reports->where('status_validasi', 'divalidasi')->count() }}</p>
        </div>
    </div>

    <!-- Grafik Harian -->
    @if(isset($dailyData) && count($dailyData) > 0)
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-size: 0.85rem; font-weight: 600; margin-bottom: 1rem;">Grafik Pemeriksaan per Hari</h4>
        <canvas id="dailyChart" height="200"></canvas>
    </div>
    @endif

    <!-- Tabel Data -->
    @if($reports->count() > 0)
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 0.75rem;">Tanggal</th>
                    <th style="padding: 0.75rem;">Jumlah</th>
                    <th style="padding: 0.75rem;">Divalidasi</th>
                    <th style="padding: 0.75rem;">Menunggu</th>
                    <th style="padding: 0.75rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grouped = $reports->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('Y-m-d');
                    });
                @endphp
                @foreach($grouped as $date => $items)
                <tr>
                    <td style="padding: 0.75rem; font-size: 0.8rem;">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem; font-weight: 600;">{{ $items->count() }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem; color: #10b981;">{{ $items->where('status_validasi', 'divalidasi')->count() }}</td>
                    <td style="padding: 0.75rem; font-size: 0.8rem; color: #f59e0b;">{{ $items->where('status_validasi', 'draft')->count() }}</td>
                    <td style="padding: 0.75rem;">
                        <a href="{{ route('admin.reports.harian', ['date' => $date]) }}" style="color: #004b23; text-decoration: none;">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 3rem;">
        <i class="fas fa-calendar-alt" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
        <p style="color: #6b7280;">
            Tidak ada pemeriksaan pada
            @php
                $bulan = (int)($month ?? date('m'));
                $tahun = (int)($year ?? date('Y'));
                $namaBulan = \Carbon\Carbon::create()->month($bulan)->format('F');
            @endphp
            {{ $namaBulan }} {{ $tahun }}
        </p>
    </div>
    @endif
</div>

@if(isset($dailyData) && count($dailyData) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dailyChart')?.getContext('2d');
    if (ctx) {
        const dailyData = @json($dailyData);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dailyData.map(d => d.tanggal),
                datasets: [{
                    label: 'Jumlah Pemeriksaan',
                    data: dailyData.map(d => d.jumlah),
                    backgroundColor: 'rgba(0, 75, 35, 0.6)',
                    borderColor: '#004b23',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#004b23' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                }
            }
        });
    }
</script>
@endif
@endsection
