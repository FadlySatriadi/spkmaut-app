<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\AubDataTable;
use Yajra\DataTables\Facades\DataTables;

class OKriteriaController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kriteria',
            'list' => ['DSS Batching Plant', 'Kriteria']
        ];

        $page = (object)['title' => 'Daftar Kriteria yang terdaftar dalam sistem'];
        $activeMenu = 'okriteria';

        // Ambil data langsung dengan filter
        $query = KriteriaModel::select('idkriteria', 'kodekriteria', 'namakriteria', 'bobotkriteria', 'jeniskriteria');

        if ($request->has('kodekriteria') && !empty($request->kodekriteria)) {
            $query->where('kodekriteria', $request->kodekriteria);
        }

        // Get all criteria ordered by their current weight (descending)
        $okriteria = $query->orderBy('bobotkriteria', 'desc')->get();

        // Calculate ROC weights
        $n = $okriteria->count();
        $totalRocWeight = 0;

        $okriteria = $okriteria->map(function ($item, $index) use ($n) {
            $rank = $index + 1;
            $rocWeight = 0;

            // ROC formula: (1/n) * Σ(1/i) for i from rank to n
            for ($i = $rank; $i <= $n; $i++) {
                $rocWeight += 1 / $i;
            }
            $rocWeight = $rocWeight / $n;

            $item->bobotnormalisasi = $rocWeight;
            return $item;
        });

        // Calculate total ROC weight (should be approximately 1)
        $totalBobotNormalisasi = $okriteria->sum('bobotnormalisasi');

        return view('officer.kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'okriteria' => $okriteria,
            'totalBobot' => $okriteria->sum('bobotkriteria'),
            'totalBobotNormalisasi' => $totalBobotNormalisasi
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodekriteria' => 'required|string|min:3|unique:kriteria,kodekriteria',
            'namakriteria' => 'required|string|max:100'
        ]);

        KriteriaModel::create([
            'kodekriteria' => $request->kodekriteria,
            'namakriteria' => $request->namakriteria
        ]);

        return redirect('/okriteria')->with('success', 'Data kriteria berhasil ditambahkan');
    }

    public function show($id)
    {
        $okriteria = KriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kriteria',
            'list' => ['DSS Batching Plant', 'okriteria', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail kriteria'
        ];

        $activeMenu = 'okriteria';

        return view('officer.kriteria.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'okriteria' => $okriteria, 'activeMenu' => $activeMenu]);
    }
}
