<?php

namespace App\Http\Controllers;
use App\Models\AubModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AubController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Anak Usaha Beton',
            'list' => ['Home', 'Aub']
        ];

        $page = (object)[
            'title' => 'Daftar AUB yang terdaftar dalam sistem'
        ];

        $activeMenu = 'aub';

        $aub = AubModel::all();

        return view('aub.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aub' => $aub, 'activeMenu' => $activeMenu]);
    }

    public function list()
{
    $breadcrumb = (object) [
        'title' => 'Daftar AUB',
        'list' => ['Home', 'AUB', 'List']
    ];

    $page = (object)[
        'title' => 'Daftar Lengkap AUB'
    ];

    $activeMenu = 'aub';

    // Ambil data dengan pagination (15 item per halaman)
    $aub = AubModel::select('idaub', 'kodeaub', 'namaaub', 'status')
                  ->paginate(15);

    return view('aub.list', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'aub' => $aub,
        'activeMenu' => $activeMenu
    ]);
}

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data AUB',
            'list' => ['Home', 'AUB', 'Tambah']
        ];

        $aub = AubModel::all();
        $activeMenu = 'aub';

        return view('aub.create', ['breadcrumb' => $breadcrumb, 'aub' => $aub, 'activeMenu' => $activeMenu]);
    }
}