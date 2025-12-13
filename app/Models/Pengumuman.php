<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = ['judul', 'konten', 'lingkup', 'kelas_id', 'jurusan_id', 'dibuat_oleh', 'dipublikasi_pada', 'aktif'];
    protected $casts = ['dipublikasi_pada' => 'datetime', 'aktif' => 'boolean'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
