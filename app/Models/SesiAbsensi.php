<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiAbsensi extends Model
{
    protected $table = 'sesi_absensi';
    protected $fillable = ['jadwal_id', 'tanggal', 'pertemuan_ke', 'status', 'dikunci_pada'];
    protected $casts = ['tanggal' => 'date', 'dikunci_pada' => 'datetime'];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function rekapAbsensi()
    {
        return $this->hasMany(RekapAbsensi::class);
    }
}
