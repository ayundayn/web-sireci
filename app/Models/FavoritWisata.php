<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoritWisata extends Model
{
    protected $table = 'favorit_wisata';
    protected $primaryKey = 'favorit_id';

    protected $fillable = [
        'user_id',
        'wisata_id'
    ];
}
