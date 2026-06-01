<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoritKuliner extends Model
{
    protected $table = 'favorit_kuliner';
    protected $primaryKey = 'favorit_id';

    protected $fillable = [
        'user_id',
        'kuliner_id'
    ];

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id', 'kuliner_id');
    }
}
