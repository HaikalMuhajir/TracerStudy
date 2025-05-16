<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi';
    protected $primaryKey = 'prodi_id';

    protected $fillable = ['nama_prodi'];

    public function alumnis()
    {
        return $this->hasMany(Alumni::class, 'prodi_id', 'prodi_id');
    }
}
