<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklRegistration extends Model
{
    use HasFactory;

    protected $fillable = ['periode_id', 'siswa_id', 'jurusan_id','registration_type', 'status'];

    public function periode()
    {
        return $this->belongsTo(PklPeriode::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function approvals()
    {
        return $this->hasMany(PklRegistrationStatuses::class, 'registration_id');
    }

}
