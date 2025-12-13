<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    protected $table = 'pengumpulan_tugas';
    protected $fillable = ['tugas_id', 'siswa_id', 'konten', 'file_path', 'url_link', 'dikumpulkan_pada', 'terlambat', 'nilai', 'feedback', 'dinilai_pada'];
    protected $casts = ['dikumpulkan_pada' => 'datetime', 'dinilai_pada' => 'datetime', 'terlambat' => 'boolean'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
