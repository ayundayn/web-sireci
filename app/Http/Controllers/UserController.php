<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Models\Kuliner;

class UserController extends Controller
{

    public function index()
    {
        $wisata = Wisata::with('kategori')
            ->select('*')
            ->selectRaw('htm_min_domestik as harga')
            ->latest()
            ->take(5)
            ->get();

        $kuliner = Kuliner::with('kategori')
            ->select('*')
            ->selectRaw('htm_min as harga')
            ->latest()
            ->take(5)
            ->get();

        return view('user.beranda', compact('wisata', 'kuliner'));
    }

    public function detailWisata($id)
    {
        $data = Wisata::findOrFail($id);

        return view('user.detail_wisata', [
            'data' => $data,
            'type' => 'wisata'
        ]);
    }

    public function detailKuliner($id)
    {
        $data = Kuliner::findOrFail($id);

        return view('user.detail_kuliner', [
            'data' => $data,
            'type' => 'kuliner'
        ]);
    }

    public function search()
    {
        $data = [];

        return view('user.search', compact('data'));
    }

    public function favorit()
    {
        $favorit = [];

        return view('user.favorit', compact('favorit'));
    }

    public function itinerary()
    {
        $itinerary = [];
        $total = 0;

        return view('user.itinerary', compact('itinerary', 'total'));
    }
}
