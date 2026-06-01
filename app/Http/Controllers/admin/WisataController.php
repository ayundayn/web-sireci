<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriWisata;
use App\Models\Wisata;
use App\Models\WisataGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $wisata = Wisata::with('kategori')
            ->when($keyword, function ($query) use ($keyword) {

                $query->where('nama_tempat', 'like', '%' . $keyword . '%')
                    ->orWhere('alamat', 'like', '%' . $keyword . '%');

            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.wisata.index', compact('wisata'));
    }

    public function create()
    {
        $kategori = KategoriWisata::all();

        return view('admin.wisata.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_wisata_id' => 'required',
            'nama_tempat' => 'required',
            'alamat' => 'required',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $wisata = Wisata::create([

            'kategori_wisata_id' => $request->kategori_wisata_id,
            'nama_tempat' => $request->nama_tempat,

            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,

            'alamat' => $request->alamat,

            'lokasi_geo' => $request->lokasi_geo,

            'htm_min_domestik' => str_replace('.', '', $request->htm_min_domestik),
            'htm_max_domestik' => str_replace('.', '', $request->htm_max_domestik),

            'htm_min_mancanegara' => str_replace('.', '', $request->htm_min_mancanegara),
            'htm_max_mancanegara' => str_replace('.', '', $request->htm_max_mancanegara),

            'akses_transportasi' => $request->akses_transportasi,

            'rating' => 0,
        ]);

        // upload multiple gambar
        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $file) {

                $originalName = $file->getClientOriginalName();
                $cleanName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $originalName);

                $namaFile = uniqid() . '_' . $cleanName;
                $file->move(public_path('uploads/wisata'), $namaFile);

                WisataGambar::create([
                    'wisata_id' => $wisata->wisata_id,
                    'gambar' => $namaFile
                ]);
            }
        }

        return redirect()
            ->route('admin.wisata.index')
            ->with('success', 'Wisata berhasil ditambahkan');
    }

    public function show($id)
    {
        $wisata = Wisata::with('kategori')
            ->where('wisata_id', $id)
            ->firstOrFail();

        $gambar = WisataGambar::where('wisata_id', $id)->get();

        return view('admin.wisata.show', compact('wisata', 'gambar'));
    }

    public function edit($id)
    {
        $wisata = Wisata::where('wisata_id', $id)->firstOrFail();

        $gambar = WisataGambar::where('wisata_id', $id)->get();

        $kategori = KategoriWisata::all();

        return view('admin.wisata.edit', compact('wisata', 'gambar', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_wisata_id' => 'required',
            'nama_tempat' => 'required',
            'alamat' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $wisata = Wisata::where('wisata_id', $id)
            ->with('gambar')
            ->firstOrFail();

        $wisata->update([

            'kategori_wisata_id' => $request->kategori_wisata_id,
            'nama_tempat' => $request->nama_tempat,

            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,

            'alamat' => $request->alamat,

            'lokasi_geo' => $request->lokasi_geo,

            'htm_min_domestik' => str_replace('.', '', $request->htm_min_domestik),
            'htm_max_domestik' => str_replace('.', '', $request->htm_max_domestik),

            'htm_min_mancanegara' => str_replace('.', '', $request->htm_min_mancanegara),
            'htm_max_mancanegara' => str_replace('.', '', $request->htm_max_mancanegara),

            'akses_transportasi' => $request->akses_transportasi,
        ]);

        // upload gambar baru
        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $file) {

                $originalName = $file->getClientOriginalName();
                $cleanName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $originalName);

                $namaFile = uniqid() . '_' . $cleanName;
                $file->move(public_path('uploads/wisata'), $namaFile);

                WisataGambar::create([
                    'wisata_id' => $wisata->wisata_id,
                    'gambar' => $namaFile
                ]);
            }
        }

        return redirect()
            ->route('admin.wisata.index')
            ->with('success', 'Data wisata berhasil diupdate');
    }

    public function destroy($id)
    {
        $wisata = Wisata::where('wisata_id', $id)
            ->with('gambar')
            ->firstOrFail();

        if ($wisata->gambar && $wisata->gambar->isNotEmpty()) {
            foreach ($wisata->gambar as $img) {

                $path = public_path('uploads/wisata/' . $img->gambar);

                if (File::exists($path)) {
                    File::delete($path);
                }

                $img->delete();
            }
        }

        $wisata->delete();

        return redirect()
            ->route('admin.wisata.index')
            ->with('success', 'Wisata berhasil dihapus');
    }

}
