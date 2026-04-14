@extends('layouts.app')

@section('title', 'Detail Pemeriksaan')
@section('header', 'Detail Pemeriksaan Pasien')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Informasi Pasien -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-user" style="color: #004b23; margin-right: 0.5rem;"></i>
            Informasi Pasien
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Nama Lengkap</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ $pemeriksaan->user->nama_lengkap ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">NIP</p>
                <p style="font-size: 0.9rem; font-family: monospace;">{{ $pemeriksaan->user->nip ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Jenis Kelamin</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->user->jenis_kelamin ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tanggal Lahir</p>
                <p style="font-size: 0.9rem;">
                    @if($pemeriksaan->user->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($pemeriksaan->user->tanggal_lahir)->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($pemeriksaan->user->tanggal_lahir)->age }} tahun)
                    @else
                        -
                    @endif
                </p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">No. Telepon</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->user->no_telepon ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Alamat</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->user->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Data Pemeriksaan Fisik -->
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-stethoscope" style="color: #004b23; margin-right: 0.5rem;"></i>
            Data Pemeriksaan Fisik
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tanggal Pemeriksaan</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Petugas Lab</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->petugas->nama_lengkap ?? '-' }}</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tinggi Badan</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->tinggi_cm ?? '-' }} cm</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Berat Badan</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->berat_kg ?? '-' }} kg</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Lingkar Perut</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->lingkar_perut_cm ?? '-' }} cm</p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">IMT (Indeks Massa Tubuh)</p>
                <p style="font-size: 0.9rem; font-weight: 500;">{{ $pemeriksaan->imt ?? '-' }}
                    @if($pemeriksaan->kategori_imt)
                        <span style="font-size: 0.7rem; color: #6b7280;">({{ $pemeriksaan->kategori_imt }})</span>
                    @endif
                </p>
            </div>
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Tekanan Darah</p>
                <p style="font-size: 0.9rem;">{{ $pemeriksaan->sistolik }}/{{ $pemeriksaan->diastolik }} mmHg</p>
                <p style="font-size: 0.7rem; color: #6b7280;">{{ $pemeriksaan->kategori_tekanan ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Hasil Laboratorium -->
    @if($pemeriksaan->hasilPemeriksaan && $pemeriksaan->hasilPemeriksaan->count() > 0)
    <div class="stat-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-flask" style="color: #004b23; margin-right: 0.5rem;"></i>
            Hasil Pemeriksaan Laboratorium
        </h3>

        <div style="overflow-x: auto;">
            <table class="data-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="padding: 0.75rem;">Parameter</th>
                        <th style="padding: 0.75rem;">Hasil</th>
                        <th style="padding: 0.75rem;">Satuan</th>
                        <th style="padding: 0.75rem;">Nilai Normal</th>
                        <th style="padding: 0.75rem;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemeriksaan->hasilPemeriksaan as $hasil)
                    @php
                        $status = $hasil->status;
                        $statusColor = $status == 'Normal' ? '#10b981' : ($status == 'Tinggi' ? '#ef4444' : '#f59e0b');
                        $statusBg = $status == 'Normal' ? '#dcfce7' : ($status == 'Tinggi' ? '#fee2e2' : '#fef3c7');
                    @endphp
                    <tr>
                        <td style="padding: 0.75rem; font-weight: 500;">{{ $hasil->parameter->nama_param ?? '-' }}</td>
                        <td style="padding: 0.75rem; font-weight: 500;">{{ $hasil->nilai }}</td>
                        <td style="padding: 0.75rem;">{{ $hasil->parameter->satuan ?? '-' }}</td>
                        <td style="padding: 0.75rem;">
                            @if($hasil->parameter->nilai_normal_min && $hasil->parameter->nilai_normal_max)
                                {{ $hasil->parameter->nilai_normal_min }} - {{ $hasil->parameter->nilai_normal_max }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.7rem; background: {{ $statusBg }}; color: {{ $statusColor }};">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Catatan Medis -->
    <div class="stat-card">
        <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
            <i class="fas fa-notes-medical" style="color: #004b23; margin-right: 0.5rem;"></i>
            Catatan Medis
        </h3>

        <div style="margin-bottom: 1rem;">
            <p style="font-size: 0.7rem; color: #6b7280; margin-bottom: 0.25rem;">Catatan dari Petugas Lab</p>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 12px;">
                <p style="font-size: 0.85rem;">{{ $pemeriksaan->catatan ?? 'Tidak ada catatan' }}</p>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
            <div>
                <p style="font-size: 0.7rem; color: #6b7280;">Status Validasi</p>
                @if($pemeriksaan->status_validasi == 'divalidasi')
                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 20px; font-size: 0.7rem;">
                        <i class="fas fa-check-circle"></i>
                        Telah Divalidasi oleh Dr. {{ $pemeriksaan->dokter->nama_lengkap ?? 'Dokter' }}
                    </span>
                @elseif($pemeriksaan->status_validasi == 'dibatalkan')
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
            </div>

            <div style="display: flex; gap: 0.5rem;">
                @if($pemeriksaan->status_validasi == 'draft')
                    <button onclick="openValidasiModal({{ $pemeriksaan->id }}, '{{ $pemeriksaan->user->nama_lengkap ?? '' }}')"
                            style="background: #004b23; color: white; padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-check-circle"></i> Validasi
                    </button>
                @endif
                <a href="{{ route('dokter.pemeriksaan.index') }}"
                   style="background: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
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
    const validateUrl = "{{ route('dokter.validasi.validate', ['id' => '__ID__']) }}";
    let currentId = null;

    function openValidasiModal(id, nama) {
        currentId = id;
        document.getElementById('modalPasienName').innerText = nama;
        const actionUrl = validateUrl.replace('__ID__', id);
        document.getElementById('validasiForm').action = actionUrl;
        document.getElementById('modalCatatan').value = '';
        document.getElementById('validasiModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('validasiModal').style.display = 'none';
        currentId = null;
    }

    document.getElementById('validasiModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection
