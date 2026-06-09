<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Wisata;
use App\Models\Kuliner;
use Barryvdh\DomPDF\Facade\Pdf;

class ItineraryController extends Controller
{
    public function generate(Request $request)
    {
        $response = Http::post(
            'http://127.0.0.1:8001/api/itinerary',
            [
                'wisata_ids' => $request->wisata_ids,
                'kuliner_ids' => $request->kuliner_ids,
                'total_hari' => $request->total_hari,
                'budget' => $request->budget,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time
            ]
        );

        $result = $response->json();

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
