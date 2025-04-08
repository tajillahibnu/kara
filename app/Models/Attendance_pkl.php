<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_pkl extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'dudi_id',
        'periode_id',
        'tanggal',
        'clock_in',
        'clock_out',
        'clock_in_real',
        'clock_out_real',
        'status',
        'tahun_pelajaran',
        'durasi',
        'durasi_real',
        'note'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function dudis()
    {
        return $this->hasMany(Dudi::class, 'dudi_id');
    }
}
