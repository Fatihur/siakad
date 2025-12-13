<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_log';
    protected $fillable = ['user_id', 'entitas', 'entitas_id', 'aksi', 'data_sebelum', 'data_sesudah', 'ip_address'];
    protected $casts = ['data_sebelum' => 'array', 'data_sesudah' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function catat($entitas, $entitasId, $aksi, $sebelum = null, $sesudah = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'entitas' => $entitas,
            'entitas_id' => $entitasId,
            'aksi' => $aksi,
            'data_sebelum' => $sebelum,
            'data_sesudah' => $sesudah,
            'ip_address' => request()->ip(),
        ]);
    }
}
