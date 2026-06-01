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

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
