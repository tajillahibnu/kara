<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dudi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'address', 'phone', 'email', 'website',
        'latitude', 'longitude',
        'pic_name', 'pic_phone',
        'quota', 'sector', 'partnership_status', 
        'description', 'requirements', 
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi dengan DudiRule
     */
    public function rules()
    {
        return $this->hasMany(DudiRules::class);
    }
}
