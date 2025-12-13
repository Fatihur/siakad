<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = ['user_id', 'judul', 'pesan', 'tipe', 'link', 'dibaca_pada'];

    protected $casts = [
        'dibaca_pada' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBelumDibaca($query)
    {
        return $query->whereNull('dibaca_pada');
    }

    public static function kirim($userId, $judul, $pesan, $tipe = 'info', $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => $tipe,
            'link' => $link,
        ]);
    }

    public static function kirimKeSemua($userIds, $judul, $pesan, $tipe = 'info', $link = null)
    {
        foreach ($userIds as $userId) {
            self::kirim($userId, $judul, $pesan, $tipe, $link);
        }
    }
}
