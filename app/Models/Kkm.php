<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kkm extends Model
{
    protected $table = 'kkm';
    protected $fillable = ['mata_pelajaran_id', 'jurusan_id', 'kelas_id', 'nilai_kkm', 'tahun_akademik_id'];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
