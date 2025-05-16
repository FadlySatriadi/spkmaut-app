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
        $query = KriteriaModel::select('idkriteria', 'kodekriteria', 'namakriteria', 'bobotkriteria','jeniskriteria');
        
        if ($request->has('kodekriteria') && !empty($request->kodekriteria)) {
            $query->where('kodekriteria', $request->kodekriteria);
        }

        $okriteria = $query->get();

        $totalBobot = $okriteria->sum('bobotkriteria');
    
        // Tambahkan bobot normalisasi ke setiap kriteria
        $okriteria->each(function ($item) use ($totalBobot) {
            $item->bobotnormalisasi = $totalBobot > 0 ? $item->bobotkriteria / $totalBobot : 0;
        });

        $totalBobotNormalisasi = $okriteria->sum('bobotnormalisasi');

        // $uniqueCodes = KriteriaModel::select('kodekriteria')->distinct()->pluck('kodekriteria');
        return view('officer.kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'okriteria' => $okriteria,
            'totalBobot' => $totalBobot,
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