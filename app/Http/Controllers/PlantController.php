<?php

namespace App\Http\Controllers;
use App\Models\PlantModel;
use App\Models\AubModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\AubDataTable;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class PlantController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Aub',
            'list' => ['Home', 'Aub', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Data Anak Usaha'
        ];

        $query = PlantModel::with('aub');
        
        // Filter by Kode AUB (melalui relasi)
        if ($request->filled('kodeaub')) {
            $query->whereHas('aub', function($q) use ($request) {
                $q->where('kodeaub', $request->kodeaub);
            });
        }
        
        // Filter by Nama Plant
        if ($request->filled('namaplant')) {
            $query->where('namaplant', 'LIKE', '%'.$request->namaplant.'%');
        }
        
        $plant = $query->get();
        $filterKodeAUB = AubModel::select('kodeaub')->distinct()->pluck('kodeaub');
        
        $activeMenu = 'plant';

        return view('plant.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'plant' => $plant, 'filterKodeAUB' => $filterKodeAUB, 'activeMenu' => $activeMenu]);
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

        $plant = PlantModel::all();
        $activeMenu = 'plant';

        return view('plant.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'plant' => $plant, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeplant' => 'required|string|min:3|unique:plant,kodeplant',
            'namaplant' => 'required|string|max:100'
        ]);

        PlantModel::create([
            'kodeplant' => $request->kodeplant,
            'namaplant' => $request->namaplant
        ]);

        return redirect('/plant')->with('success', 'Data plant berhasil ditambahkan');
    }

    public function show($id)
    {
        $plant = PlantModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Anak Usaha Beton',
            'list' => ['Home', 'plant', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail plant'
        ];

        $activeMenu = 'plant';

        return view('plant.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'plant' => $plant, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $plant = PlantModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Plant',
            'list' => ['Home', 'plant', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit plant'
        ];

        $activeMenu = 'plant';

        return view('plant.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'plant' => $plant, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodeplant' => 'required|string|min:3',
            'namaplant' => 'required|string|max:100'
        ]);

        PlantModel::find($id)->update([
            'kodeplant' => $request->kodeplant,
            'namaplant' => $request->namaplant
        ]);
        return redirect('/plant')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $check = PlantModel::find($id);

        if (!$check) {
            return redirect('/plant')->with('error', 'Data tidak ditemukan');
        }

        try {
            PlantModel::destroy($id);

            return redirect('/plant')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/plant')->with('error', 'Data plant gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}