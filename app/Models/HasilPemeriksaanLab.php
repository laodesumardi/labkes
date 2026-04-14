<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPemeriksaanLab extends Model
{
    protected $table = 'hasil_pemeriksaan_lab';

    protected $fillable = [
        'pemeriksaan_id',
        'parameter_id',
        'nilai',
        'catatan'
    ];

    // Relationships
    public function pemeriksaan()
    {
        return $this->belongsTo(PemeriksaanMaster::class, 'pemeriksaan_id');
    }

    public function parameter()
    {
        return $this->belongsTo(ParameterLab::class, 'parameter_id');
    }

    // Accessor for status (Normal/Tinggi/Rendah)
    public function getStatusAttribute()
    {
        $param = $this->parameter;
        if (!$param->nilai_normal_min || !$param->nilai_normal_max) {
            return 'Tidak dinilai';
        }

        if ($this->nilai < $param->nilai_normal_min) return 'Rendah';
        if ($this->nilai > $param->nilai_normal_max) return 'Tinggi';
        return 'Normal';
    }
}
