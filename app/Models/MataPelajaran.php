<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['kode', 'nama', 'kelompok', 'jam_per_minggu', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran', 'mata_pelajaran_id', 'guru_id')->withTimestamps();
    }
}
