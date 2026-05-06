<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingKuliner extends Model
{
    protected $table = 'rating_kuliner';
    protected $primaryKey = 'rating_kuliner_id';

    protected $fillable = [
        'user_id',
        'kuliner_id',
        'nilai_rating'
    ];
}
