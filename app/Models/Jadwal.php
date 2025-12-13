<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = ['semester_id', 'kelas_id', 'mata_pelajaran_id', 'guru_id', 'ruang_id', 'hari', 'jam_mulai', 'jam_selesai'];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function sesiAbsensi()
    {
        return $this->hasMany(SesiAbsensi::class);
    }
}
