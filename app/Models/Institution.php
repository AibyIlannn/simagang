<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $table = 'institutions'; // nama tabel

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'telepon',
        'alamat',
        'deskripsi',
        'logo'
    ];

    /**
     * Relasi ke User (1 Institution dimiliki 1 User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Lowongan
     */
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'institusi_id');
    }

    /**
     * Relasi ke Pengajuan
     */
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'institusi_id');
    }

    /**
     * Relasi ke Laporan
     */
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'institusi_id');
    }
}

