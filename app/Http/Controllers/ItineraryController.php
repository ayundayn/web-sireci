<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Wisata;
use App\Models\Kuliner;
use Illuminate\Support\Facades\Log;

class ItineraryController extends Controller
{
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
}
