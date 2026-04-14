<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PemeriksaanMaster extends Model
{
    protected $table = 'pemeriksaan_master';

    protected $fillable = [
        'user_id',
        'petugas_id',
        'dokter_id',
        'tanggal_pemeriksaan',
        'tinggi_cm',
        'berat_kg',
        'lingkar_perut_cm',
        'sistolik',
        'diastolik',
        'status_validasi',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'datetime',
        'tinggi_cm' => 'float',
        'berat_kg' => 'float',
        'lingkar_perut_cm' => 'float',
        'sistolik' => 'integer',
        'diastolik' => 'integer',
        'petugas_id' => 'integer',
        'dokter_id' => 'integer',
        'user_id' => 'integer',
    ];

    // Accessor for IMT
    public function getImtAttribute()
    {
        if ($this->tinggi_cm && $this->berat_kg && $this->tinggi_cm > 0) {
            try {
                $tinggi_m = $this->tinggi_cm / 100;
                return round($this->berat_kg / ($tinggi_m * $tinggi_m), 2);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    // Accessor for Kategori IMT
    public function getKategoriImtAttribute()
    {
        $imt = $this->imt;
        if (!$imt) return 'Tidak diketahui';

        if ($imt < 18.5) return 'Kurus';
        if ($imt >= 18.5 && $imt <= 24.9) return 'Normal';
        if ($imt >= 25 && $imt <= 29.9) return 'Overweight';
        return 'Obesitas';
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function hasilPemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaanLab::class, 'pemeriksaan_id');
    }

    public function getTekananDarahAttribute()
    {
        if ($this->sistolik && $this->diastolik) {
            $kategori = $this->getKategoriTekananAttribute();
            return "{$this->sistolik}/{$this->diastolik} ({$kategori})";
        }
        return 'Tidak diukur';
    }

    public function getKategoriTekananAttribute()
    {
        if (!$this->sistolik || !$this->diastolik) return 'Tidak diketahui';

        if ($this->sistolik < 120 && $this->diastolik < 80) return 'Normal';
        if ($this->sistolik >= 120 && $this->sistolik <= 139 && $this->diastolik <= 89) return 'Prehipertensi';
        if ($this->sistolik >= 140 && $this->sistolik <= 159 && $this->diastolik <= 99) return 'Hipertensi 1';
        if ($this->sistolik >= 160 && $this->diastolik <= 100) return 'Hipertensi 2';

        return 'Krisis Hipertensi';
    }
}
