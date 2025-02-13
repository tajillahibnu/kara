<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PklPeriode extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'tahun_ajaran',
        'kuota_siswa',
        'batas_registrasi',
        'syarat_pendaftaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    /**
     * Cek apakah pendaftaran masih terbuka.
     */
    public function isRegistrationOpen(): bool
    {
        return $this->is_active && now()->lte($this->batas_registrasi);
    }

}
