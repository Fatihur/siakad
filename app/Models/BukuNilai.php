<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuNilai extends Model
{
    protected $table = 'buku_nilai';
    protected $fillable = ['semester_id', 'kelas_id', 'mata_pelajaran_id', 'guru_id', 'status_verifikasi', 'diverifikasi_oleh', 'diverifikasi_pada', 'catatan_verifikasi'];
    protected $casts = ['diverifikasi_pada' => 'datetime'];

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

    public function itemNilai()
    {
        return $this->hasMany(ItemNilai::class);
    }
}
