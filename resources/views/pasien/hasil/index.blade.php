@extends('layouts.app')

@section('title', 'Hasil Pemeriksaan')
@section('header', 'Hasil Laboratorium')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Hasil Pemeriksaan Tervalidasi</h3>
        <p style="color: #6b7280; font-size: 0.8rem;">Daftar hasil pemeriksaan yang sudah divalidasi oleh dokter</p>
    </div>

    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">No</th>
                    <th style="padding: 1rem;">Tanggal</th>
                    <th style="padding: 1rem;">Jenis Pemeriksaan</th>
                    <th style="padding: 1rem;">Dokter</th>
                    <th style="padding: 1rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasil as $index => $item)
                <tr>
                    <td style="padding: 1rem;">{{ $loop->iteration + ($hasil->currentPage() - 1) * $hasil->perPage() }}</td>
                    <td style="padding: 1rem;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                    <td style="padding: 1rem;">Pemeriksaan Laboratorium</td>
                    <td style="padding: 1rem;">{{ $item->dokter->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 1rem;">
                        <a href="{{ route('pasien.hasil.show', $item->id) }}"
                           style="background: #004b23; color: white; padding: 0.3rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.7rem;">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-file-medical" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Belum ada hasil pemeriksaan yang divalidasi</p>
                        <p style="color: #9ca3af; font-size: 0.8rem; margin-top: 0.5rem;">Hasil akan muncul setelah dokter memvalidasi pemeriksaan Anda</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($hasil->hasPages())
    <div style="padding: 1rem; border-top: 1px solid #f0f0f0;">
        {{ $hasil->links() }}
    </div>
    @endif
</div>
@endsection
