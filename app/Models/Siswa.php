<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nis',
        'name',
        'tanggal_lahir',
        'jk',
        // 'rombel_id',
        'alamat',
        'telepon',
        'jurusan_id',
        'rombel_id',
        'tingkat_id',
        'romawi',
        'rombel_name',
        'email',
        'is_active',
        'is_pkl',
    ];

    protected static function booted()
    {
        static::saving(function ($siswa) {
            if ($siswa->isDirty('tingkat_id')) {
                $tingkat = Tingkat::findOrFail($siswa->tingkat_id);
                $siswa->romawi = $tingkat->romawi;
            }

            if ($siswa->isDirty('rombel_id')) {
                $siswa->rombel_name = null;
                if (!empty($siswa->rombel_id)) {
                    $rombel = Rombel::findOrFail($siswa->rombel_id);
                    $siswa->rombel_name = $rombel->name;
                }
            }
        });
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
