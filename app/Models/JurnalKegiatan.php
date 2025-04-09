<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JurnalKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan',
        'durasi'
    ];

    // protected $dates = ['tanggal_mulai', 'tanggal_selesai'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relasi ke guru
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    // Mutator opsional untuk format tanggal
    public function getTanggalRangeAttribute()
    {
        if ($this->tanggal_mulai->equalTo($this->tanggal_selesai)) {
            return $this->tanggal_mulai->format('d M Y');
        }
        return $this->tanggal_mulai->format('d M Y') . ' - ' . $this->tanggal_selesai->format('d M Y');
    }

    public function getDurasiTextAttribute()
    {
        if (!$this->durasi) return '-';
        return $this->durasi . ' jam';
    }
}
