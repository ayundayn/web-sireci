<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kuliner;

class KulinerGambar extends Model
{
    protected $table = 'kuliner_gambar';

    // protected $primaryKey = 'id';

    // protected $with = ['gambar'];

    public $timestamps = true;

    protected $fillable = [
        'kuliner_id',
        'gambar'
    ];

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class, 'kuliner_id', 'kuliner_id');
    }
}
