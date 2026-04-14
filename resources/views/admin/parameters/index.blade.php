@extends('layouts.app')

@section('title', 'Parameter Laboratorium')
@section('header', 'Parameter Pemeriksaan Lab')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <!-- Header -->
    <div style="padding: 1.5rem 1.5rem 0 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <p style="color: #6b7280; font-size: 0.8rem; margin-top: 0.25rem;">
                Kelola parameter pemeriksaan laboratorium
            </p>
        </div>
        <a href="{{ route('admin.parameters.create') }}"
           style="background: #004b23; color: white; padding: 0.6rem 1.25rem; border-radius: 10px; font-size: 0.85rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
            <i class="fas fa-plus"></i>
            <span>Tambah Parameter</span>
        </a>
    </div>

    <!-- Filter Kategori -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <button onclick="filterCategory('all')" class="filter-cat active" data-cat="all"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                Semua
            </button>
            <button onclick="filterCategory('kimia_darah')" class="filter-cat" data-cat="kimia_darah"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-tint"></i> Kimia Darah
            </button>
            <button onclick="filterCategory('urin')" class="filter-cat" data-cat="urin"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-fill-drip"></i> Urinalisis
            </button>
            <button onclick="filterCategory('serologi')" class="filter-cat" data-cat="serologi"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-syringe"></i> Serologi
            </button>
            <button onclick="filterCategory('narkoba')" class="filter-cat" data-cat="narkoba"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-capsules"></i> Narkoba
            </button>
            <button onclick="filterCategory('lainnya')" class="filter-cat" data-cat="lainnya"
                    style="padding: 0.4rem 1rem; border-radius: 20px; border: 1px solid #e5e7eb; background: white; font-size: 0.75rem; cursor: pointer;">
                <i class="fas fa-ellipsis-h"></i> Lainnya
            </button>
        </div>

        <div style="position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem;"></i>
            <input type="text" id="searchInput" placeholder="Cari parameter..."
                   style="padding: 0.5rem 1rem 0.5rem 2.5rem; border: 1px solid #e5e7eb; border-radius: 10px; width: 250px; font-size: 0.8rem; outline: none;">
        </div>
    </div>

    <!-- Tabel Parameter -->
    <div style="overflow-x: auto;">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem 1.5rem;">No</th>
                    <th style="padding: 1rem 1.5rem;">Kode</th>
                    <th style="padding: 1rem 1.5rem;">Nama Parameter</th>
                    <th style="padding: 1rem 1.5rem;">Kategori</th>
                    <th style="padding: 1rem 1.5rem;">Satuan</th>
                    <th style="padding: 1rem 1.5rem;">Nilai Normal</th>
                    <th style="padding: 1rem 1.5rem;">Status</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="parameterTableBody">
                @forelse($parameters as $index => $param)
                <tr class="parameter-row" data-category="{{ $param->kategori }}" data-name="{{ strtolower($param->nama_param) }}" data-kode="{{ strtolower($param->kode_param) }}">
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $loop->iteration + ($parameters->currentPage() - 1) * $parameters->perPage() }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem; font-family: monospace;">{{ $param->kode_param }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem; font-weight: 500;">{{ $param->nama_param }}</td>
                    <td style="padding: 1rem 1.5rem;">
                        @php
                            $categoryLabels = [
                                'kimia_darah' => ['label' => 'Kimia Darah', 'color' => '#004b23', 'bg' => '#e8f3ec'],
                                'urin' => ['label' => 'Urinalisis', 'color' => '#1e40af', 'bg' => '#e0e7ff'],
                                'serologi' => ['label' => 'Serologi', 'color' => '#9a3412', 'bg' => '#ffedd5'],
                                'narkoba' => ['label' => 'Narkoba', 'color' => '#86198f', 'bg' => '#fae8ff'],
                                'lainnya' => ['label' => 'Lainnya', 'color' => '#4b5563', 'bg' => '#f3f4f6']
                            ];
                            $cat = $categoryLabels[$param->kategori] ?? ['label' => ucfirst($param->kategori), 'color' => '#4b5563', 'bg' => '#f3f4f6'];
                        @endphp
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 500; background: {{ $cat['bg'] }}; color: {{ $cat['color'] }};">
                            {{ $cat['label'] }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $param->satuan ?? '-' }}</td>
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">
                        @if($param->nilai_normal_min && $param->nilai_normal_max)
                            {{ $param->nilai_normal_min }} - {{ $param->nilai_normal_max }}
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        @if($param->is_active)
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
                            <a href="{{ route('admin.parameters.edit', $param) }}"
                               style="background: none; border: none; color: #004b23; cursor: pointer; font-size: 1rem; padding: 0.25rem; text-decoration: none;"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.parameters.destroy', $param) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 1rem; padding: 0.25rem;"
                                        title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-microscope" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Belum ada data parameter</p>
                        <a href="{{ route('admin.parameters.create') }}" style="color: #004b23; margin-top: 0.5rem; display: inline-block;">Tambah parameter pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($parameters->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="font-size: 0.75rem; color: #6b7280;">
            Menampilkan {{ $parameters->firstItem() }} - {{ $parameters->lastItem() }} dari {{ $parameters->total() }} data
        </div>
        <div style="display: flex; gap: 0.25rem;">
            @if($parameters->onFirstPage())
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&laquo;</span>
            @else
                <a href="{{ $parameters->previousPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&laquo;</a>
            @endif

            @foreach($parameters->getUrlRange(1, $parameters->lastPage()) as $page => $url)
                @if($page == $parameters->currentPage())
                    <span style="padding: 0.4rem 0.8rem; background: #004b23; color: white; border-radius: 6px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #374151; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach

            @if($parameters->hasMorePages())
                <a href="{{ $parameters->nextPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&raquo;</a>
            @else
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
    .filter-cat.active {
        background: #004b23 !important;
        color: white !important;
        border-color: #004b23 !important;
    }

    .filter-cat:hover:not(.active) {
        background: #f3f4f6;
        border-color: #d1d5db;
    }
</style>

<script>
    let currentCategory = 'all';

    function filterCategory(category) {
        currentCategory = category;

        document.querySelectorAll('.filter-cat').forEach(btn => {
            btn.classList.remove('active');
            if(btn.getAttribute('data-cat') === category) {
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
        const rows = document.querySelectorAll('.parameter-row');

        rows.forEach(row => {
            const category = row.getAttribute('data-category');
            const name = row.getAttribute('data-name');
            const kode = row.getAttribute('data-kode');

            const matchCategory = currentCategory === 'all' || category === currentCategory;
            const matchSearch = searchTerm === '' || name.includes(searchTerm) || kode.includes(searchTerm);

            if (matchCategory && matchSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function confirmDelete(event) {
        if(!confirm('Yakin ingin menghapus parameter ini? Tindakan ini tidak dapat dibatalkan.')) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
@endsection
