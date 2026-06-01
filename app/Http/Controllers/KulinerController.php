<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    public function index()
    {
        $kuliner = Kuliner::with(['kategori', 'gambar'])->get();

        return view('user.kuliner', compact('kuliner'));
    }
}
