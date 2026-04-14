@extends('layouts.app')

@section('title', 'Antrian Pasien')
@section('header', 'Manajemen Antrian')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1rem; font-weight: 600;">Antrian Hari Ini</h3>
            <p style="color: #6b7280; font-size: 0.8rem;">Kelola antrian pemeriksaan pasien</p>
        </div>

        <form method="POST" action="{{ route('petugas_lab.antrian.store') }}" style="display: flex; gap: 0.5rem;">
            @csrf
            <select name="user_id" required style="padding: 0.4rem; border: 1px solid #e5e7eb; border-radius: 6px;">
                <option value="">Pilih Pasien</option>
                @foreach($pasien as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->nip }})</option>
                @endforeach
            </select>
            <select name="jenis_pemeriksaan" required style="padding: 0.4rem; border: 1px solid #e5e7eb; border-radius: 6px;">
                <option value="darah">Darah</option>
                <option value="urin">Urin</option>
                <option value="lengkap">Lengkap</option>
            </select>
            <button type="submit" style="background: #004b23; color: white; padding: 0.4rem 1rem; border: none; border-radius: 6px;">Tambah</button>
        </form>
    </div>

    <div style="padding: 0 1.5rem 1rem 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
        <div style="background: #fef3c7; padding: 0.5rem 1rem; border-radius: 10px;">
            Menunggu: <strong>{{ $totalMenunggu ?? 0 }}</strong>
        </div>
        <div style="background: #dbeafe; padding: 0.5rem 1rem; border-radius: 10px;">
            Diproses: <strong>{{ $totalProses ?? 0 }}</strong>
        </div>
        <div style="background: #dcfce7; padding: 0.5rem 1rem; border-radius: 10px;">
            Selesai: <strong>{{ $totalSelesai ?? 0 }}</strong>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">No. Antrian</th>
                    <th style="padding: 1rem;">Pasien</th>
                    <th style="padding: 1rem;">Jenis</th>
                    <th style="padding: 1rem;">Waktu Masuk</th>
                    <th style="padding: 1rem;">Status</th>
                    <th style="padding: 1rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrian as $item)
                <tr>
                    <td style="padding: 1rem;"><strong>{{ $item->nomor_antrian }}</strong></td>
                    <td style="padding: 1rem;">{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td style="padding: 1rem;">{{ ucfirst($item->jenis_pemeriksaan) }}</td>
                    <td style="padding: 1rem;">{{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }}</td>
                    <td style="padding: 1rem;">
                        @if($item->status == 'menunggu')
                            <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.5rem; border-radius: 20px;">Menunggu</span>
                        @elseif($item->status == 'proses')
                            <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.5rem; border-radius: 20px;">Diproses</span>
                        @else
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 20px;">Selesai</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        @if($item->status == 'menunggu')
                            <form action="{{ route('petugas_lab.antrian.proses', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background: #004b23; color: white; padding: 0.3rem 0.8rem; border: none; border-radius: 6px;">Proses</button>
                            </form>
                        @elseif($item->status == 'proses')
                            <form action="{{ route('petugas_lab.antrian.selesai', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background: #10b981; color: white; padding: 0.3rem 0.8rem; border: none; border-radius: 6px;">Selesai</button>
                            </form>
                        @else
                            <span style="color: #6b7280;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem;">Belum ada antrian hari ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
