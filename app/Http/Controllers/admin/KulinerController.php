<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKuliner;
use App\Models\Kuliner;
use App\Models\KulinerGambar;
use File;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $kuliner = Kuliner::with('kategori')
            ->when($keyword, function ($query) use ($keyword) {

                $query->where('nama_tempat', 'like', '%' . $keyword . '%')
                    ->orWhere('alamat', 'like', '%' . $keyword . '%');

            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.kuliner.index', compact('kuliner'));
    }

    public function create()
    {
        $kategori = KategoriKuliner::all();

        return view('admin.kuliner.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kuliner_id' => 'required',
            'nama_tempat' => 'required',
            'alamat' => 'required',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $kuliner = Kuliner::create([

            'kategori_kuliner_id' => $request->kategori_kuliner_id,
            'nama_tempat' => $request->nama_tempat,

            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,

            'alamat' => $request->alamat,

            'lokasi_geo' => $request->lokasi_geo,

            'htm_min' => str_replace('.', '', $request->htm_min),
            'htm_max' => str_replace('.', '', $request->htm_max),

            'rating' => 0,
        ]);

        // upload multiple gambar
        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $file) {

                $namaFile = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads/kuliner'), $namaFile);

                KulinerGambar::create([
                    'kuliner_id' => $kuliner->kuliner_id,
                    'gambar' => $namaFile
                ]);
            }
        }

        return redirect()
            ->route('admin.kuliner.index')
            ->with('success', 'Kuliner berhasil ditambahkan');
    }

    public function show($id)
    {
        $kuliner = Kuliner::with('kategori')
            ->where('kuliner_id', $id)
            ->firstOrFail();

        $gambar = KulinerGambar::where('kuliner_id', $id)->get();

        return view('admin.kuliner.show', compact('kuliner', 'gambar'));
    }

    public function edit($id)
    {
        $kuliner = Kuliner::where('kuliner_id', $id)->firstOrFail();

        $gambar = KulinerGambar::where('kuliner_id', $id)->get();

        $kategori = KategoriKuliner::all();

        return view('admin.kuliner.edit', compact('kuliner', 'gambar', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kuliner_id' => 'required',
            'nama_tempat' => 'required',
            'alamat' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $kuliner = Kuliner::findOrFail($id);

        $kuliner->update([

            'kategori_kuliner_id' => $request->kategori_kuliner_id,
            'nama_tempat' => $request->nama_tempat,

            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,

            'alamat' => $request->alamat,

            'lokasi_geo' => $request->lokasi_geo,

            'htm_min' => str_replace('.', '', $request->htm_min),
            'htm_max' => str_replace('.', '', $request->htm_max),
        ]);

        // upload gambar baru
        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $file) {

                $namaFile = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads/kuliner'), $namaFile);

                KulinerGambar::create([
                    'kuliner_id' => $kuliner->kuliner_id,
                    'gambar' => $namaFile
                ]);
            }
        }

        return redirect()
            ->route('admin.kuliner.index')
            ->with('success', 'Data kuliner berhasil diupdate');
    }

    public function destroy($id)
    {
        $kuliner = Kuliner::where('kuliner_id', $id)
            ->with('gambar')
            ->firstOrFail();

        if ($kuliner->gambar && $kuliner->gambar->isNotEmpty()) {
            foreach ($kuliner->gambar as $img) {

                $path = public_path('uploads/kuliner/' . $img->gambar);

                if (File::exists($path)) {
                    File::delete($path);
                }

                $img->delete();
            }
        }

        $kuliner->delete();

        return redirect()
            ->route('admin.kuliner.index')
            ->with('success', 'Kuliner berhasil dihapus');
    }
}
