<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 'tahun_akademik';
    protected $fillable = ['tahun', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];

    public function semester()
    {
        return $this->hasMany(Semester::class);
    }

    public static function getAktif()
    {
        return self::where('aktif', true)->first();
    }
}
