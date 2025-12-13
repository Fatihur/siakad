<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNilai extends Model
{
    protected $table = 'item_nilai';
    protected $fillable = ['buku_nilai_id', 'siswa_id', 'nilai_uts', 'nilai_tugas', 'nilai_sikap', 'nilai_keterampilan', 'nilai_raport', 'catatan'];

    public function bukuNilai()
    {
        return $this->belongsTo(BukuNilai::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
