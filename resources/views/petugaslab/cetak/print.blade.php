<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemeriksaan - {{ $pemeriksaan->user->nama_lengkap ?? '-' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        .print-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #004b23;
        }

        .header h1 {
            color: #004b23;
            margin: 0;
            font-size: 18pt;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            background: #f9fafb;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            width: 120px;
            font-weight: bold;
        }

        .info-value {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10pt;
        }

        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }

        .btn-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #004b23;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12pt;
        }

        .btn-print:hover {
            background: #003518;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">🖨️ Cetak / Print</button>

    <div class="print-container">
        <div class="header">
            <h1>HASIL PEMERIKSAAN LABORATORIUM</h1>
            <p>{{ \App\Models\Setting::get('app_name', 'Laboratorium Kesehatan') }}</p>
            <p>Jl. Kesehatan No. 123, Telp. (021) 1234567</p>
        </div>

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

        <h3 style="color: #004b23;">Data Pemeriksaan Fisik</h3>
        <table>
            <tr>
                <th style="width: 50%;">Parameter</th>
                <th style="width: 50%;">Hasil</th>
            </tr>
            <tr>
                <td>Tinggi Badan</td>
                <td>{{ $pemeriksaan->tinggi_cm ?? '-' }} cm</td>
            </tr>
            <tr>
                <td>Berat Badan</td>
                <td>{{ $pemeriksaan->berat_kg ?? '-' }} kg</td>
            </tr>
            <tr>
                <td>IMT (Indeks Massa Tubuh)</td>
                <td>{{ $pemeriksaan->imt ?? '-' }} ({{ $pemeriksaan->kategori_imt ?? '-' }})</td>
            </tr>
            <tr>
                <td>Lingkar Perut</td>
                <td>{{ $pemeriksaan->lingkar_perut_cm ?? '-' }} cm</td>
            </tr>
            <tr>
                <td>Tekanan Darah</td>
                <td>{{ $pemeriksaan->sistolik }}/{{ $pemeriksaan->diastolik }} mmHg</td>
            </tr>
        </table>

        @if($pemeriksaan->hasilPemeriksaan && $pemeriksaan->hasilPemeriksaan->count() > 0)
        <h3 style="color: #004b23;">Hasil Pemeriksaan Laboratorium</h3>
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
                <tr>
                    <td>{{ $hasil->parameter->nama_param ?? '-' }}</td>
                    <td><strong>{{ $hasil->nilai }}</strong></td>
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

        @if($pemeriksaan->catatan)
        <h3 style="color: #004b23;">Catatan Medis</h3>
        <div style="background: #f9fafb; padding: 10px; margin-bottom: 20px;">
            <p>{{ $pemeriksaan->catatan }}</p>
        </div>
        @endif

        <div class="signature">
            <div class="signature-box">
                <p>Dokter Pemeriksa,</p>
                <br><br><br>
                <p><strong>{{ $pemeriksaan->dokter->nama_lengkap ?? '_________________' }}</strong></p>
                <p>NIP. {{ $pemeriksaan->dokter->nip ?? '-' }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Hasil pemeriksaan ini telah divalidasi secara digital</p>
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        // Auto print jika diperlukan
        // setTimeout(() => window.print(), 500);
    </script>
</body>
</html>
