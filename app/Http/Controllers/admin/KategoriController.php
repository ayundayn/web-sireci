<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriWisata;
use App\Models\KategoriKuliner;

class KategoriController extends Controller
{

    public function index()
    {
        $wisata = \App\Models\KategoriWisata::select(
            'kategori_wisata_id as id',
            'nama_kategori'
        )->get()->map(function ($item) {

            $item->jenis = 'wisata';
            return $item;

        });


        $kuliner = \App\Models\KategoriKuliner::select(
            'kategori_kuliner_id as id',
            'nama_kategori'
        )->get()->map(function ($item) {

            $item->jenis = 'kuliner';
            return $item;

        });


        $kategori = $wisata->concat($kuliner);

        return view('admin.kategori.index', compact('kategori'));
    }


    public function create()
    {

        return view('admin.kategori.create');

    }


    public function store(Request $request)
    {

        $request->validate([
            'nama_kategori' => 'required',
            'jenis' => 'required'
        ]);


        if ($request->jenis == 'wisata') {

            KategoriWisata::create([
                'nama_kategori' => $request->nama_kategori
            ]);

        }

        if ($request->jenis == 'kuliner') {

            KategoriKuliner::create([
                'nama_kategori' => $request->nama_kategori
            ]);

        }

        return redirect('/admin/kategori')
            ->with('success', 'Kategori berhasil ditambahkan');

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'jenis' => 'required'
        ]);

        $wisata = KategoriWisata::find($id);
        $kuliner = KategoriKuliner::find($id);

        if ($request->jenis == 'wisata') {
            if ($wisata) {
                $wisata->update(['nama_kategori' => $request->nama_kategori]);
            }

            if ($kuliner) {
                $kuliner->delete();
                KategoriWisata::create(['nama_kategori' => $request->nama_kategori]);
            }

        } else {
            if ($kuliner) {
                $kuliner->update(['nama_kategori' => $request->nama_kategori]);
            }

            if ($wisata) {
                $wisata->delete();
                KategoriKuliner::create(['nama_kategori' => $request->nama_kategori]);
            }
        }

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diedit');
    }

    public function destroy($id)
    {
        $wisata = KategoriWisata::find($id);
        $kuliner = KategoriKuliner::find($id);

        if ($wisata)
            $wisata->delete();
        if ($kuliner)
            $kuliner->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }

    // public function destroy($id)
    // {

    //     $wisata = KategoriWisata::find($id);
    //     $kuliner = KategoriKuliner::find($id);

    //     if ($wisata) {
    //         $wisata->delete();
    //     }

    //     if ($kuliner) {
    //         $kuliner->delete();
    //     }

    //     return redirect()->route('kategori.index')
    //         ->with('success', 'Kategori berhasil dihapus');

    // }

}
