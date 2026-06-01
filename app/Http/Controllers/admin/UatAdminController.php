<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UatAnswer;
use Illuminate\Http\Request;

class UatAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = UatAnswer::with('user');

        // Search nama user
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter tanggal awal
        if ($request->filled('start_date')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );
        }

        // Filter tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );
        }

        $uat = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.uat.index', compact('uat'));
    }
    
    public function show($id)
    {
        $data = UatAnswer::with('user')
            ->findOrFail($id);

        return view('admin.uat.show', compact('data'));
    }
}
