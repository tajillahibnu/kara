<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Jurusan extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'kode',
        'name',
        'deskripsi',
        'bidang_keahlian',
        'program_keahlian',
        'is_active',
    ];

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
