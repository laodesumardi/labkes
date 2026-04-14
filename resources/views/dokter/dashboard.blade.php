@extends('layouts.app')

@section('title', 'Dashboard Dokter')
@section('header', 'Dashboard Dokter')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.8rem;">Total Pemeriksaan</p>
                <p style="font-size: 2rem; font-weight: 700;">{{ $totalPemeriksaan ?? 0 }}</p>
            </div>
            <div style="background: #e8f3ec; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-stethoscope" style="color: #004b23; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.8rem;">Menunggu Validasi</p>
                <p style="font-size: 2rem; font-weight: 700; color: #f59e0b;">{{ $menungguValidasi ?? 0 }}</p>
            </div>
            <div style="background: #fef3c7; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-clock" style="color: #f59e0b; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="color: #6b7280; font-size: 0.8rem;">Sudah Divalidasi</p>
                <p style="font-size: 2rem; font-weight: 700; color: #10b981;">{{ $sudahDivalidasi ?? 0 }}</p>
            </div>
            <div style="background: #dcfce7; padding: 0.75rem; border-radius: 12px;">
                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>
</div>

<div class="stat-card">
    <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Pemeriksaan Terbaru</h3>
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>IMT</th>
                    <th>Tekanan Darah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestPemeriksaan ?? [] as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->imt ?? '-' }}</td>
                    <td>{{ $item->sistolik }}/{{ $item->diastolik }}</td>
                    <td>
                        @if($item->status_validasi == 'divalidasi')
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Divalidasi</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Menunggu</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dokter.pemeriksaan.show', $item->id) }}" style="color: #004b23;">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
