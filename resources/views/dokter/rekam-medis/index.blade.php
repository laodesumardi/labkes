@extends('layouts.app')

@section('title', 'Rekam Medis')
@section('header', 'Rekam Medis Pasien')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <!-- Header -->
    <div style="padding: 1.5rem 1.5rem 0 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Riwayat Kesehatan Pasien</h3>
            <p style="color: #6b7280; font-size: 0.8rem;">Menampilkan semua data rekam medis pasien</p>
        </div>

        <!-- Filter dan Search -->
        <div style="display: flex; gap: 0.5rem;">
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" placeholder="Cari pasien..."
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

    <!-- Tabel Rekam Medis -->
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem 1.5rem;">No</th>
                    <th style="padding: 1rem 1.5rem;">Tanggal</th>
                    <th style="padding: 1rem 1.5rem;">Nama Pasien</th>
                    <th style="padding: 1rem 1.5rem;">NIP</th>
                    <th style="padding: 1rem 1.5rem;">Jenis Kelamin</th>
                    <th style="padding: 1rem 1.5rem;">Usia</th>
                    <th style="padding: 1rem 1.5rem;">IMT</th>
                    <th style="padding: 1rem 1.5rem;">Tekanan Darah</th>
                    <th style="padding: 1rem 1.5rem;">Status</th>
                    <th style="padding: 1rem 1.5rem;">Aksi</th>
                </tr>
            </thead>
            <tbody id="rekamMedisTableBody">
                @forelse($rekamMedis as $index => $item)
                <tr class="rekam-row" data-status="{{ $item->status_validasi }}" data-name="{{ strtolower($item->user->nama_lengkap ?? '') }}">
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $loop->iteration + ($rekamMedis->currentPage() - 1) * $rekamMedis->perPage() }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y') }}
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('H:i') }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 32px; height: 32px; background: #e8f3ec; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: #004b23; font-size: 0.8rem;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; font-weight: 500;">{{ $item->user->nama_lengkap ?? '-' }}</div>
                                <div style="font-size: 0.7rem; color: #6b7280;">{{ $item->user->no_telepon ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem; font-family: monospace;">{{ $item->user->nip ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $item->user->jenis_kelamin ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">
                        @php
                            $usia = null;
                            if ($item->user && $item->user->tanggal_lahir) {
                                $usia = \Carbon\Carbon::parse($item->user->tanggal_lahir)->age;
                            }
                        @endphp
                        {{ $usia ?? '-' }} tahun
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-size: 0.85rem; font-weight: 500;">{{ $item->imt ?? '-' }}</div>
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ $item->kategori_imt ?? '-' }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">
                        <div>{{ $item->sistolik }}/{{ $item->diastolik }}</div>
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ $item->kategori_tekanan ?? '-' }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($item->status_validasi == 'divalidasi')
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-check-circle" style="font-size: 0.6rem;"></i>
                                Divalidasi
                            </span>
                        @elseif($item->status_validasi == 'dibatalkan')
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-times-circle" style="font-size: 0.6rem;"></i>
                                Dibatalkan
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fef3c7; color: #92400e; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-clock" style="font-size: 0.6rem;"></i>
                                Menunggu
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <a href="{{ route('dokter.rekam-medis.show', $item->id) }}"
                           style="background: #004b23; color: white; padding: 0.3rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i class="fas fa-file-medical"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-folder-open" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Belum ada data rekam medis</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($rekamMedis->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="font-size: 0.75rem; color: #6b7280;">
            Menampilkan {{ $rekamMedis->firstItem() }} - {{ $rekamMedis->lastItem() }} dari {{ $rekamMedis->total() }} data
        </div>
        <div style="display: flex; gap: 0.25rem;">
            @if($rekamMedis->onFirstPage())
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&laquo;</span>
            @else
                <a href="{{ $rekamMedis->previousPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&laquo;</a>
            @endif

            @foreach($rekamMedis->getUrlRange(1, $rekamMedis->lastPage()) as $page => $url)
                @if($page == $rekamMedis->currentPage())
                    <span style="padding: 0.4rem 0.8rem; background: #004b23; color: white; border-radius: 6px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #374151; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach

            @if($rekamMedis->hasMorePages())
                <a href="{{ $rekamMedis->nextPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&raquo;</a>
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
        const rows = document.querySelectorAll('.rekam-row');

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const name = row.getAttribute('data-name');

            const matchStatus = currentFilter === 'all' || status === currentFilter;
            const matchSearch = searchTerm === '' || name.includes(searchTerm);

            if (matchStatus && matchSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection
