<?php

namespace App\Http\Controllers;

use App\Models\PlantModel;
use App\Models\AubModel;
use Illuminate\Http\Request;

class OPlantController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Plant',
            'list' => ['DSS Batching Plant', 'Plant']
        ];

        $page = (object)['title' => 'Daftar Plant yang terdaftar dalam sistem'];
        $activeMenu = 'oplant';

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

        $oplant = $query->paginate(10);

        $filterKodeAUB = AubModel::select('kodeaub')->distinct()->pluck('kodeaub');
        $statusOptions = ['aktif', 'nonaktif']; // Sesuaikan dengan enum status di database

        return view('officer.plant.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'oplant' => $oplant,
            'filterKodeAUB' => $filterKodeAUB,
            'statusOptions' => $statusOptions,
            'activeMenu' => $activeMenu
        ]);
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

        return redirect('/oplant')->with('success', 'Data plant berhasil ditambahkan');
    }

    public function show($id)
    {
        $oplant = PlantModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Anak Usaha Beton',
            'list' => ['DSS Batching Plant', 'plant', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail plant'
        ];

        $activeMenu = 'oplant';

        return view('officer.plant.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'oplant' => $oplant, 'activeMenu' => $activeMenu]);
    }
}
