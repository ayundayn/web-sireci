<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Wisata;
use App\Models\Kuliner;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\MlRecommendationService;

class ItineraryController extends Controller
{

    protected MlRecommendationService $mlService;

    public function __construct(MlRecommendationService $mlService)
    {
        $this->mlService = $mlService;
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'wisata_ids' => 'required|array|min:1',
            'wisata_ids.*' => 'integer',
            'kuliner_ids' => 'nullable|array',
            'kuliner_ids.*' => 'integer',
            'total_hari' => 'required|integer|min:1|max:7',
            'budget' => 'required|integer|min:0',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
        ]);

        try {
            $response = Http::timeout(60)->post(
                rtrim(env('ML_SERVICE_URL', 'http://127.0.0.1:8001'), '/') . '/api/itinerary',
                [
                    'wisata_ids' => $data['wisata_ids'],
                    'kuliner_ids' => $data['kuliner_ids'] ?? [],
                    'total_hari' => $data['total_hari'],
                    'budget' => $data['budget'],
                    'start_time' => $data['start_time'] ?? null,
                    'end_time' => $data['end_time'] ?? null
                ]
            );
        } catch (\Throwable $e) {
            Log::error('ML itinerary service connection error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Service itinerary belum bisa dihubungi. Cek container ML di VPS.',
            ], 503);
        }

        if (!$response->successful()) {
            Log::warning('ML itinerary service failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat itinerary dari ML service.',
                'status' => $response->status(),
                'detail' => $response->json('detail') ?? $response->body(),
            ], 502);
        }

        $result = $response->json();

        if (!isset($result['success'], $result['data']['itinerary'])) {
            return response()->json([
                'success' => false,
                'message' => 'Format response itinerary dari ML service tidak sesuai.',
                'raw' => $result,
            ], 502);
        }

        return response()->json($result);
    }

    public function group(Request $request)
    {
        if ($request->filled('kategori_wisata')) {
            $request->merge([
                'kategori_wisata' => json_decode($request->kategori_wisata, true)
            ]);
        }

        if ($request->filled('kategori_kuliner')) {
            $request->merge([
                'kategori_kuliner' => json_decode($request->kategori_kuliner, true)
            ]);
        }

        $validated = $request->validate([
            'jumlah_orang' => 'required|integer|min:1',
            'hari' => 'required|integer|min:1|max:7',
            'kategori_wisata' => 'nullable|array',
            'kategori_kuliner' => 'nullable|array',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $userId = auth()->id() ?? 1;

        /*
        |--------------------------------------------------------------------------
        | Jumlah kandidat rekomendasi
        |--------------------------------------------------------------------------
        */

        $topN = min(
            60,
            max(
                20,
                $validated['hari'] * 10
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Rekomendasi Wisata
        |--------------------------------------------------------------------------
        */

        $wisata = $this->mlService->recommendWisata(
            $userId,
            $validated['kategori_wisata'] ?? [],
            null,
            null,
            $validated['rating'] ?? null,
            $topN
        );

        /*
        |--------------------------------------------------------------------------
        | Rekomendasi Kuliner
        |--------------------------------------------------------------------------
        */

        $kuliner = $this->mlService->recommendKuliner(
            $userId,
            $validated['kategori_kuliner'] ?? [],
            null,
            null,
            $validated['rating'] ?? null,
            $topN
        );

        if (empty($wisata) || empty($kuliner)) {

            return back()->with(
                'error',
                'Rekomendasi tidak ditemukan.'
            );

        }

        $wisataIds = collect($wisata)
            ->pluck('wisata_id')
            ->values()
            ->toArray();

        $kulinerIds = collect($kuliner)
            ->pluck('kuliner_id')
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Generate itinerary
        |--------------------------------------------------------------------------
        */

        $response = Http::timeout(60)->post(

            rtrim(env('ML_SERVICE_URL'), '/') . '/api/itinerary',

            [

                'wisata_ids' => $wisataIds,

                'kuliner_ids' => $kulinerIds,

                'total_hari' => $validated['hari'],

                'budget' => 999999999,

                'start_time' => '08:00',

                'end_time' => '20:00'

            ]

        );

        if (!$response->successful()) {

            return back()->with(
                'error',
                'Gagal membuat itinerary.'
            );

        }

        $result = $response->json();

        $data = $result['data'];

        /*
        |--------------------------------------------------------------------------
        | Tambahkan gambar
        |--------------------------------------------------------------------------
        */

        foreach ($data['itinerary'] as &$days) {

            foreach ($days as &$item) {

                $item['gambar'] = $this->getGambar(
                    $item['type'],
                    $item['place_id']
                );

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Total budget rombongan
        |--------------------------------------------------------------------------
        */

        $data['total_budget'] *= $validated['jumlah_orang'];

        session([
            'group_itinerary' => $data
        ]);

        return redirect()->route('group.itinerary.show');
    }

    public function showGroup()
    {
        if (!session()->has('group_itinerary')) {
            return redirect()->route('beranda');
        }

        $data = session('group_itinerary');

        return view(
            'user.group_itinerary',
            compact('data')
        );
    }

    private function getGambar(string $type, string $kode)
    {
        if ($type === 'wisata') {

            return Wisata::with('gambar')
                ->where('kode', $kode)
                ->first()
                ?->gambar
                ->first()
                    ?->gambar;
        }

        return Kuliner::with('gambar')
            ->where('kode', $kode)
            ->first()
            ?->gambar
            ->first()
                ?->gambar;
    }

    public function page(Request $request)
    {
        $data = json_decode($request->data, true);

        if (!is_array($data) || !isset($data['itinerary'])) {
            abort(404);
        }

        foreach ($data['itinerary'] as &$days) {

            foreach ($days as &$item) {

                $item['gambar'] = $this->getGambar(
                    $item['type'],
                    $item['place_id']
                );
            }
        }

        return view('user.itinerary', compact('data'));
    }

    public function exportPdf(Request $request)
    {
        $data = json_decode($request->data, true);

        $pdf = Pdf::loadView(
            'user.pdf.itinerary',
            compact('data')
        );

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('itinerary-sireci.pdf');
    }
}
