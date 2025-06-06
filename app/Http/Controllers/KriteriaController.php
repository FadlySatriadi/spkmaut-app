<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\AubDataTable;
use Yajra\DataTables\Facades\DataTables;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kriteria',
            'list' => ['DSS Batching Plant', 'Kriteria']
        ];

        $page = (object)['title' => 'Daftar Kriteria yang terdaftar dalam sistem'];
        $activeMenu = 'kriteria';

        // Ambil data langsung dengan filter
        $query = KriteriaModel::select('idkriteria', 'kodekriteria', 'namakriteria', 'bobotkriteria', 'jeniskriteria');

        if ($request->has('kodekriteria') && !empty($request->kodekriteria)) {
            $query->where('kodekriteria', $request->kodekriteria);
        }

        $kriteria = $query->get();

        $totalBobot = $kriteria->sum('bobotkriteria');

        // Tambahkan bobot normalisasi ke setiap kriteria
        $kriteria->each(function ($item) use ($totalBobot) {
            $item->bobotnormalisasi = $totalBobot > 0 ? $item->bobotkriteria / $totalBobot : 0;
        });

        $totalBobotNormalisasi = $kriteria->sum('bobotnormalisasi');

        // $uniqueCodes = KriteriaModel::select('kodekriteria')->distinct()->pluck('kodekriteria');
        return view('kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kriteria' => $kriteria,
            'totalBobot' => $totalBobot,
            'totalBobotNormalisasi' => $totalBobotNormalisasi
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kriteria',
            'list' => ['DSS Batching Plant', 'Kriteria', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Data Anak Usaha'
        ];

        $kriteria = KriteriaModel::all();
        $activeMenu = 'kriteria';

        return view('kriteria.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodekriteria' => 'required|string|min:2|unique:kriteria,kodekriteria',
            'namakriteria' => 'required|string|max:100',
            'bobotkriteria' => 'required|numeric|min:1|max:5',
            'jeniskriteria' => 'required|in:benefit,cost'
        ]);

        KriteriaModel::create([
            'kodekriteria' => $request->kodekriteria,
            'namakriteria' => $request->namakriteria,
            'bobotkriteria' => $request->bobotkriteria,
            'jeniskriteria' => $request->jeniskriteria
        ]);

        return redirect('/kriteria')->with('success', 'Data kriteria berhasil ditambahkan');
    }

    public function show($id)
    {
        $kriteria = KriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kriteria',
            'list' => ['DSS Batching Plant', 'kriteria', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail kriteria'
        ];

        $activeMenu = 'kriteria';

        return view('kriteria.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $kriteria = KriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Kriteria',
            'list' => ['DSS Batching Plant', 'kriteria', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit kriteria'
        ];

        $activeMenu = 'kriteria';

        return view('kriteria.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodekriteria' => 'required|string|min:2|unique:kriteria,kodekriteria',
            'namakriteria' => 'required|string|max:100',
            'bobotkriteria' => 'required|numericmin:1|max:5',
            'jeniskriteria' => 'required|in:benefit,cost',
        ]);

        KriteriaModel::find($id)->update([
            'kodekriteria' => $request->kodekriteria,
            'namakriteria' => $request->namakriteria,
            'bobotkriteria' => $request->bobotkriteria,
            'jeniskriteria' => $request->jeniskriteria,
        ]);
        return redirect('/kriteria')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $check = KriteriaModel::find($id);

        if (!$check) {
            return redirect('/kriteria')->with('error', 'Data tidak ditemukan');
        }

        try {
            KriteriaModel::destroy($id);

            return redirect('/kriteria')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kriteria')->with('error', 'Data kriteria gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
