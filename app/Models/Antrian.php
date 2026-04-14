<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'user_id',
        'nomor_antrian',
        'jenis_pemeriksaan',
        'status',
        'waktu_masuk',
        'waktu_proses',
        'waktu_selesai'
    ];

    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_proses' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
