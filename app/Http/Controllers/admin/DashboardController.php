<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UatAnswer;
use App\Models\Wisata;
use App\Models\Kuliner;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahWisata = Wisata::count();
        $jumlahKuliner = Kuliner::count();
        $jumlahPenilaian = UatAnswer::count();

        $laki = UatAnswer::where(
            'jenis_kelamin',
            'Laki-laki'
        )->count();

        $perempuan = UatAnswer::where(
            'jenis_kelamin',
            'Perempuan'
        )->count();

        return view('admin.dashboard', compact(
            'jumlahWisata',
            'jumlahKuliner',
            'jumlahPenilaian',
            'laki',
            'perempuan'
        ));
    }
}
