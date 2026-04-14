@extends('layouts.app')

@section('title', 'Input Hasil Lab')
@section('header', 'Input Hasil Pemeriksaan Laboratorium')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('petugas_lab.hasil-lab.update', $pemeriksaan->id) }}">
        @csrf
        @method('PUT')

        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-user" style="color: #004b23; margin-right: 0.5rem;"></i>
                Informasi Pasien
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div><p style="font-size: 0.7rem; color: #6b7280;">Nama</p><p><strong>{{ $pemeriksaan->user->nama_lengkap ?? '-' }}</strong></p></div>
                <div><p style="font-size: 0.7rem; color: #6b7280;">NIP</p><p>{{ $pemeriksaan->user->nip ?? '-' }}</p></div>
                <div><p style="font-size: 0.7rem; color: #6b7280;">Tanggal</p><p>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</p></div>
            </div>
        </div>

        <div class="stat-card">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-flask" style="color: #004b23; margin-right: 0.5rem;"></i>
                Hasil Laboratorium
            </h3>

            @php $groupedParams = $parameters->groupBy('kategori'); $existingHasil = $pemeriksaan->hasilPemeriksaan->keyBy('parameter_id'); @endphp

            @foreach($groupedParams as $kategori => $params)
            <div style="margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.75rem; color: #004b23;">
                    {{ ucfirst(str_replace('_', ' ', $kategori)) }}
                </h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 0.75rem;">
                    @foreach($params as $param)
                    @php $nilai = $existingHasil->get($param->id)->nilai ?? ''; @endphp
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 500;">{{ $param->nama_param }} @if($param->satuan)<span style="color: #6b7280;">({{ $param->satuan }})</span>@endif</label>
                        <input type="text" name="hasil[{{ $param->id }}]" value="{{ $nilai }}" style="width: 100%; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 6px;">
                        @if($param->nilai_normal_min && $param->nilai_normal_max)
                        <p style="font-size: 0.6rem; color: #6b7280;">Normal: {{ $param->nilai_normal_min }} - {{ $param->nilai_normal_max }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
            <a href="{{ route('petugas_lab.pemeriksaan.index') }}" style="padding: 0.6rem 1.5rem; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none;">Batal</a>
            <button type="submit" style="background: #004b23; color: white; padding: 0.6rem 1.5rem; border: none; border-radius: 8px;">Simpan Hasil Lab</button>
        </div>
    </form>
</div>
@endsection
