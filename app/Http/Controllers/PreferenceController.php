<?php

namespace App\Http\Controllers;

use App\Services\MlRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\WisataPreference;
use App\Models\KulinerPreference;
use App\Models\KategoriWisata;
use App\Models\KategoriKuliner;
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

        DB::beginTransaction();

        try {

            $userId = Auth::id() ?? 1;

            // =====================
            // WISATA PREFERENCE
            // =====================
            $wisataPref = WisataPreference::updateOrCreate(
                ['user_id' => $userId], // kunci unik
                [
                    'budget_min' => $data['budget_min'],
                    'budget_max' => $data['budget_max'],
                    'rating_min' => $data['rating_min'],
                ]
            );

            if (!empty($data['kategori_wisata'])) {
                $kategoriWisataIds = KategoriWisata::whereIn(
                    'nama_kategori',
                    $data['kategori_wisata']
                )->pluck('kategori_wisata_id')->toArray();

                $wisataPref->kategori()->sync($kategoriWisataIds);
            }

            // =====================
            // KULINER PREFERENCE
            // =====================
            $kulinerPref = KulinerPreference::updateOrCreate(
                ['user_id' => $userId],
                [
                    'budget_min' => $data['budget_min'],
                    'budget_max' => $data['budget_max'],
                    'rating_min' => $data['rating_min'],
                ]
            );

            if (!empty($data['kategori_kuliner'])) {
                $kategoriKulinerIds = KategoriKuliner::whereIn(
                    'nama_kategori',
                    $data['kategori_kuliner']
                )->pluck('kategori_kuliner_id')->toArray();

                $kulinerPref->kategori()->attach($kategoriKulinerIds);
            }

            DB::commit();

            // =====================
            // CALL ML SERVICE
            // =====================
            $wisata = $this->mlService->recommendWisata(
                $userId,
                $data['kategori_wisata'] ?? [],
                $data['budget_min'],
                $data['budget_max'],
                $data['rating_min'],
            );

            $kuliner = $this->mlService->recommendKuliner(
                $userId,
                $data['kategori_kuliner'] ?? [],
                $data['budget_min'],
                $data['budget_max'],
                $data['rating_min'],
            );

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
