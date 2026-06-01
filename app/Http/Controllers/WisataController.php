<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index()
    {
        $wisata = Wisata::with(['kategori', 'gambar'])->get();

        return view('user.wisata', compact('wisata'));
    }
}
