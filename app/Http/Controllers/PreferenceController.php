<?php

namespace App\Http\Controllers;

use App\Services\MlRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\WisataPreference;
use App\Models\KulinerPreference;
use App\Models\KategoriWisata;
use App\Models\KategoriKuliner;
use App\Models\Wisata;
use App\Models\Kuliner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PreferenceController extends Controller
{
    protected MlRecommendationService $mlService;

    public function __construct(MlRecommendationService $mlService)
    {
        $this->mlService = $mlService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_wisata' => 'nullable|array',
            'kategori_kuliner' => 'nullable|array',
            'budget_min' => 'nullable|integer|min:0',
            'budget_max' => 'nullable|integer|min:0',
            'rating_min' => 'nullable|integer|min:1|max:5',
        ]);

        Session::put('user_preferences', [
            'kategori_wisata' => $data['kategori_wisata'] ?? [],
            'kategori_kuliner' => $data['kategori_kuliner'] ?? [],
            'budget_min' => $data['budget_min'] ?? null,
            'budget_max' => $data['budget_max'] ?? null,
            'rating_min' => $data['rating_min'] ?? null,
        ]);

        DB::beginTransaction();

        try {

            $userId = Auth::id() ?? 1;

            // =====================
            // WISATA PREFERENCE
            // =====================
            $wisataPref = WisataPreference::updateOrCreate(
                ['user_id' => $userId], // kunci unik
                [
                    'budget_min' => $data['budget_min'] ?? null,
                    'budget_max' => $data['budget_max'] ?? null,
                    'rating_min' => $data['rating_min'] ?? null,
                ]
            );

            $kategoriWisataIds = KategoriWisata::whereIn(
                'nama_kategori',
                $data['kategori_wisata'] ?? []
            )->pluck('kategori_wisata_id')->toArray();

            $wisataPref->kategori()->sync($kategoriWisataIds);

            // =====================
            // KULINER PREFERENCE
            // =====================
            $kulinerPref = KulinerPreference::updateOrCreate(
                ['user_id' => $userId],
                [
                    'budget_min' => $data['budget_min'] ?? null,
                    'budget_max' => $data['budget_max'] ?? null,
                    'rating_min' => $data['rating_min'] ?? null,
                ]
            );

            $kategoriKulinerIds = KategoriKuliner::whereIn(
                'nama_kategori',
                $data['kategori_kuliner'] ?? []
            )->pluck('kategori_kuliner_id')->toArray();

            $kulinerPref->kategori()->sync($kategoriKulinerIds);

            DB::commit();

            // =====================
            // CALL ML SERVICE
            // =====================
            $wisata = $this->mlService->recommendWisata(
                $userId,
                $data['kategori_wisata'] ?? [],
                $data['budget_min'] ?? null,
                $data['budget_max'] ?? null,
                $data['rating_min'] ?? null,
            );

            $kuliner = $this->mlService->recommendKuliner(
                $userId,
                $data['kategori_kuliner'] ?? [],
                $data['budget_min'] ?? null,
                $data['budget_max'] ?? null,
                $data['rating_min'] ?? null,
            );

            if (empty($wisata)) {
                $wisata = $this->fallbackWisataRecommendations($data);
            }

            if (empty($kuliner)) {
                $kuliner = $this->fallbackKulinerRecommendations($data);
            }

            $wisata = collect($wisata)->map(function ($item) {

                $item['gambar'] = \App\Models\Wisata::find($item['wisata_id'])
                        ?->gambar()
                    ->first()
                        ?->gambar;

                return $item;
            })->values();

            $kuliner = collect($kuliner)->map(function ($item) {

                $item['gambar'] = \App\Models\Kuliner::find($item['kuliner_id'])
                        ?->gambar()
                    ->first()
                        ?->gambar;

                return $item;
            })->values();

            return response()->json([
                'success' => true,
                'wisata' => $wisata ?? [],
                'kuliner' => $kuliner ?? []
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function fallbackWisataRecommendations(array $data): array
    {
        $query = Wisata::with(['kategori', 'gambar']);

        if (!empty($data['kategori_wisata'])) {
            $query->whereHas('kategori', function ($query) use ($data) {
                $query->whereIn('nama_kategori', $data['kategori_wisata']);
            });
        }

        if (($data['budget_min'] ?? null) !== null) {
            $query->where('htm_max_domestik', '>=', $data['budget_min']);
        }

        if (($data['budget_max'] ?? null) !== null) {
            $query->where('htm_min_domestik', '<=', $data['budget_max']);
        }

        if (($data['rating_min'] ?? null) !== null) {
            $query->where('rating', '>=', $data['rating_min']);
        }

        $items = $query->orderByDesc('rating')->take(10)->get();

        if ($items->isEmpty()) {
            $items = Wisata::with(['kategori', 'gambar'])
                ->orderByDesc('rating')
                ->take(10)
                ->get();
        }

        return $items->map(function (Wisata $item) {
            return [
                'wisata_id' => $item->wisata_id,
                'nama_tempat' => $item->nama_tempat,
                'kategori' => $item->kategori->nama_kategori ?? '-',
                'jam_buka' => (string) $item->jam_buka,
                'jam_tutup' => (string) $item->jam_tutup,
                'alamat' => $item->alamat,
                'lokasi_geo' => $item->lokasi_geo,
                'htm_min_domestik' => (float) $item->htm_min_domestik,
                'htm_max_domestik' => (float) $item->htm_max_domestik,
                'htm_min_mancanegara' => (float) $item->htm_min_mancanegara,
                'htm_max_mancanegara' => (float) $item->htm_max_mancanegara,
                'akses_transportasi' => $item->akses_transportasi,
                'rating' => (float) $item->rating,
                'skor_rekomendasi' => (float) (($item->rating ?: 0) / 5),
                'gambar' => $item->gambar_utama,
            ];
        })->values()->all();
    }

    private function fallbackKulinerRecommendations(array $data): array
    {
        $query = Kuliner::with(['kategori', 'gambar']);

        if (!empty($data['kategori_kuliner'])) {
            $query->whereHas('kategori', function ($query) use ($data) {
                $query->whereIn('nama_kategori', $data['kategori_kuliner']);
            });
        }

        if (($data['budget_min'] ?? null) !== null) {
            $query->where('htm_max', '>=', $data['budget_min']);
        }

        if (($data['budget_max'] ?? null) !== null) {
            $query->where('htm_min', '<=', $data['budget_max']);
        }

        if (($data['rating_min'] ?? null) !== null) {
            $query->where('rating', '>=', $data['rating_min']);
        }

        $items = $query->orderByDesc('rating')->take(10)->get();

        if ($items->isEmpty()) {
            $items = Kuliner::with(['kategori', 'gambar'])
                ->orderByDesc('rating')
                ->take(10)
                ->get();
        }

        return $items->map(function (Kuliner $item) {
            return [
                'kuliner_id' => $item->kuliner_id,
                'nama_tempat' => $item->nama_tempat,
                'kategori' => $item->kategori->nama_kategori ?? '-',
                'jam_buka' => (string) $item->jam_buka,
                'jam_tutup' => (string) $item->jam_tutup,
                'alamat' => $item->alamat,
                'lokasi_geo' => $item->lokasi_geo,
                'htm_min' => (float) $item->htm_min,
                'htm_max' => (float) $item->htm_max,
                'rating' => (float) $item->rating,
                'skor_rekomendasi' => (float) (($item->rating ?: 0) / 5),
                'gambar' => $item->gambar_utama,
            ];
        })->values()->all();
    }

    public function clear()
    {
        Session::forget('user_preferences');

        return response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil dihapus',
            'redirect' => route('beranda')
        ]);
    }
}
