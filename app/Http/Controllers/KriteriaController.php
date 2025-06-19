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

        // Get all criteria ordered by their current weight (descending)
        $kriteria = $query->orderBy('bobotkriteria', 'desc')->get();

        // Calculate ROC weights
        $n = $kriteria->count();
        $totalRocWeight = 0;

        $kriteria = $kriteria->map(function ($item, $index) use ($n) {
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
        $totalBobotNormalisasi = $kriteria->sum('bobotnormalisasi');

        return view('kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kriteria' => $kriteria,
            'totalBobot' => $kriteria->sum('bobotkriteria'),
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
            'bobotkriteria' => 'required|numeric|min:1|max:13|unique:kriteria,bobotkriteria',
            'jeniskriteria' => 'required|in:benefit,cost'
        ]);

        DB::beginTransaction();
        try {
            // Geser semua kriteria yang memiliki bobot >= bobot baru
            KriteriaModel::where('bobotkriteria', '>=', $request->bobotkriteria)
                ->increment('bobotkriteria');

            KriteriaModel::create([
                'kodekriteria' => $request->kodekriteria,
                'namakriteria' => $request->namakriteria,
                'bobotkriteria' => $request->bobotkriteria,
                'jeniskriteria' => $request->jeniskriteria
            ]);

            DB::commit();
            return redirect('/kriteria')->with('success', 'Data kriteria berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/kriteria')->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
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
            'kodekriteria' => 'required|string|min:2',
            'namakriteria' => 'required|string|max:100',
            'bobotkriteria' => 'required|numeric|min:1|max:13',
            'jeniskriteria' => 'required|in:benefit,cost',
        ]);

        DB::beginTransaction();
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $oldOrder = $kriteria->bobotkriteria;
            $newOrder = $request->bobotkriteria;

            if ($newOrder != $oldOrder) {
                // Jika urutan baru lebih kecil (naik ranking)
                if ($newOrder < $oldOrder) {
                    KriteriaModel::where('bobotkriteria', '>=', $newOrder)
                        ->where('bobotkriteria', '<', $oldOrder)
                        ->increment('bobotkriteria');
                }
                // Jika urutan baru lebih besar (turun ranking)
                else {
                    KriteriaModel::where('bobotkriteria', '>', $oldOrder)
                        ->where('bobotkriteria', '<=', $newOrder)
                        ->decrement('bobotkriteria');
                }
            }

            $kriteria->update([
                'kodekriteria' => $request->kodekriteria,
                'namakriteria' => $request->namakriteria,
                'bobotkriteria' => $newOrder,
                'jeniskriteria' => $request->jeniskriteria,
            ]);

            DB::commit();
            return redirect('/kriteria')->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/kriteria')->with('error', 'Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $check = KriteriaModel::find($id);

        if (!$check) {
            return redirect('/kriteria')->with('error', 'Data tidak ditemukan');
        }

        DB::beginTransaction();
        try {
            $order = $check->bobotkriteria;
            KriteriaModel::destroy($id);

            // Sesuaikan urutan kriteria yang lebih tinggi
            KriteriaModel::where('bobotkriteria', '>', $order)
                ->decrement('bobotkriteria');

            DB::commit();
            return redirect('/kriteria')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/kriteria')->with('error', 'Data kriteria gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
