<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DudiChekInOut extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dudi_id',
        'shift',
        'day_number',
        'day_slug',
        'clock_in',
        'clock_out',
        'ramadhan_clock_in',
        'ramadhan_clock_out'
    ];

    public function location()
    {
        return $this->belongsTo(Dudi::class, 'dudi_id');
    }
}
