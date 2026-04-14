@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header', 'Overview')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 0.8rem; margin-bottom: 0.5rem;">Total Pengguna</p>
                <p style="font-size: 2rem; font-weight: 700; color: #1a1a1a;">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-users" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
        </div>
        <div style="margin-top: 1rem; border-top: 1px solid #f3f4f6; padding-top: 0.75rem;">
            <span style="font-size: 0.7rem; color: #10b981;">↑ 12% </span>
            <span style="font-size: 0.7rem; color: #6b7280;">dari bulan lalu</span>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 0.8rem; margin-bottom: 0.5rem;">Total Pasien</p>
                <p style="font-size: 2rem; font-weight: 700; color: #1a1a1a;">{{ $totalPasien ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-user-friends" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 0.8rem; margin-bottom: 0.5rem;">Pemeriksaan Bulan Ini</p>
                <p style="font-size: 2rem; font-weight: 700; color: #1a1a1a;">{{ $totalPemeriksaanBulanIni ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-microscope" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 0.8rem; margin-bottom: 0.5rem;">Menunggu Validasi</p>
                <p style="font-size: 2rem; font-weight: 700; color: #1a1a1a;">{{ $totalPemeriksaanMenunggu ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-clock" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-size: 1rem; font-weight: 600;">Statistik Pemeriksaan {{ date('Y') }}</h3>
        </div>
        <canvas id="pemeriksaanChart" height="200"></canvas>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-size: 1rem; font-weight: 600;">Pasien Teraktif</h3>
        </div>
        <div style="space-y: 1rem;">
            @if(isset($topPasien) && count($topPasien) > 0)
                @foreach($topPasien as $pasien)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 32px; height: 32px; background: #e8f3ec; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <span style="color: #004b23; font-weight: 600;">{{ $loop->iteration }}</span>
                        </div>
                        <div>
                            <p style="font-size: 0.85rem; font-weight: 500;">{{ $pasien->user->nama_lengkap ?? '-' }}</p>
                            <p style="font-size: 0.7rem; color: #6b7280;">NIP: {{ $pasien->user->nip ?? '-' }}</p>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-size: 1rem; font-weight: 600; color: #004b23;">{{ $pasien->total }}</p>
                        <p style="font-size: 0.65rem; color: #6b7280;">kali</p>
                    </div>
                </div>
                @endforeach
            @else
                <p style="text-align: center; color: #6b7280; padding: 2rem;">Belum ada data</p>
            @endif
        </div>
    </div>
</div>

<div class="stat-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">Aktivitas Terbaru</h3>
    </div>
    <div>
        @if(isset($recentActivities) && count($recentActivities) > 0)
            @foreach($recentActivities as $log)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 32px; height: 32px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user" style="color: #6b7280; font-size: 0.8rem;"></i>
                    </div>
                    <div>
                        <p style="font-size: 0.85rem;">{{ $log->aktivitas }}</p>
                        <p style="font-size: 0.7rem; color: #6b7280;">Oleh: {{ $log->user->nama_lengkap ?? '-' }}</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 0.7rem; color: #6b7280;">{{ $log->waktu->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">Belum ada aktivitas</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pemeriksaanChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pemeriksaan',
                data: {!! json_encode($chartData ?? array_fill(0, 12, 0)) !!},
                borderColor: '#004b23',
                backgroundColor: 'rgba(0, 75, 35, 0.05)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#004b23',
                pointBorderColor: '#004b23'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
