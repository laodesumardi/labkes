<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterLab extends Model
{
    protected $table = 'parameter_lab';

    protected $fillable = [
        'kode_param',
        'nama_param',
        'satuan',
        'nilai_normal_min',
        'nilai_normal_max',
        'kategori',
        'is_active'
    ];

    public function hasilPemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaanLab::class, 'parameter_id');
    }
}
