@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan')
@section('header', 'Riwayat Pemeriksaan')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <!-- Header -->
    <div style="padding: 1.5rem 1.5rem 0 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Semua Riwayat Pemeriksaan</h3>
                <p style="color: #6b7280; font-size: 0.8rem;">Daftar semua pemeriksaan yang pernah Anda lakukan</p>
            </div>

            <!-- Search -->
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" placeholder="Cari pemeriksaan..."
                       style="padding: 0.5rem 1rem 0.5rem 2.5rem; border: 1px solid #e5e7eb; border-radius: 10px; width: 250px; font-size: 0.8rem; outline: none;">
            </div>
        </div>
    </div>

    <!-- Filter Status -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0;">
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <button onclick="filterStatus('all')" class="filter-status active" data-status="all"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Semua
            </button>
            <button onclick="filterStatus('divalidasi')" class="filter-status" data-status="divalidasi"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-check-circle" style="color: #10b981;"></i> Divalidasi
            </button>
            <button onclick="filterStatus('draft')" class="filter-status" data-status="draft"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-clock" style="color: #f59e0b;"></i> Menunggu
            </button>
            <button onclick="filterStatus('dibatalkan')" class="filter-status" data-status="dibatalkan"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-times-circle" style="color: #ef4444;"></i> Dibatalkan
            </button>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">No</th>
                    <th style="padding: 1rem;">Tanggal</th>
                    <th style="padding: 1rem;">Petugas Lab</th>
                    <th style="padding: 1rem;">Dokter</th>
                    <th style="padding: 1rem;">Status</th>
                    <th style="padding: 1rem;">Aksi</th>
                </tr>
            </thead>
            <tbody id="riwayatTableBody">
                @forelse($riwayat as $index => $item)
                <tr class="riwayat-row" data-status="{{ $item->status_validasi }}">
                    <td style="padding: 1rem;">{{ $loop->iteration + ($riwayat->currentPage() - 1) * $riwayat->perPage() }}</td>
                    <td style="padding: 1rem;">
                        {{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y') }}
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('H:i') }}</div>
                    </td>
                    <td style="padding: 1rem;">
                        {{ $item->petugas->nama_lengkap ?? '-' }}
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ $item->petugas->nip ?? '-' }}</div>
                    </td>
                    <td style="padding: 1rem;">
                        @if($item->dokter)
                            {{ $item->dokter->nama_lengkap ?? '-' }}
                            <div style="font-size: 0.7rem; color: #6b7280;">{{ $item->dokter->nip ?? '-' }}</div>
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        @if($item->status_validasi == 'divalidasi')
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-check-circle"></i>
                                Divalidasi
                            </span>
                        @elseif($item->status_validasi == 'dibatalkan')
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-times-circle"></i>
                                Dibatalkan
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fef3c7; color: #92400e; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-clock"></i>
                                Menunggu Validasi
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <a href="{{ route('pasien.riwayat.show', $item->id) }}"
                           style="background: #004b23; color: white; padding: 0.3rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i class="fas fa-eye"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-folder-open" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Belum ada riwayat pemeriksaan</p>
                        <a href="{{ route('petugas_lab.pemeriksaan.create') }}" style="color: #004b23; font-size: 0.8rem;">Lakukan pemeriksaan sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($riwayat->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="font-size: 0.75rem; color: #6b7280;">
            Menampilkan {{ $riwayat->firstItem() }} - {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} data
        </div>
        <div style="display: flex; gap: 0.25rem;">
            @if($riwayat->onFirstPage())
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&laquo;</span>
            @else
                <a href="{{ $riwayat->previousPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&laquo;</a>
            @endif

            @foreach($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                @if($page == $riwayat->currentPage())
                    <span style="padding: 0.4rem 0.8rem; background: #004b23; color: white; border-radius: 6px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #374151; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach

            @if($riwayat->hasMorePages())
                <a href="{{ $riwayat->nextPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&raquo;</a>
            @else
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
    .filter-status.active {
        background: #004b23 !important;
        color: white !important;
        border-color: #004b23 !important;
    }

    .filter-status:hover:not(.active) {
        background: #f3f4f6;
        border-color: #d1d5db;
    }
</style>

<script>
    let currentFilter = 'all';

    function filterStatus(status) {
        currentFilter = status;

        document.querySelectorAll('.filter-status').forEach(btn => {
            btn.classList.remove('active');
            if(btn.getAttribute('data-status') === status) {
                btn.classList.add('active');
            }
        });

        applyFilters();
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        applyFilters();
    });

    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.riwayat-row');

        rows.forEach(row => {
            const status = row.getAttribute('data-status');

            const matchStatus = currentFilter === 'all' || status === currentFilter;

            if (matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection
