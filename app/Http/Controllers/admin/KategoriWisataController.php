<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriWisata;
use Illuminate\Http\Request;

class KategoriWisataController extends Controller
{

    public function index()
    {
        $kategori = KategoriWisata::paginate(10);

        return view('admin.kategori.index', compact('kategori'));
    }


    public function create()
    {
        return view('admin.kategori.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        KategoriWisata::create($request->all());

        return redirect()->route('kategori.index')
            ->with('success','Kategori berhasil ditambahkan');
    }


    public function edit($id)
    {
        $kategori = KategoriWisata::findOrFail($id);

        return view('admin.kategori.edit', compact('kategori'));
    }


    public function update(Request $request, $id)
    {
        $kategori = KategoriWisata::findOrFail($id);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')
            ->with('success','Kategori berhasil diupdate');
    }


    public function destroy($id)
    {
        $kategori = KategoriWisata::findOrFail($id);

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success','Kategori berhasil dihapus');
    }

}
