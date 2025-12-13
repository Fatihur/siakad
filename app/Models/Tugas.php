<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $fillable = ['semester_id', 'kelas_id', 'mata_pelajaran_id', 'guru_id', 'judul', 'deskripsi', 'lampiran', 'jenis_pengumpulan', 'deadline', 'ditutup'];
    protected $casts = ['deadline' => 'datetime', 'ditutup' => 'boolean'];

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

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
