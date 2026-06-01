<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WisataPreference extends Model
{
    protected $table = 'wisata_preference';

    protected $fillable = ['user_id', 'budget_min', 'budget_max', 'rating_min'];

    public function kategori()
    {
        return $this->belongsToMany(
            KategoriWisata::class,
            'wisata_preference_kategori',
            'wisata_preference_id',
            'kategori_wisata_id'
        );
    }
}
