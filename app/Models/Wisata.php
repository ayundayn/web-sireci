<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $table = 'wisata';
    protected $primaryKey = 'wisata_id';

    protected $fillable = [
        'kategori_wisata_id',
        'nama_tempat',
        'jam_buka',
        'jam_tutup',
        'alamat',
        'lokasi_geo',
        'htm_min_domestik',
        'htm_max_domestik',
        'htm_min_mancanegara',
        'htm_max_mancanegara',
        'akses_transportasi',
        'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriWisata::class, 'kategori_wisata_id');
    }

}
