@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('header', 'Riwayat Aktivitas Sistem')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <!-- Header -->
    <div style="padding: 1.5rem 1.5rem 0 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <p style="color: #6b7280; font-size: 0.8rem; margin-top: 0.25rem;">
                Mencatat semua aktivitas pengguna dalam sistem
            </p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button onclick="clearLogs()"
                    style="background: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 8px; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-trash-alt"></i> Hapus Semua
            </button>
            <button onclick="window.print()"
                    style="background: #6b7280; color: white; padding: 0.5rem 1rem; border: none; border-radius: 8px; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Filter dan Search -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <button onclick="filterDate('today')" class="filter-date active" data-filter="today"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Hari Ini
            </button>
            <button onclick="filterDate('week')" class="filter-date" data-filter="week"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Minggu Ini
            </button>
            <button onclick="filterDate('month')" class="filter-date" data-filter="month"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Bulan Ini
            </button>
            <button onclick="filterDate('all')" class="filter-date" data-filter="all"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Semua
            </button>
        </div>

        <div style="display: flex; gap: 0.5rem;">
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" placeholder="Cari aktivitas atau pengguna..."
                       style="padding: 0.5rem 1rem 0.5rem 2.5rem; border: 1px solid #e5e7eb; border-radius: 10px; width: 250px; font-size: 0.8rem; outline: none;">
            </div>
        </div>
    </div>

    <!-- Tabel Log -->
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem 1.5rem;">No</th>
                    <th style="padding: 1rem 1.5rem;">Waktu</th>
                    <th style="padding: 1rem 1.5rem;">Pengguna</th>
                    <th style="padding: 1rem 1.5rem;">Role</th>
                    <th style="padding: 1rem 1.5rem;">Aktivitas</th>
                    <th style="padding: 1rem 1.5rem;">IP Address</th>
                    <th style="padding: 1rem 1.5rem;">Device</th>
                </tr>
            </thead>
            <tbody id="logTableBody">
                @forelse($logs as $index => $log)
                <tr class="log-row" data-date="{{ $log->waktu->format('Y-m-d') }}">
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-size: 0.8rem; font-weight: 500;">{{ $log->waktu->format('H:i:s') }}</div>
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ $log->waktu->format('d/m/Y') }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 32px; height: 32px; background: #e8f3ec; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: #004b23; font-size: 0.8rem;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; font-weight: 500;">{{ $log->user->nama_lengkap ?? 'System' }}</div>
                                <div style="font-size: 0.7rem; color: #6b7280;">{{ $log->user->nip ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @php
                            $roleColors = [
                                'admin' => ['bg' => '#004b23', 'color' => 'white'],
                                'dokter' => ['bg' => '#e8f3ec', 'color' => '#004b23'],
                                'petugas_lab' => ['bg' => '#fef3c7', 'color' => '#92400e'],
                                'pasien' => ['bg' => '#dcfce7', 'color' => '#166534']
                            ];
                            $role = $log->user->role ?? 'system';
                            $color = $roleColors[$role] ?? ['bg' => '#f3f4f6', 'color' => '#374151'];
                        @endphp
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 500; background: {{ $color['bg'] }}; color: {{ $color['color'] }};">
                            {{ ucfirst(str_replace('_', ' ', $role)) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            @if(str_contains($log->aktivitas, 'Login'))
                                <i class="fas fa-sign-in-alt" style="color: #10b981;"></i>
                            @elseif(str_contains($log->aktivitas, 'Logout'))
                                <i class="fas fa-sign-out-alt" style="color: #6b7280;"></i>
                            @elseif(str_contains($log->aktivitas, 'tambah') || str_contains($log->aktivitas, 'Tambah'))
                                <i class="fas fa-plus-circle" style="color: #004b23;"></i>
                            @elseif(str_contains($log->aktivitas, 'update') || str_contains($log->aktivitas, 'Update'))
                                <i class="fas fa-edit" style="color: #f59e0b;"></i>
                            @elseif(str_contains($log->aktivitas, 'hapus') || str_contains($log->aktivitas, 'Hapus'))
                                <i class="fas fa-trash-alt" style="color: #ef4444;"></i>
                            @else
                                <i class="fas fa-info-circle" style="color: #3b82f6;"></i>
                            @endif
                            <span style="font-size: 0.85rem;">{{ $log->aktivitas }}</span>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <code style="font-size: 0.75rem; background: #f3f4f6; padding: 0.2rem 0.4rem; border-radius: 4px;">{{ $log->ip_address ?? '-' }}</code>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @php
                            $device = $log->user_agent;
                            $isMobile = str_contains($device, 'Mobile');
                            $browser = 'Unknown';
                            if (str_contains($device, 'Chrome')) $browser = 'Chrome';
                            elseif (str_contains($device, 'Firefox')) $browser = 'Firefox';
                            elseif (str_contains($device, 'Safari')) $browser = 'Safari';
                            elseif (str_contains($device, 'Edge')) $browser = 'Edge';
                        @endphp
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-{{ $isMobile ? 'mobile-alt' : 'desktop' }}" style="color: #6b7280;"></i>
                            <span style="font-size: 0.75rem;">{{ $browser }}</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-history" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Belum ada aktivitas yang tercatat</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="font-size: 0.75rem; color: #6b7280;">
            Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} log
        </div>
        <div style="display: flex; gap: 0.25rem;">
            @if($logs->onFirstPage())
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&laquo;</span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&laquo;</a>
            @endif

            @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                @if($page == $logs->currentPage())
                    <span style="padding: 0.4rem 0.8rem; background: #004b23; color: white; border-radius: 6px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #374151; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach

            @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&raquo;</a>
            @else
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; max-width: 400px; width: 90%; padding: 1.5rem;">
        <div style="text-align: center; margin-bottom: 1rem;">
            <div style="width: 48px; height: 48px; background: #fee2e2; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 1.5rem;"></i>
            </div>
        </div>
        <h3 style="text-align: center; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">Hapus Semua Log?</h3>
        <p style="text-align: center; font-size: 0.8rem; color: #6b7280; margin-bottom: 1.5rem;">
            Tindakan ini akan menghapus semua riwayat aktivitas dan tidak dapat dibatalkan.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button onclick="closeDeleteModal()"
                    style="padding: 0.5rem 1.5rem; border: 1px solid #e5e7eb; border-radius: 8px; background: white; cursor: pointer;">
                Batal
            </button>
            <form action="{{ route('admin.logs.clear') }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="padding: 0.5rem 1.5rem; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer;">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .filter-date.active {
        background: #004b23 !important;
        color: white !important;
        border-color: #004b23 !important;
    }

    .filter-date:hover:not(.active) {
        background: #f3f4f6;
        border-color: #d1d5db;
    }

    @media print {
        .sidebar, .top-navbar, .filter-section, button, form {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .stat-card {
            box-shadow: none !important;
        }
    }
</style>

<script>
    let currentFilter = 'today';

    function filterDate(filter) {
        currentFilter = filter;

        // Update active button style
        document.querySelectorAll('.filter-date').forEach(btn => {
            btn.classList.remove('active');
            if(btn.getAttribute('data-filter') === filter) {
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
        const rows = document.querySelectorAll('.log-row');
        const today = new Date().toISOString().split('T')[0];

        // Get date ranges
        let startDate = null;
        const now = new Date();

        if (currentFilter === 'today') {
            startDate = today;
        } else if (currentFilter === 'week') {
            const weekAgo = new Date(now);
            weekAgo.setDate(now.getDate() - 7);
            startDate = weekAgo.toISOString().split('T')[0];
        } else if (currentFilter === 'month') {
            const monthAgo = new Date(now);
            monthAgo.setMonth(now.getMonth() - 1);
            startDate = monthAgo.toISOString().split('T')[0];
        }

        rows.forEach(row => {
            const rowDate = row.getAttribute('data-date');
            const aktivitas = row.querySelector('td:nth-child(5) span')?.innerText.toLowerCase() || '';
            const user = row.querySelector('td:nth-child(3) div div:first-child')?.innerText.toLowerCase() || '';

            let matchDate = true;
            if (startDate && currentFilter !== 'all') {
                if (currentFilter === 'today') {
                    matchDate = rowDate === startDate;
                } else {
                    matchDate = rowDate >= startDate;
                }
            }

            const matchSearch = searchTerm === '' ||
                aktivitas.includes(searchTerm) ||
                user.includes(searchTerm);

            if (matchDate && matchSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function clearLogs() {
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Auto-refresh every 30 seconds
    setInterval(function() {
        location.reload();
    }, 30000);
</script>
@endsection
