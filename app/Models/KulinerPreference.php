<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KulinerPreference extends Model
{
    protected $table = 'kuliner_preference';

    protected $fillable = ['user_id', 'budget_min', 'budget_max', 'rating_min'];

    public function kategori()
    {
        return $this->belongsToMany(
            KategoriKuliner::class,
            'kuliner_preference_kategori',
            'kuliner_preference_id',
            'kategori_kuliner_id'
        );
    }
}
