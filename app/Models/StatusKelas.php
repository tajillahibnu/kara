<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 
        'nama', 
        'keterangan'
    ];

}
