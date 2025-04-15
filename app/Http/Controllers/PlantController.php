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
            'title' => 'Daftar Plant',
            'list' => ['Home', 'Plant']
        ];

        $page = (object)['title' => 'Daftar Plant yang terdaftar dalam sistem'];
        $activeMenu = 'plant';

        $query = PlantModel::with('aub')->select('idplant', 'idaub', 'kodeplant', 'namaplant', 'kodealternatif', 'status');

        // Filter by Kode AUB
        if ($request->filled('kodeaub')) {
            $query->whereHas('aub', function ($q) use ($request) {
                $q->where('kodeaub', $request->kodeaub);
            });
        }

        // Filter by Nama Plant
        if ($request->filled('namaplant')) {
            $query->where('namaplant', 'LIKE', '%' . $request->namaplant . '%');
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $plant = $query->paginate(10);

        $filterKodeAUB = AubModel::select('kodeaub')->distinct()->pluck('kodeaub');
        $statusOptions = ['aktif', 'nonaktif']; // Sesuaikan dengan enum status di database

        return view('plant.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'plant' => $plant,
            'filterKodeAUB' => $filterKodeAUB,
            'statusOptions' => $statusOptions,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Plant',
            'list' => ['Home', 'Plant', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Data Batching Plant'
        ];

        $plant = PlantModel::all();
        $activeMenu = 'plant';
        $kodeAUBops = AubModel::select('idaub', 'kodeaub')->get();
        $statusOptions = ['aktif', 'nonaktif'];

        return view('plant.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'plant' => $plant, 'kodeAUBops' => $kodeAUBops, 'statusOptions' => $statusOptions, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idaub' => 'required|exists:aub,idaub',
            'kodeplant' => 'required|string|min:3|unique:plant,kodeplant',
            'namaplant' => 'required|string|max:100',
            'status' => 'required',
        ]);

        PlantModel::create([
            'idaub' => $request->idaub,
            'kodeplant' => $request->kodeplant,
            'namaplant' => $request->namaplant,
            'status'    => $request->status
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
            'kodeplant' => 'required|string|min:4',
            'namaplant' => 'required|string|max:100',
            'status'    => 'required'
        ]);

        PlantModel::find($id)->update([
            'kodeplant' => $request->kodeplant,
            'namaplant' => $request->namaplant,
            'status'    => $request->status
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
