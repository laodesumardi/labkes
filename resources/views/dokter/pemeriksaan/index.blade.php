@extends('layouts.app')

@section('title', 'Data Pemeriksaan')
@section('header', 'Data Pemeriksaan Pasien')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600;">Semua Data Pemeriksaan</h3>
        <p style="color: #6b7280; font-size: 0.8rem; margin-top: 0.25rem;">Menampilkan semua riwayat pemeriksaan pasien</p>
    </div>

    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>NIP</th>
                    <th>IMT</th>
                    <th>Tekanan Darah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemeriksaans as $index => $item)
                <tr>
                    <td>{{ $loop->iteration + ($pemeriksaans->currentPage() - 1) * $pemeriksaans->perPage() }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->user->nip ?? '-' }}</td>
                    <td>{{ $item->imt ?? '-' }}</td>
                    <td>{{ $item->sistolik }}/{{ $item->diastolik }}</td>
                    <td>
                        @if($item->status_validasi == 'divalidasi')
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Divalidasi</span>
                        @elseif($item->status_validasi == 'dibatalkan')
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Dibatalkan</span>
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
                    <td colspan="8" style="text-align: center; padding: 3rem;">Belum ada data pemeriksaan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem;">
        {{ $pemeriksaans->links() }}
    </div>
</div>
@endsection
