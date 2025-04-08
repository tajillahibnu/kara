<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kakomli_id',
        'kode',
        'name',
        'deskripsi',
        'bidang_keahlian',
        'program_keahlian',
        'is_active',
    ];

    // Definisikan relasi ke model Siswa
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'jurusan_id'); // 'jurusan_id' adalah nama kolom di tabel siswa
    }

    // Definisikan relasi satu ke satu dengan Pegawai
    public function kakomli()
    {
        return $this->belongsTo(Pegawai::class, 'kakomli_id');
    }



    protected static function boot()
    {
        parent::boot();

        static::updated(function ($jurusan) {
            Cache::forget("jurusan_{$jurusan->id}");
        });

        static::deleted(function ($jurusan) {
            Cache::forget("jurusan_{$jurusan->id}");
        });
    }
}
