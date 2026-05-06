<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    protected $table = 'kuliner';
    protected $primaryKey = 'kuliner_id';

    protected $fillable = [
        'kategori_kuliner_id',
        'nama_tempat',
        'jam_buka',
        'jam_tutup',
        'alamat',
        'lokasi_geo',
        'htm_min',
        'htm_max',
        'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriKuliner::class, 'kategori_kuliner_id');
    }
}
