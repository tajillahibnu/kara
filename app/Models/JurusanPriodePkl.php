<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JurusanPriodePkl extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'periode_id',
        'jurusan_id',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
