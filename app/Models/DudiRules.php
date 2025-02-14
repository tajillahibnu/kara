<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DudiRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'dudi_id',
        'rule_type',
        'value',
    ];

    /**
     * Relasi ke model Dudi
     */
    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
}
