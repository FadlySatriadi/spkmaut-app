<?php

namespace App\Http\Controllers;

use App\Models\AubModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\AubDataTable;
use Yajra\DataTables\Facades\DataTables;

class AubController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Anak Usaha Beton',
            'list' => ['Home', 'AUB']
        ];

        $page = (object)['title' => 'Daftar AUB yang terdaftar dalam sistem'];
        $activeMenu = 'aub';

        // Ambil data langsung dengan filter
        $query = AubModel::select('idaub', 'kodeaub', 'namaaub');

        if ($request->has('kodeaub') && !empty($request->kodeaub)) {
            $query->where('kodeaub', $request->kodeaub);
        }

        $aub = $query->get();

        // $uniqueCodes = AubModel::select('kodeaub')->distinct()->pluck('kodeaub');
        return view('aub.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'aub' => $aub, // Kirim data ke view

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

        $aub = AubModel::all();
        $activeMenu = 'aub';

        return view('aub.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aub' => $aub, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeaub' => 'required|string|min:3|unique:aub,kodeaub',
            'namaaub' => 'required|string|max:100'
        ]);

        AubModel::create([
            'kodeaub' => $request->kodeaub,
            'namaaub' => $request->namaaub
        ]);

        return redirect('/aub')->with('success', 'Data aub berhasil ditambahkan');
    }

    public function show($id)
    {
        $aub = AubModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Anak Usaha Beton',
            'list' => ['Home', 'aub', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail aub'
        ];

        $activeMenu = 'aub';

        return view('aub.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aub' => $aub, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $aub = AubModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data AUB',
            'list' => ['Home', 'aub', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit aub'
        ];

        $activeMenu = 'aub';

        return view('aub.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aub' => $aub, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodeaub' => 'required|string|min:3',
            'namaaub' => 'required|string|max:100'
        ]);

        AubModel::find($id)->update([
            'kodeaub' => $request->kodeaub,
            'namaaub' => $request->namaaub
        ]);
        return redirect('/aub')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $check = AubModel::find($id);

        if (!$check) {
            return redirect('/aub')->with('error', 'Data tidak ditemukan');
        }

        try {
            AubModel::destroy($id);

            return redirect('/aub')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/aub')->with('error', 'Data aub gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
