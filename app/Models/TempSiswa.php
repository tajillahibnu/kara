<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempSiswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'upload_siswa_id',
        'nama',
        'nis',
        'jurusan_id',
        'status',
        'rombel_id',
        'tingkat_id',
        'rombel_name',
        'romawi',
        'status',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
