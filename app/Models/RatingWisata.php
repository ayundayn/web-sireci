<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingWisata extends Model
{
    protected $table = 'rating_wisata';
    protected $primaryKey = 'rating_wisata_id';

    protected $fillable = [
        'user_id',
        'wisata_id',
        'nilai_rating'
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
