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
}
