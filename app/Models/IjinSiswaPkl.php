<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IjinSiswaPkl extends Model
{
    protected $fillable = [
        'siswa_id',
        'dudi_id',
        'pegawai_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'lampiran',
        'status_pembimbing_instansi',
        'status_guru_pembimbing',
        'catatan_pembimbing',
        'catatan_guru',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
