<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $primaryKey = 'alumni_id';

    protected $fillable = [
        'nama','prodi_id', 'nim','email', 'no_hp', 'jenis_instansi', 'nama_instansi', 'skala_instansi',
        'lokasi_instansi', 'kategori_profesi', 'profesi', 'tanggal_lulus', 'tanggal_pertama_kerja', 'token', 'is_infokom'
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id', 'prodi_id');
    }

    public function performa()
    {
        return $this->hasMany(Performa::class, 'alumni_id', 'alumni_id');
    }

}
