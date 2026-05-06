<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoritWisata;
use App\Models\FavoritKuliner;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
public function toggle(Request $request)
{
    $userId = Auth::id();
    $id = $request->id;
    $type = $request->type; // wisata / kuliner

    if ($type === 'wisata') {

        $favorit = FavoritWisata::where('user_id', $userId)
            ->where('wisata_id', $id)
            ->first();

        if ($favorit) {
            $favorit->delete();
            return response()->json(['status' => 'removed']);
        }

        FavoritWisata::create([
            'user_id' => $userId,
            'wisata_id' => $id
        ]);

        return response()->json(['status' => 'added']);
    }

    if ($type === 'kuliner') {

        $favorit = FavoritKuliner::where('user_id', $userId)
            ->where('kuliner_id', $id)
            ->first();

        if ($favorit) {
            $favorit->delete();
            return response()->json(['status' => 'removed']);
        }

        FavoritKuliner::create([
            'user_id' => $userId,
            'kuliner_id' => $id
        ]);

        return response()->json(['status' => 'added']);
    }

    return response()->json(['error' => 'invalid type'], 400);
}
}
