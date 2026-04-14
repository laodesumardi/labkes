<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Pastikan primary key adalah 'id' (default Laravel)
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'tanggal_lahir' => 'date',
        'is_active' => 'boolean',
        'id' => 'integer',
    ];

    // HAPUS method ini jika ada - ini menyebabkan auth()->id() mengembalikan NIP
    // public function getAuthIdentifierName()
    // {
    //     return 'nip';
    // }

    // Accessor untuk usia
    public function getUsiaAttribute()
    {
        if ($this->tanggal_lahir) {
            try {
                return $this->tanggal_lahir->age;
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    // Role check methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDokter()
    {
        return $this->role === 'dokter';
    }

    public function isPetugasLab()
    {
        return $this->role === 'petugas_lab';
    }

    public function isPasien()
    {
        return $this->role === 'pasien';
    }

    // Relationships
    public function pemeriksaans()
    {
        return $this->hasMany(PemeriksaanMaster::class, 'user_id');
    }

    public function antrians()
    {
        return $this->hasMany(Antrian::class);
    }

    public function logs()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}
