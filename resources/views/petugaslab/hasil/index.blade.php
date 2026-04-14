@extends('layouts.app')

@section('title', 'Hasil Pemeriksaan')
@section('header', 'Hasil Pemeriksaan Laboratorium')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">Daftar Hasil Pemeriksaan</h3>
        <p style="color: #6b7280; font-size: 0.8rem;">Semua hasil pemeriksaan laboratorium</p>
    </div>

    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">No</th>
                    <th style="padding: 1rem;">Tanggal</th>
                    <th style="padding: 1rem;">Nama Pasien</th>
                    <th style="padding: 1rem;">NIP</th>
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
                        <strong>{{ $item->user->nama_lengkap ?? '-' }}</strong>
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ $item->user->jenis_kelamin ?? '-' }}</div>
                    </td>
                    <td style="padding: 1rem;">{{ $item->user->nip ?? '-' }}</td>
                    <td style="padding: 1rem;">
                        @if($item->status_validasi == 'divalidasi')
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Divalidasi</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Menunggu</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <a href="{{ route('petugas_lab.hasil-lab.edit', $item->id) }}"
                           style="background: #004b23; color: white; padding: 0.3rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.7rem;">
                            <i class="fas fa-edit"></i> Input Hasil
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-flask" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Belum ada data pemeriksaan</p>
                    </td>
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
