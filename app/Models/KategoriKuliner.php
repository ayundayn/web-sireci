<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKuliner extends Model
{

    protected $table = 'kategori_kuliner';

    protected $primaryKey = 'kategori_kuliner_id';

    protected $fillable = [
        'nama_kategori'
    ];

    public function preferences()
    {
        return $this->belongsToMany(
            KulinerPreference::class,
            'kuliner_preference_kategori',
            'kategori_kuliner_id',
            'kuliner_preference_id'
        );
    }
}
