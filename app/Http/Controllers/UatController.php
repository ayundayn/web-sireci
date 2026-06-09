<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UatAnswer;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UatRekomendasiExport;
use App\Exports\UatItineraryExport;

class UatController extends Controller
{
    public function index()
    {
        return view('user.uat');
    }

    public function store(Request $request)
    {
        UatAnswer::create([

            'user_id' => auth()->id(),

            'jenis_kelamin' => $request->jenis_kelamin,

            'usia' => $request->usia,

            'pekerjaan' => $request->pekerjaan,

            'pekerjaan_lainnya' => $request->pekerjaan_lainnya,

            'asal_daerah' => $request->asal_daerah,

            'frekuensi_digital' => $request->frekuensi_digital,

            'sumber_informasi' => $request->sumber_informasi,

            'q1' => $request->q1,
            'q2' => $request->q2,
            'q3' => $request->q3,
            'q4' => $request->q4,
            'q5' => $request->q5,
            'q6' => $request->q6,
            'q7' => $request->q7,
            'q8' => $request->q8,

            'q9' => $request->q9,
            'q10' => $request->q10,
            'q11' => $request->q11,
            'q12' => $request->q12,
            'q13' => $request->q13,
            'q14' => $request->q14,
            'q15' => $request->q15,
            'q16' => $request->q16,
            'q17' => $request->q17,
            'q18' => $request->q18,
            'q19' => $request->q19,
            'q20' => $request->q20,
            'q21' => $request->q21,
            'q22' => $request->q22,
            'q23' => $request->q23,

            'saran_pengguna' => $request->saran_pengguna,
        ]);

        $redirectUrl = session('uat_redirect', route('favorit'));

        return redirect($redirectUrl)
            ->with('success_uat', true);
    }

    public function downloadRekomendasi()
    {
        return Excel::download(
            new UatRekomendasiExport,
            'hasil-uat-rekomendasi.xlsx'
        );
    }

    public function downloadItinerary()
    {
        return Excel::download(
            new UatItineraryExport,
            'hasil-uat-itinerary.xlsx'
        );
    }
}
