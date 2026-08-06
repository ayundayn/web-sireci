<?php

namespace App\Http\Controllers;

use App\Models\FavoritKuliner;
use App\Models\FavoritWisata;
use App\Models\KategoriKuliner;
use App\Models\KategoriWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Wisata;
use App\Models\Kuliner;
use App\Services\MlRecommendationService;

class UserController extends Controller
{
    protected MlRecommendationService $mlService;

    public function __construct(MlRecommendationService $mlService)
    {
        $this->mlService = $mlService;
    }

    public function index(Request $request)
    {
        $preferences = Session::get('user_preferences');
        $hasPreference = Session::has('user_preferences');

        $userId = auth()->id() ?: $request->session()->getId();

        $wisata = $this->getWisataRecommendations($userId, $preferences);
        $kuliner = $this->getKulinerRecommendations($userId, $preferences);

        $kategoriWisata = KategoriWisata::all();
        $kategoriKuliner = KategoriKuliner::all();

        return view('user.beranda', compact(
            'wisata',
            'kuliner',
            'kategoriWisata',
            'kategoriKuliner',
            'hasPreference'
        ));
    }

    protected function getWisataRecommendations($userId, $preferences)
    {
        if ($preferences && !empty($preferences['kategori_wisata'])) {
            $kategori = $preferences['kategori_wisata'] ?? null;
            $budgetMin = $preferences['budget_min'] ?? null;
            $budgetMax = $preferences['budget_max'] ?? null;
            $ratingMin = $preferences['rating_min'] ?? null;

            $mlRecommendations = $this->mlService->recommendWisata(
                userId: is_numeric($userId) ? (int) $userId : crc32($userId),
                kategori: $kategori,
                budgetMin: $budgetMin,
                budgetMax: $budgetMax,
                ratingMin: $ratingMin,
                topN: 20
            );

            if ($mlRecommendations) {
                return collect($mlRecommendations)->map(function ($item) {
                    return (object) [
                        'wisata_id' => $item['wisata_id'],
                        'nama_tempat' => $item['nama_tempat'],
                        'kategori' => (object) ['nama_kategori' => $item['kategori'] ?? '-'],
                        'rating' => $item['rating'],
                        'alamat' => $item['alamat'],
                        'htm_min_domestik' => $item['htm_min_domestik'] ?? 0,
                        'htm_max_domestik' => $item['htm_max_domestik'] ?? 0,
                        'skor_rekomendasi' => $item['skor_rekomendasi'] ?? 0,
                        'gambar_utama' => Wisata::find($item['wisata_id'])
                                ?->gambar()
                            ->first()
                                ?->gambar,
                    ];
                });
            }
        }

        $popular = $this->mlService->getPopularWisata(5);

        if ($popular) {
            return collect($popular)->map(function ($item) {
                return (object) [
                    'wisata_id' => $item['wisata_id'],
                    'nama_tempat' => $item['nama_tempat'],
                    'kategori' => (object) ['nama_kategori' => $item['kategori'] ?? '-'],
                    'rating' => $item['rating'],
                    'alamat' => $item['alamat'],
                    'htm_min_domestik' => $item['htm_min_domestik'] ?? 0,
                    'htm_max_domestik' => $item['htm_max_domestik'] ?? 0,
                    'skor_rekomendasi' => 0,
                    'gambar_utama' => Wisata::find($item['wisata_id'])
                            ?->gambar()
                            ->first()
                            ?->gambar,
                ];
            });
        }

        return Wisata::with([
            'kategori',
            'gambar'
        ])
            ->select('*')
            ->selectRaw('htm_min_domestik as harga')
            ->orderByDesc('rating')
            ->take(5)
            ->get();
    }

    protected function getKulinerRecommendations($userId, $preferences)
    {
        if ($preferences && !empty($preferences['kategori_kuliner'])) {
            $kategori = $preferences['kategori_kuliner'] ?? null;
            $budgetMin = $preferences['budget_min'] ?? null;
            $budgetMax = $preferences['budget_max'] ?? null;
            $ratingMin = $preferences['rating_min'] ?? null;

            $mlRecommendations = $this->mlService->recommendKuliner(
                userId: is_numeric($userId) ? (int) $userId : crc32($userId),
                kategori: $kategori,
                budgetMin: $budgetMin,
                budgetMax: $budgetMax,
                ratingMin: $ratingMin,
                topN: 20
            );

            if ($mlRecommendations) {
                return collect($mlRecommendations)->map(function ($item) {
                    return (object) [
                        'kuliner_id' => $item['kuliner_id'],
                        'nama_tempat' => $item['nama_tempat'],
                        'kategori' => (object) ['nama_kategori' => $item['kategori'] ?? '-'],
                        'rating' => $item['rating'],
                        'alamat' => $item['alamat'],
                        'htm_min' => $item['htm_min'] ?? 0,
                        'htm_max' => $item['htm_max'] ?? 0,
                        'skor_rekomendasi' => $item['skor_rekomendasi'] ?? 0,
                        'gambar_utama' => Kuliner::find($item['kuliner_id'])
                                ?->gambar()
                            ->first()
                                ?->gambar,
                    ];
                });
            }
        }

        $popular = $this->mlService->getPopularKuliner(5);

        if ($popular) {
            return collect($popular)->map(function ($item) {
                return (object) [
                    'kuliner_id' => $item['kuliner_id'],
                    'nama_tempat' => $item['nama_tempat'],
                    'kategori' => (object) ['nama_kategori' => $item['kategori'] ?? '-'],
                    'rating' => $item['rating'],
                    'alamat' => $item['alamat'],
                    'htm_min' => $item['htm_min'],
                    'htm_max' => $item['htm_max'],
                    'skor_rekomendasi' => 0,
                    'gambar_utama' => Kuliner::find($item['kuliner_id'])
                            ?->gambar()
                            ->first()
                            ?->gambar,
                ];
            });
        }

        return Kuliner::with([
            'kategori',
            'gambar'
        ])
            ->select('*')
            ->selectRaw('htm_min as harga')
            ->orderByDesc('rating')
            ->take(5)
            ->get();
    }

    public function detailWisata($id)
    {
        $data = Wisata::with([
            'kategori',
            'gambar'
        ])->findOrFail($id);

        $isFavorit = false;
        $userRating = null;

        if (Auth::check()) {

            $isFavorit = FavoritWisata::where('user_id', Auth::id())
                ->where('wisata_id', $data->wisata_id)
                ->exists();
        }

        if (auth()->check()) {

            $userRating = \App\Models\RatingWisata::where('user_id', auth()->id())
                ->where('wisata_id', $data->wisata_id)
                ->value('nilai_rating');
        }

        return view('user.detail_wisata', [
            'data' => $data,
            'type' => 'wisata',
            'isFavorit' => $isFavorit,
            'userRating' => $userRating
        ]);
    }

    public function detailKuliner($id)
    {
        $data = Kuliner::with([
            'kategori',
            'gambar'
        ])->findOrFail($id);

        $isFavorit = false;

        $userRating = null;

        if (Auth::check()) {

            $isFavorit = FavoritKuliner::where('user_id', Auth::id())
                ->where('kuliner_id', $data->kuliner_id)
                ->exists();
        }

        if (auth()->check()) {

            $userRating = \App\Models\RatingKuliner::where('user_id', auth()->id())
                ->where('kuliner_id', $data->kuliner_id)
                ->value('nilai_rating');
        }

        return view('user.detail_kuliner', [
            'data' => $data,
            'type' => 'kuliner',
            'isFavorit' => $isFavorit,
            'userRating' => $userRating
        ]);
    }

    public function search()
    {
        $data = [];

        return view('user.search', compact('data'));
    }

    public function favorit()
    {
        $favoritWisata = FavoritWisata::with(['wisata.kategori'])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {

                return [
                    'type' => 'wisata',
                    'created_at' => $item->created_at,
                    'data' => $item
                ];
            });

        $favoritKuliner = FavoritKuliner::with(['kuliner.kategori'])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {

                return [
                    'type' => 'kuliner',
                    'created_at' => $item->created_at,
                    'data' => $item
                ];
            });

        $favorit = $favoritWisata
            ->concat($favoritKuliner)
            ->sortByDesc('created_at');

        return view('user.favorit', compact('favorit'));
    }

    public function itinerary()
    {
        $itinerary = [];
        $total = 0;

        return view('user.itinerary', compact('itinerary', 'total'));
    }
}
