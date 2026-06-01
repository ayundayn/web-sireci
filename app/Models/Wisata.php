<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WisataGambar;
use App\Models\KategoriWisata;

class Wisata extends Model
{
    protected $table = 'wisata';
    protected $primaryKey = 'wisata_id';
    public $incrementing = true;
    protected $keyType = 'int';

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
        'rating'
    ];

    public function gambar()
    {
        return $this->hasMany(WisataGambar::class, 'wisata_id', 'wisata_id');
    }

    public function kategori()
    {
        return $this->belongsTo(
            KategoriWisata::class,
            'kategori_wisata_id',
            'kategori_wisata_id'
        );
    }

    public function ratings()
    {
        return $this->hasMany(RatingWisata::class, 'wisata_id');
    }

    public function getRouteKeyName()
    {
        return 'wisata_id';
    }

    public function getGambarUtamaAttribute()
    {
        return optional($this->gambar->first())->gambar;
    }

}
