@extends('layouts.app')

@section('title', 'Manajemen User')
@section('header', 'Kelola Pengguna')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <!-- Header dengan aksi -->
    <div style="padding: 1.5rem 1.5rem 0 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <p style="color: #6b7280; font-size: 0.8rem; margin-top: 0.25rem;">
                Kelola data pengguna sistem laboratorium
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           style="background: #004b23; color: white; padding: 0.6rem 1.25rem; border-radius: 10px; font-size: 0.85rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: all 0.2s;">
            <i class="fas fa-plus"></i>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Filter dan Search -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <button onclick="filterRole('all')" class="filter-btn active" data-filter="all"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer; transition: all 0.2s;">
                Semua
            </button>
            <button onclick="filterRole('admin')" class="filter-btn" data-filter="admin"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Admin
            </button>
            <button onclick="filterRole('dokter')" class="filter-btn" data-filter="dokter"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Dokter
            </button>
            <button onclick="filterRole('petugas_lab')" class="filter-btn" data-filter="petugas_lab"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Petugas Lab
            </button>
            <button onclick="filterRole('pasien')" class="filter-btn" data-filter="pasien"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Pasien
            </button>
        </div>

        <div style="position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem;"></i>
            <input type="text" id="searchInput" placeholder="Cari nama atau NIP..."
                   style="padding: 0.5rem 1rem 0.5rem 2.5rem; border: 1px solid #e5e7eb; border-radius: 10px; width: 250px; font-size: 0.8rem; outline: none;">
        </div>
    </div>

    <!-- Tabel User -->
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem 1.5rem;">No</th>
                    <th style="padding: 1rem 1.5rem;">NIP</th>
                    <th style="padding: 1rem 1.5rem;">Nama Lengkap</th>
                    <th style="padding: 1rem 1.5rem;">Email</th>
                    <th style="padding: 1rem 1.5rem;">Role</th>
                    <th style="padding: 1rem 1.5rem;">No. Telepon</th>
                    <th style="padding: 1rem 1.5rem;">Status</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                @forelse($users as $index => $user)
                <tr class="user-row" data-role="{{ $user->role }}" data-name="{{ strtolower($user->nama_lengkap) }}" data-nip="{{ $user->nip }}">
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem; font-family: monospace;">{{ $user->nip }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem; font-weight: 500;">{{ $user->nama_lengkap }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem; color: #6b7280;">{{ $user->email ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        @php
                            $roleColors = [
                                'admin' => ['bg' => '#004b23', 'color' => 'white'],
                                'dokter' => ['bg' => '#e8f3ec', 'color' => '#004b23'],
                                'petugas_lab' => ['bg' => '#fef3c7', 'color' => '#92400e'],
                                'pasien' => ['bg' => '#dcfce7', 'color' => '#166534']
                            ];
                            $color = $roleColors[$user->role] ?? ['bg' => '#f3f4f6', 'color' => '#374151'];
                        @endphp
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 500; background: {{ $color['bg'] }}; color: {{ $color['color'] }};">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $user->no_telepon ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($user->is_active)
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.2rem 0.5rem; background: #dcfce7; color: #166534; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i>
                                Aktif
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.2rem 0.5rem; background: #fee2e2; color: #991b1b; border-radius: 20px; font-size: 0.7rem;">
                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i>
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               style="background: none; border: none; color: #004b23; cursor: pointer; font-size: 1rem; padding: 0.25rem; transition: all 0.2s;"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 1rem; padding: 0.25rem; transition: all 0.2s;"
                                        title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-users" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Belum ada data pengguna</p>
                        <a href="{{ route('admin.users.create') }}" style="color: #004b23; margin-top: 0.5rem; display: inline-block;">Tambah pengguna pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="font-size: 0.75rem; color: #6b7280;">
            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
        </div>
        <div style="display: flex; gap: 0.25rem;">
            @if($users->onFirstPage())
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&laquo;</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&laquo;</a>
            @endif

            @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if($page == $users->currentPage())
                    <span style="padding: 0.4rem 0.8rem; background: #004b23; color: white; border-radius: 6px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #374151; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach

            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&raquo;</a>
            @else
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
    .filter-btn.active {
        background: #004b23 !important;
        color: white !important;
        border-color: #004b23 !important;
    }

    .filter-btn:hover:not(.active) {
        background: #f3f4f6;
        border-color: #d1d5db;
    }
</style>

<script>
    // Filter berdasarkan role
    let currentFilter = 'all';

    function filterRole(role) {
        currentFilter = role;

        // Update active button style
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            if(btn.getAttribute('data-filter') === role) {
                btn.classList.add('active');
            }
        });

        applyFilters();
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        applyFilters();
    });

    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');

        rows.forEach(row => {
            const role = row.getAttribute('data-role');
            const name = row.getAttribute('data-name');
            const nip = row.getAttribute('data-nip');

            const matchRole = currentFilter === 'all' || role === currentFilter;
            const matchSearch = searchTerm === '' || name.includes(searchTerm) || nip.includes(searchTerm);

            if (matchRole && matchSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function confirmDelete(event) {
        if(!confirm('Yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
@endsection
