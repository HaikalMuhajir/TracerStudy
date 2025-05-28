<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengguna_id';

    protected $fillable = [
        'alumni_id', 'nama', 'jabatan', 'no_hp', 'email', 'token'
    ];

    public function performa()
    {
        return $this->hasMany(Performa::class, 'pengguna_id', 'pengguna_id');
    }
}
