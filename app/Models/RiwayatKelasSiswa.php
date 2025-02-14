<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKelasSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'status_kelas_id',
        'rombel_id',
        'tahun_ajaran',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function statusKelas()
    {
        return $this->belongsTo(StatusKelas::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Rombel::class);
    }

}
