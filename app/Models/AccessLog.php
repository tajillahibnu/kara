<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'method',
        'url',
        'ip',
        'user_agent',
        'status_code',
        'metadata',
        'request_body',
        'response_body',
    ];

    protected $casts = [
        'metadata' => 'array', // Agar otomatis diconvert ke array saat diambil
    ];
}
