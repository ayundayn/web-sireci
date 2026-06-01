<?php

namespace App\Http\Controllers;

use App\Models\RatingKuliner;
use App\Models\RatingWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'id' => 'required',
            'type' => 'required|in:wisata,kuliner',
            'rating' => 'required|numeric|min:1|max:5'
        ]);

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | RATING WISATA
        |--------------------------------------------------------------------------
        */

        if ($request->type == 'wisata') {

            RatingWisata::updateOrCreate(

                [
                    'user_id' => $userId,
                    'wisata_id' => $request->id
                ],

                [
                    'nilai_rating' => $request->rating
                ]

            );
        }

        /*
        |--------------------------------------------------------------------------
        | RATING KULINER
        |--------------------------------------------------------------------------
        */

        else {

            RatingKuliner::updateOrCreate(

                [
                    'user_id' => $userId,
                    'kuliner_id' => $request->id
                ],

                [
                    'nilai_rating' => $request->rating
                ]

            );
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true
        ]);
    }
}
