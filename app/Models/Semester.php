<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';
    protected $fillable = ['tahun_akademik_id', 'tipe', 'aktif', 'tanggal_mulai', 'tanggal_selesai'];
    protected $casts = ['aktif' => 'boolean', 'tanggal_mulai' => 'date', 'tanggal_selesai' => 'date'];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public static function getAktif()
    {
        return self::where('aktif', true)->first();
    }
}
