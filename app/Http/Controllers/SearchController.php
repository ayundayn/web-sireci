<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Models\Kuliner;
use App\Models\KategoriWisata;
use App\Models\KategoriKuliner;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $min = $request->min_harga;
        $max = $request->max_harga;
        $rating = $request->rating;
        $sort = $request->sort;

        $wisata = Wisata::with(['kategori', 'gambar'])
            ->select('wisata.*')
            ->selectRaw("'wisata' as type")
            ->selectRaw('htm_min_domestik as harga')
            ->where(function ($query) use ($q) {
                $query->where('nama_tempat', 'like', "%$q%")
                    ->orWhere('alamat', 'like', "%$q%")
                    ->orWhereHas('kategori', function ($q2) use ($q) {
                        $q2->where('nama_kategori', 'like', "%$q%");
                    });
            });

        $kuliner = Kuliner::with(['kategori', 'gambar'])
            ->select('kuliner.*')
            ->selectRaw("'kuliner' as type")
            ->selectRaw('htm_min as harga')
            ->where(function ($query) use ($q) {
                $query->where('nama_tempat', 'like', "%$q%")
                    ->orWhere('alamat', 'like', "%$q%")
                    ->orWhereHas('kategori', function ($q2) use ($q) {
                        $q2->where('nama_kategori', 'like', "%$q%");
                    });
            });

        // FILTER
        // WISATA
        if ($request->filled('min_harga')) {
            $wisata->where('htm_min_domestik', '>=', $min);
        }

        if ($request->filled('max_harga')) {
            $wisata->where('htm_min_domestik', '<=', $max);
        }

        // KULINER
        if ($request->filled('min_harga')) {
            $kuliner->where('htm_min', '>=', $min);
        }

        if ($request->filled('max_harga')) {
            $kuliner->where('htm_max', '<=', $max);
        }

        // Wisata
        if ($rating) {
            $wisata->where('rating', '>=', $rating);
        }

        //Kuliner
        if ($rating) {
            $kuliner->where('rating', '>=', $rating);
        }

        // SORT DB
        foreach ([$wisata, $kuliner] as $query) {
            if ($sort == 'terbaru')
                $query->orderBy('created_at', 'desc');
            if ($sort == 'rating_desc')
                $query->orderBy('rating', 'desc');
            if ($sort == 'rating_asc')
                $query->orderBy('rating', 'asc');
            if ($sort == 'harga_asc') {
                $wisata->orderBy('harga', 'asc');
                $kuliner->orderBy('harga', 'asc');
            }

            if ($sort == 'harga_desc') {
                $wisata->orderBy('harga', 'desc');
                $kuliner->orderBy('harga', 'desc');
            }
        }

        $wisata = $wisata->get()->map(function ($item) {
            $item->type = 'wisata';
            return $item;
        });

        $kuliner = $kuliner->get()->map(function ($item) {
            $item->type = 'kuliner';
            return $item;
        });

        $results = $wisata->merge($kuliner);

        // SORT GLOBAL (biar konsisten setelah merge)
        if ($sort == 'rating_desc')
            $results = $results->sortByDesc('rating');
        if ($sort == 'rating_asc')
            $results = $results->sortBy('rating');
        if ($sort == 'harga_desc')
            $results = $results->sortByDesc('harga');
        if ($sort == 'harga_asc')
            $results = $results->sortBy('harga');

        return view('user.search', compact('results'));
    }

    public function show($type, $id)
    {
        if ($type == 'kuliner') {
            $data = Kuliner::findOrFail($id);
        } else {
            $data = Wisata::findOrFail($id);
        }

        return view('user.detail', compact('data', 'type'));
    }
}
