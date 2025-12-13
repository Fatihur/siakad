<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamIstirahat extends Model
{
    protected $table = 'jam_istirahat';
    
    protected $fillable = [
        'nama',
        'setelah_jam_ke',
        'durasi_menit',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public static function getAktif()
    {
        return self::where('aktif', true)->orderBy('setelah_jam_ke')->get();
    }
}
