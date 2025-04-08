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
            'list' => ['Home', 'Kriteria']
        ];

        $page = (object)['title' => 'Daftar Kriteria yang terdaftar dalam sistem'];
        $activeMenu = 'kriteria';

        // Ambil data langsung dengan filter
        $query = KriteriaModel::select('idkriteria', 'kodekriteria', 'namakriteria', 'bobotkriteria');
        
        if ($request->has('kodekriteria') && !empty($request->kodekriteria)) {
            $query->where('kodekriteria', $request->kodekriteria);
        }

        $kriteria = $query->get();

        // $uniqueCodes = KriteriaModel::select('kodekriteria')->distinct()->pluck('kodekriteria');
        return view('kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kriteria' => $kriteria, // Kirim data ke view
            
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Aub',
            'list' => ['Home', 'Aub', 'Tambah']
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
            'kodekriteria' => 'required|string|min:3|unique:kriteria,kodekriteria',
            'namakriteria' => 'required|string|max:100'
        ]);

        KriteriaModel::create([
            'kodekriteria' => $request->kodekriteria,
            'namakriteria' => $request->namakriteria
        ]);

        return redirect('/kriteria')->with('success', 'Data kriteria berhasil ditambahkan');
    }

    public function show($id)
    {
        $kriteria = KriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kriteria',
            'list' => ['Home', 'kriteria', 'Detail']
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
            'list' => ['Home', 'kriteria', 'Edit']
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
            'kodekriteria' => 'required|string|min:3',
            'namakriteria' => 'required|string|max:100'
        ]);

        KriteriaModel::find($id)->update([
            'kodekriteria' => $request->kodekriteria,
            'namakriteria' => $request->namakriteria
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