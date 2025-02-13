<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklRegistrationStatuses extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'role_id', 'user_id', 'status', 'notes'];

    public function registration()
    {
        return $this->belongsTo(PklRegistration::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
