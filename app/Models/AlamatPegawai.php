<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlamatPegawai extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id'; // Ganti dengan nama kolom primary key Anda
    public $incrementing = true; // Jika primary key adalah auto-increment
    protected $keyType = 'int'; // Tipe data primary key

    protected $fillable = [
        'pegawai_id',
        'label',
        'alamat',
        'kecamatan',
        'kota',
        'provinsi',
        'desa',
        'kode_pos',
        'is_default',
    ];

    // Relasi ke Model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
