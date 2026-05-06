<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index()
    {
        $wisata = Wisata::paginate(10);

        return view('admin.wisata.index', compact('wisata'));
    }

    public function create()
    {
        return view('admin.wisata.create');
    }

    public function show($id)
    {
        $wisata = Wisata::findOrFail($id);

        return view('admin.wisata.show', compact('wisata'));
    }

    public function edit($id)
    {
        $wisata = Wisata::findOrFail($id);

        return view('admin.wisata.edit', compact('wisata'));
    }
}
