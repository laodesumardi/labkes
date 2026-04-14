@extends('layouts.app')

@section('title', 'Validasi Pemeriksaan')
@section('header', 'Validasi Hasil Pemeriksaan')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <!-- Header -->
    <div style="padding: 1.5rem 1.5rem 0 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Menunggu Validasi</h3>
                <p style="color: #6b7280; font-size: 0.8rem;">Daftar pemeriksaan yang perlu divalidasi oleh dokter</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.8rem;"></i>
                    <input type="text" id="searchInput" placeholder="Cari pasien..."
                           style="padding: 0.5rem 1rem 0.5rem 2.5rem; border: 1px solid #e5e7eb; border-radius: 10px; width: 250px; font-size: 0.8rem; outline: none;">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div style="padding: 1rem 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
        <div style="background: #fef3c7; padding: 0.5rem 1rem; border-radius: 10px;">
            <span style="font-size: 0.7rem; color: #92400e;">Total Menunggu</span>
            <span style="font-size: 1rem; font-weight: 700; color: #92400e; margin-left: 0.5rem;">{{ $menungguValidasi->total() }}</span>
        </div>
    </div>

    <!-- Tabel Pemeriksaan yang Menunggu Validasi -->
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
                    <th style="padding: 1rem 1.5rem;">Petugas Lab</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="validasiTableBody">
                @forelse($menungguValidasi as $index => $item)
                <tr class="validasi-row" data-name="{{ strtolower($item->user->nama_lengkap ?? '') }}">
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">{{ $loop->iteration + ($menungguValidasi->currentPage() - 1) * $menungguValidasi->perPage() }}</td>
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
                    <td style="padding: 1rem 1.5rem; font-size: 0.85rem;">
                        {{ $item->petugas->nama_lengkap ?? '-' }}
                        <div style="font-size: 0.7rem; color: #6b7280;">{{ $item->petugas->nip ?? '-' }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <button onclick="openValidasiModal({{ $item->id }}, '{{ addslashes($item->user->nama_lengkap ?? '') }}')"
                                    style="background: #004b23; color: white; padding: 0.4rem 1rem; border: none; border-radius: 6px; cursor: pointer; font-size: 0.7rem;">
                                <i class="fas fa-check-circle"></i> Validasi
                            </button>
                            <a href="{{ route('dokter.pemeriksaan.show', $item->id) }}"
                               style="background: #6b7280; color: white; padding: 0.4rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem; display: block;"></i>
                        <p style="color: #6b7280;">Semua pemeriksaan sudah divalidasi</p>
                        <p style="color: #9ca3af; font-size: 0.8rem; margin-top: 0.5rem;">Tidak ada pemeriksaan yang menunggu validasi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($menungguValidasi->hasPages())
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="font-size: 0.75rem; color: #6b7280;">
            Menampilkan {{ $menungguValidasi->firstItem() }} - {{ $menungguValidasi->lastItem() }} dari {{ $menungguValidasi->total() }} data
        </div>
        <div style="display: flex; gap: 0.25rem;">
            @if($menungguValidasi->onFirstPage())
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&laquo;</span>
            @else
                <a href="{{ $menungguValidasi->previousPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&laquo;</a>
            @endif

            @foreach($menungguValidasi->getUrlRange(1, $menungguValidasi->lastPage()) as $page => $url)
                @if($page == $menungguValidasi->currentPage())
                    <span style="padding: 0.4rem 0.8rem; background: #004b23; color: white; border-radius: 6px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #374151; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach

            @if($menungguValidasi->hasMorePages())
                <a href="{{ $menungguValidasi->nextPageUrl() }}" style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #004b23; text-decoration: none;">&raquo;</a>
            @else
                <span style="padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; border-radius: 6px; color: #9ca3af; background: #f9fafb;">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Modal Validasi -->
<div id="validasiModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; max-width: 500px; width: 90%; padding: 1.5rem;">
        <div style="text-align: center; margin-bottom: 1rem;">
            <div style="width: 60px; height: 60px; background: #e8f3ec; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-stethoscope" style="color: #004b23; font-size: 1.5rem;"></i>
            </div>
        </div>

        <h3 style="text-align: center; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">Validasi Pemeriksaan</h3>
        <p style="text-align: center; font-size: 0.85rem; color: #6b7280; margin-bottom: 1.5rem;">
            Apakah Anda yakin ingin memvalidasi pemeriksaan untuk pasien <strong id="modalPasienName"></strong>?
        </p>

        <form id="validasiForm" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                    Catatan (Opsional)
                </label>
                <textarea name="catatan" id="modalCatatan" rows="3" style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.8rem; outline: none;" placeholder="Tambahkan catatan medis..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: center;">
                <button type="button" onclick="closeModal()"
                        style="padding: 0.5rem 1.5rem; border: 1px solid #e5e7eb; border-radius: 10px; background: white; cursor: pointer;">
                    Batal
                </button>
                <button type="submit"
                        style="padding: 0.5rem 1.5rem; background: #004b23; color: white; border: none; border-radius: 10px; cursor: pointer;">
                    Ya, Validasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Gunakan data attribute untuk menyimpan URL pattern
    const validateUrl = "{{ route('dokter.validasi.validate', ['id' => '__ID__']) }}";
    let currentId = null;

    function openValidasiModal(id, nama) {
        currentId = id;
        document.getElementById('modalPasienName').innerText = nama;
        // Ganti placeholder __ID__ dengan id yang sebenarnya
        const actionUrl = validateUrl.replace('__ID__', id);
        document.getElementById('validasiForm').action = actionUrl;
        document.getElementById('modalCatatan').value = '';
        document.getElementById('validasiModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('validasiModal').style.display = 'none';
        currentId = null;
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.validasi-row');

        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            if (searchTerm === '' || name.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Close modal when clicking outside
    document.getElementById('validasiModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>

<style>
    .validasi-row:hover {
        background: #f9fafb;
    }
</style>
@endsection
