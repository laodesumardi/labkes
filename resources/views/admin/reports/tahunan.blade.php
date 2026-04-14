@extends('layouts.app')

@section('title', 'Laporan Tahunan')
@section('header', 'Laporan Pemeriksaan Tahunan')

@section('content')
<div class="stat-card">
    <!-- Form Pilih Tahun -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <form method="GET" action="{{ route('admin.reports.tahunan') }}" style="display: flex; gap: 0.5rem; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 0.7rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Tahun</label>
                <select name="year" style="padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem;">
                    @for($y = date('Y')-5; $y <= date('Y'); $y++)
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

    <!-- Statistik Tahunan -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Total Pemeriksaan</p>
            <p style="font-size: 1.5rem; font-weight: 700;">{{ $reports->count() }}</p>
        </div>
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Rata-rata per Bulan</p>
            <p style="font-size: 1.5rem; font-weight: 700;">{{ round($reports->count() / 12, 1) }}</p>
        </div>
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Bulan Tersibuk</p>
            <p style="font-size: 1rem; font-weight: 700;">{{ $bulanTersibuk ?? '-' }}</p>
            <p style="font-size: 0.7rem;">{{ $jumlahTersibuk ?? 0 }} pemeriksaan</p>
        </div>
        <div style="background: #e8f3ec; padding: 1rem; border-radius: 12px; text-align: center;">
            <p style="font-size: 0.7rem; color: #004b23;">Pertumbuhan</p>
            <p style="font-size: 1rem; font-weight: 700; color: {{ ($persentasePertumbuhan ?? 0) >= 0 ? '#10b981' : '#ef4444' }}">
                {{ ($persentasePertumbuhan ?? 0) >= 0 ? '+' : '' }}{{ $persentasePertumbuhan ?? 0 }}%
            </p>
        </div>
    </div>

    <!-- Grafik Tren -->
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-size: 0.85rem; font-weight: 600; margin-bottom: 1rem;">Grafik Tren Pemeriksaan {{ $year ?? date('Y') }}</h4>
        <canvas id="yearlyChart" height="200"></canvas>
    </div>

    <!-- Tabel Perbandingan dengan Tahun Lalu -->
    @if($reports->count() > 0)
    <div style="overflow-x: auto;">
        <h4 style="font-size: 0.85rem; font-weight: 600; margin-bottom: 1rem;">Perbandingan dengan Tahun Lalu</h4>
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 0.75rem;">Bulan</th>
                    <th style="padding: 0.75rem;">{{ $year ?? date('Y') }}</th>
                    <th style="padding: 0.75rem;">{{ ($year ?? date('Y')) - 1 }}</th>
                    <th style="padding: 0.75rem;">Perubahan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $currentYearData = $monthlyData->pluck('total', 'bulan')->toArray();
                    $lastYearData = $lastYearData ?? collect();
                @endphp
                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'] as $index => $bulan)
                    @php
                        $current = $currentYearData[$index+1] ?? 0;
                        $last = $lastYearData[$index+1] ?? 0;
                        $diff = $current - $last;
                        $diffPercent = $last > 0 ? round(($diff / $last) * 100, 1) : ($current > 0 ? 100 : 0);
                    @endphp
                    <tr>
                        <td style="padding: 0.75rem; font-weight: 500;">{{ $bulan }}</td>
                        <td style="padding: 0.75rem;">{{ $current }}</td>
                        <td style="padding: 0.75rem;">{{ $last }}</td>
                        <td style="padding: 0.75rem;">
                            @if($diff > 0)
                                <span style="color: #10b981;">↑ {{ $diff }} ({{ $diffPercent }}%)</span>
                            @elseif($diff < 0)
                                <span style="color: #ef4444;">↓ {{ abs($diff) }} ({{ abs($diffPercent) }}%)</span>
                            @else
                                <span style="color: #6b7280;">= 0</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 3rem;">
        <i class="fas fa-calendar-week" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
        <p style="color: #6b7280;">Tidak ada pemeriksaan pada tahun {{ $year ?? date('Y') }}</p>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('yearlyChart').getContext('2d');
    const monthlyTotals = @json($monthlyTotals ?? array_fill(0, 12, 0));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pemeriksaan',
                data: monthlyTotals,
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
</script>
@endsection
