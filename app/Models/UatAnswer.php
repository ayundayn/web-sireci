<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UatAnswer extends Model
{
   protected $fillable = [

        'user_id',

        'jenis_kelamin',
        'usia',
        'pekerjaan',
        'pekerjaan_lainnya',
        'asal_daerah',
        'frekuensi_digital',
        'sumber_informasi',

        'q1','q2','q3','q4','q5','q6','q7','q8',

        'q9','q10','q11','q12','q13',
        'q14','q15','q16','q17','q18',
        'q19','q20','q21','q22','q23',

        'saran_pengguna'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
