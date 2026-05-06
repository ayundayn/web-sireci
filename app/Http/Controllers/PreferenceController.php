<?php

namespace App\Http\Controllers;

use App\Services\MlRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        return response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil disimpan',
            'redirect' => route('beranda')
        ]);
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
