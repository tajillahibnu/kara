<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload_siswa extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'filename', 'original_name', 'file_type', 'file_size', 'row_count',
        'url', 'status', 'errors', 'processing_started_at', 'processing_completed_at','path','jurusan_id'
    ];

    protected $dates = ['processing_started_at', 'processing_completed_at'];

}
