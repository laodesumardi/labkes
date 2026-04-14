@extends('layouts.app')

@section('title', 'Data Pemeriksaan')
@section('header', 'Data Pemeriksaan')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1rem; font-weight: 600;">Semua Pemeriksaan</h3>
            <p style="color: #6b7280; font-size: 0.8rem;">Daftar semua pemeriksaan yang telah dilakukan</p>
        </div>
        <a href="{{ route('petugas_lab.pemeriksaan.create') }}"
           style="background: #004b23; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none;">
            <i class="fas fa-plus"></i> Pemeriksaan Baru
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">No</th>
                    <th style="padding: 1rem;">Tanggal</th>
                    <th style="padding: 1rem;">Pasien</th>
                    <th style="padding: 1rem;">Status</th>
                    <th style="padding: 1rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemeriksaans as $index => $item)
                <tr>
                    <td style="padding: 1rem;">{{ $loop->iteration + ($pemeriksaans->currentPage() - 1) * $pemeriksaans->perPage() }}</td>
                    <td style="padding: 1rem;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                    <td style="padding: 1rem;">
                        <strong>{{ $item->user->nama_lengkap ?? '-' }}</strong><br>
                        <small style="color: #6b7280;">{{ $item->user->nip ?? '-' }}</small>
                    </td>
                    <td style="padding: 1rem;">
                        @if($item->status_validasi == 'divalidasi')
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 20px;">Divalidasi</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.5rem; border-radius: 20px;">Menunggu</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <a href="{{ route('petugas_lab.pemeriksaan.edit', $item->id) }}"
                           style="background: #004b23; color: white; padding: 0.3rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.7rem;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('petugas_lab.hasil-lab.edit', $item->id) }}"
                           style="background: #f59e0b; color: white; padding: 0.3rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.7rem; margin-left: 0.3rem;">
                            <i class="fas fa-flask"></i> Hasil Lab
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem;">Belum ada data pemeriksaan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pemeriksaans->hasPages())
    <div style="padding: 1rem; border-top: 1px solid #f0f0f0;">
        {{ $pemeriksaans->links() }}
    </div>
    @endif
</div>
@endsection
