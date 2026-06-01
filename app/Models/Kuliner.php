<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KulinerGambar;
use App\Models\KategoriKuliner;

class Kuliner extends Model
{
    protected $table = 'kuliner';
    protected $primaryKey = 'kuliner_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kategori_kuliner_id',
        'nama_tempat',
        'jam_buka',
        'jam_tutup',
        'alamat',
        'lokasi_geo',
        'htm_min',
        'htm_max',
        'rating'
    ];

    public function gambar()
    {
        return $this->hasMany(KulinerGambar::class, 'kuliner_id', 'kuliner_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKuliner::class, 'kategori_kuliner_id');
    }

    public function ratings()
    {
        return $this->hasMany(RatingKuliner::class, 'kuliner_id');
    }

    public function getRouteKeyName()
    {
        return 'kuliner_id';
    }

    public function getGambarUtamaAttribute()
    {
        return optional($this->gambar->first())->gambar;
    }
}
