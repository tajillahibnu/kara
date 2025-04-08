<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dudi extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id'; // Ganti dengan nama kolom primary key Anda
    public $incrementing = true; // Jika primary key adalah auto-increment
    protected $keyType = 'int'; // Tipe data primary key
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'latitude',
        'longitude',
        'pic_name',
        'pic_phone',
        'pic_jabatan',
        'quota',
        'sector',
        'partnership_status',
        'description',
        'requirements',
        'is_active',
        'username',
        'password',
        'jurusan_id',
        'kota',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at','password'];

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
