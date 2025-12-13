<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['kode', 'nama', 'kelompok', 'jam_per_minggu', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];
}
