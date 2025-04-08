<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_id',
        'siswa_id',
        'jurusan_id',
        'dudi_id',
        'guru_id',
        'registration_type',
        'status_register',
        'status_pelaksana',
        'tahun_pelajaran',
        'status_updated_at',
        'tingkat_id',
        'kelas',
        'guru_name',
        'guru_nip',
        'guru_hp',
        'jurusan_name',
        'pembina_name',
        'pembina_no',
        'pembina_jabatan',
        'pembina_hp',
        'pegawai_id',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public function periode()
    {
        return $this->belongsTo(PklPeriode::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // public function jurusan()
    // {
    //     return $this->belongsTo(Jurusan::class);
    // }

    // public function industri()
    // {
    //     return $this->belongsTo(Dudi::class);
    // }

    // public function pegawai()
    // {
    //     return $this->belongsTo(Pegawai::class);
    // }

    public function approvals()
    {
        return $this->hasMany(PklRegistrationStatuses::class, 'registration_id');
    }
}
