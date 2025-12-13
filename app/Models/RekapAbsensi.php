<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapAbsensi extends Model
{
    protected $table = 'rekap_absensi';
    protected $fillable = ['sesi_absensi_id', 'siswa_id', 'status', 'catatan'];

    public function sesiAbsensi()
    {
        return $this->belongsTo(SesiAbsensi::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
