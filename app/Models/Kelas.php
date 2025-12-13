<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['nama', 'tingkat', 'jurusan_id', 'rombel', 'kapasitas', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function getNamaLengkapAttribute()
    {
        return $this->tingkat . ' ' . $this->jurusan->nama . ' ' . $this->rombel;
    }
}
