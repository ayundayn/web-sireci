<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wisata;

class WisataGambar extends Model
{
    protected $table = 'wisata_gambar';

    // protected $primaryKey = 'id';

    // protected $with = ['gambar'];

    public $timestamps = true;

    protected $fillable = [
        'wisata_id',
        'gambar'
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'wisata_id', 'wisata_id');
    }
}
