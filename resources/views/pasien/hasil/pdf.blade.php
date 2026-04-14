<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemeriksaan - {{ $pemeriksaan->user->nama_lengkap ?? '-' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 3px solid #004b23;
        }

        .header h1 {
            color: #004b23;
            font-size: 18pt;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 10pt;
            margin: 3px 0;
        }

        /* Info Section */
        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            width: 130px;
            font-weight: bold;
        }

        .info-value {
            flex: 1;
        }

        /* Section Title */
        .section-title {
            background: #004b23;
            color: white;
            padding: 6px 10px;
            margin: 15px 0 10px 0;
            font-size: 12pt;
            font-weight: bold;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #e8f3ec;
            color: #004b23;
            font-weight: bold;
        }

        /* Physical data grid */
        .physical-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .physical-item {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .physical-label {
            font-size: 9pt;
            color: #666;
        }

        .physical-value {
            font-size: 12pt;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }

        /* Signature */
        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 100%;
        }

        /* Status Badge */
        .status-normal {
            color: #10b981;
            font-weight: bold;
        }

        .status-tinggi {
            color: #ef4444;
            font-weight: bold;
        }

        .status-rendah {
            color: #f59e0b;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>HASIL PEMERIKSAAN LABORATORIUM</h1>
            <p>{{ $appName }}</p>
            <p>Jl. Kesehatan No. 123, Telp. (021) 1234567</p>
        </div>

        <!-- Informasi Pasien -->
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Tanggal Pemeriksaan</div>
                <div class="info-value">: {{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Pasien</div>
                <div class="info-value">: {{ $pemeriksaan->user->nama_lengkap ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIP</div>
                <div class="info-value">: {{ $pemeriksaan->user->nip ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value">: {{ $pemeriksaan->user->jenis_kelamin ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Usia</div>
                <div class="info-value">:
                    @if($pemeriksaan->user->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($pemeriksaan->user->tanggal_lahir)->age }} tahun
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>

        <!-- Data Pemeriksaan Fisik -->
        <div class="section-title">DATA PEMERIKSAAN FISIK</div>
        <div class="physical-grid">
            <div class="physical-item">
                <div class="physical-label">Tinggi Badan</div>
                <div class="physical-value">{{ $pemeriksaan->tinggi_cm ?? '-' }} cm</div>
            </div>
            <div class="physical-item">
                <div class="physical-label">Berat Badan</div>
                <div class="physical-value">{{ $pemeriksaan->berat_kg ?? '-' }} kg</div>
            </div>
            <div class="physical-item">
                <div class="physical-label">Lingkar Perut</div>
                <div class="physical-value">{{ $pemeriksaan->lingkar_perut_cm ?? '-' }} cm</div>
            </div>
            <div class="physical-item">
                <div class="physical-label">IMT</div>
                <div class="physical-value">{{ $pemeriksaan->imt ?? '-' }} ({{ $pemeriksaan->kategori_imt ?? '-' }})</div>
            </div>
            <div class="physical-item">
                <div class="physical-label">Tekanan Darah</div>
                <div class="physical-value">{{ $pemeriksaan->sistolik }}/{{ $pemeriksaan->diastolik }} mmHg</div>
                <div style="font-size: 9pt; color: #666;">{{ $pemeriksaan->kategori_tekanan ?? '-' }}</div>
            </div>
        </div>

        <!-- Hasil Laboratorium -->
        @if($pemeriksaan->hasilPemeriksaan && $pemeriksaan->hasilPemeriksaan->count() > 0)
        <div class="section-title">HASIL PEMERIKSAAN LABORATORIUM</div>
        <table>
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Hasil</th>
                    <th>Satuan</th>
                    <th>Nilai Normal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemeriksaan->hasilPemeriksaan as $hasil)
                @php
                    $status = $hasil->status;
                    $statusClass = $status == 'Normal' ? 'status-normal' : ($status == 'Tinggi' ? 'status-tinggi' : 'status-rendah');
                @endphp
                <tr>
                    <td>{{ $hasil->parameter->nama_param ?? '-' }}</td>
                    <td class="{{ $statusClass }}">{{ $hasil->nilai }}</td>
                    <td>{{ $hasil->parameter->satuan ?? '-' }}</td>
                    <td>
                        @if($hasil->parameter->nilai_normal_min && $hasil->parameter->nilai_normal_max)
                            {{ $hasil->parameter->nilai_normal_min }} - {{ $hasil->parameter->nilai_normal_max }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Catatan Medis -->
        @if($pemeriksaan->catatan)
        <div class="section-title">CATATAN MEDIS</div>
        <div style="background: #f9fafb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <p>{{ $pemeriksaan->catatan }}</p>
        </div>
        @endif

        <!-- Tanda Tangan -->
        <div class="signature">
            <div class="signature-box">
                <p>Dokter Pemeriksa,</p>
                <div class="signature-line"></div>
                <p><strong>Dr. {{ $pemeriksaan->dokter->nama_lengkap ?? '_________________' }}</strong></p>
                <p>NIP. {{ $pemeriksaan->dokter->nip ?? '-' }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Hasil pemeriksaan ini telah divalidasi secara digital</p>
            <p>Dicetak pada: {{ $tanggal_cetak }}</p>
            <p>Dokumen ini adalah bukti sah hasil pemeriksaan</p>
        </div>
    </div>
</body>
</html>
