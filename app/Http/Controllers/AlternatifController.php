<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Alternatif',
            'list' => ['Home', 'Alternatif']
        ];

        $page = (object)['title' => 'Daftar Alternatif yang terdaftar dalam sistem'];
        $activeMenu = 'alternatif';

        // Query dasar dengan relasi plant
        $query = AlternatifModel::with('plant');

        // Filter by Kode Alternatif
        if ($request->filled('kodealternatif')) {
            $query->where('kodealternatif', 'like', '%'.$request->kodealternatif.'%');
        }

        $alternatif = $query->paginate(12);

        $filterKodeAlter = AlternatifModel::select('kodealternatif')->distinct()->pluck('kodealternatif');

        return view('alternatif.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'alternatif' => $alternatif, // Perhatikan tidak ada spasi setelah 'alternatif'
            'filterKodeAlter' => $filterKodeAlter,
            'activeMenu' => $activeMenu
        ]);
    }
}