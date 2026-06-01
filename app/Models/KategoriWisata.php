<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriWisata extends Model
{
    protected $table = 'kategori_wisata';
    protected $primaryKey = 'kategori_wisata_id';

    protected $fillable = [
        'nama_kategori'
    ];

    public function preferences()
    {
        return $this->belongsToMany(
            WisataPreference::class,
            'wisata_preference_kategori',
            'kategori_wisata_id',
            'wisata_preference_id'
        );
    }
}
