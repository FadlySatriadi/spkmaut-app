<?php

namespace App\Http\Controllers;

use App\Models\AubModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\AubDataTable;
use Yajra\DataTables\Facades\DataTables;

class OAubController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Anak Usaha Beton',
            'list' => ['DSS Batching Plant', 'AUB']
        ];

        $page = (object)['title' => 'Daftar AUB yang terdaftar dalam sistem'];
        $activeMenu = 'officeraub';

        // Ambil data langsung dengan filter
        $query = AubModel::select('idaub', 'kodeaub', 'namaaub');

        if ($request->has('kodeaub') && !empty($request->kodeaub)) {
            $query->where('kodeaub', $request->kodeaub);
        }

        $officeraub = $query->get();

        // $uniqueCodes = AubModel::select('kodeaub')->distinct()->pluck('kodeaub');
        return view('officer.aub.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'officeraub' => $officeraub, // Kirim data ke view

        ]);
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

        return redirect('/officer_aub')->with('success', 'Data aub berhasil ditambahkan');
    }

    public function show($id)
    {
        $oaub = AubModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Anak Usaha Beton',
            'list' => ['DSS Batching Plant', 'aub', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail aub'
        ];

        $activeMenu = 'officeraub';

        return view('officer.aub.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'oaub' => $oaub, 'activeMenu' => $activeMenu]);
    }
}
