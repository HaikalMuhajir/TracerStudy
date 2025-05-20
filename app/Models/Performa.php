<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performa extends Model
{

    use HasFactory;

    protected $table = 'performa';
    protected $fillable = [
        'pengguna_id', 'alumni_id',
        'kerjasama_tim', 'keahlian_ti', 'bahasa_asing', 'komunikasi',
        'pengembangan_diri', 'kepemimpinan', 'etos_kerja',
        'kompetensi_kurang', 'saran_kurikulum'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id', 'pengguna_id');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id', 'alumni_id');
    }
}
