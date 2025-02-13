<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklApproval extends Model
{
    use HasFactory;

    protected $fillable = ['periode_id', 'role_id', 'is_required'];

    public function periode()
    {
        return $this->belongsTo(PklPeriode::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
