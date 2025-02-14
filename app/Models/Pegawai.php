<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nip',
        'name',
        'jk',
        'jabatan',
        'departemen',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'email',
        'user_id',
        'is_active',
    ];
}
