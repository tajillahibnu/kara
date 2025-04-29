<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PklPriodeInduka extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'priode_id',
        'jurusan_id',
        'dudi_id',
        'lokasi',
        'kuota',
    ];

    public function priode()
    {
        return $this->belongsTo(PklPeriode::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }

}
