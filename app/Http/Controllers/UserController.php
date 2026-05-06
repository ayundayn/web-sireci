<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $userId = auth()->id() ?: $request->session()->getId();

        $wisata = $this->getWisataRecommendations($userId, $preferences);
        $kuliner = $this->getKulinerRecommendations($userId, $preferences);

        return view('user.beranda', compact('wisata', 'kuliner'));
    }

    protected function getWisataRecommendations($userId, $preferences)
    {
        if ($preferences && !empty($preferences['kategori_wisata'])) {
            $kategori = $preferences['kategori_wisata'][0] ?? null;
            $budgetMin = $preferences['budget_min'] ?? null;
            $budgetMax = $preferences['budget_max'] ?? null;
            $ratingMin = $preferences['rating_min'] ?? null;

            $mlRecommendations = $this->mlService->recommendWisata(
                userId: is_numeric($userId) ? (int) $userId : crc32($userId),
                kategori: $kategori,
                budgetMin: $budgetMin,
                budgetMax: $budgetMax,
                ratingMin: $ratingMin,
                topN: 5
            );

            if ($mlRecommendations) {
                return collect($mlRecommendations)->map(function ($item) {
                    return (object) [
                        'wisata_id' => $item['wisata_id'],
                        'nama_tempat' => $item['nama_tempat'],
                        'kategori' => (object) ['nama_kategori' => $item['kategori'] ?? '-'],
                        'rating' => $item['rating'],
                        'alamat' => $item['alamat'],
                        'harga' => $item['htm_min_domestik'],
                        'skor_rekomendasi' => $item['skor_rekomendasi'] ?? 0,
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
                    'harga' => $item['htm_min_domestik'],
                    'skor_rekomendasi' => 0,
                ];
            });
        }

        return Wisata::with('kategori')
            ->select('*')
            ->selectRaw('htm_min_domestik as harga')
            ->orderByDesc('rating')
            ->take(5)
            ->get();
    }

    protected function getKulinerRecommendations($userId, $preferences)
    {
        if ($preferences && !empty($preferences['kategori_kuliner'])) {
            $kategori = $preferences['kategori_kuliner'][0] ?? null;
            $budgetMin = $preferences['budget_min'] ?? null;
            $budgetMax = $preferences['budget_max'] ?? null;
            $ratingMin = $preferences['rating_min'] ?? null;

            $mlRecommendations = $this->mlService->recommendKuliner(
                userId: is_numeric($userId) ? (int) $userId : crc32($userId),
                kategori: $kategori,
                budgetMin: $budgetMin,
                budgetMax: $budgetMax,
                ratingMin: $ratingMin,
                topN: 5
            );

            if ($mlRecommendations) {
                return collect($mlRecommendations)->map(function ($item) {
                    return (object) [
                        'kuliner_id' => $item['kuliner_id'],
                        'nama_tempat' => $item['nama_tempat'],
                        'kategori' => (object) ['nama_kategori' => $item['kategori'] ?? '-'],
                        'rating' => $item['rating'],
                        'alamat' => $item['alamat'],
                        'harga' => $item['htm_min'],
                        'skor_rekomendasi' => $item['skor_rekomendasi'] ?? 0,
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
                    'harga' => $item['htm_min'],
                    'skor_rekomendasi' => 0,
                ];
            });
        }

        return Kuliner::with('kategori')
            ->select('*')
            ->selectRaw('htm_min as harga')
            ->orderByDesc('rating')
            ->take(5)
            ->get();
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
