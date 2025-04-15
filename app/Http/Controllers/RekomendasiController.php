<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantModel;
use App\Models\KriteriaModel;

class RekomendasiController extends Controller
{
    // /**
    //  * Menampilkan form pemilihan alternatif dan input nilai
    //  */
    // public function index()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Rekomendasi',
    //         'list' => ['Home', 'Rekomendasi']
    //     ];

    //     $plants = PlantModel::where('status', 'aktif')->get();
    //     $criterias = KriteriaModel::orderBy('kodekriteria', 'asc')->get();

    //     $activeMenu = 'alternatif';

    //     return view('rekomendasi.index', [
    //         'breadcrumb' => $breadcrumb,
    //         'plants' => $plants,
    //         'criterias' => $criterias,
    //         'activeMenu' => $activeMenu
    //     ]);
    // }

    /**
     * Menghitung rekomendasi berdasarkan input
     */
    public function calculate(Request $request)
    {

        $breadcrumb = (object) [
            'title' => 'Pilih Plant',
            'list' => ['Home', 'Rekomendasi', 'Pilih Plant']
        ];

        $activeMenu = 'alternatif';

        // Validasi
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|array',
            'nilai.*.*' => 'required|numeric|min:0|max:10'
        ]);

        // Ambil data dari session
        $plantIds = session('selected_plants');
        $plants = PlantModel::whereIn('idplant', $plantIds)->get();
        $criterias = KriteriaModel::all();

        // Lakukan perhitungan MAUT
        $results = $this->calculateMaut($request->nilai, $plants, $criterias);
        session(['calculation_results' => $results]);

        // Tampilkan hasil
        return view('rekomendasi.result', [
            'breadcrumb' => $breadcrumb,
            'results' => $results,
            'criterias' => $criterias,
            'activeMenu' => $activeMenu
        ]);
    }

    private function calculateMaut($nilaiInput, $plants, $criterias)
    {
        // Hitung total bobot untuk normalisasi
        $totalBobot = $criterias->sum('bobotkriteria');

        // Normalisasi bobot
        $normalizedWeights = [];
        foreach ($criterias as $criteria) {
            $normalizedWeights[$criteria->idkriteria] = $criteria->bobotkriteria / $totalBobot;
        }

        // Proses perhitungan MAUT
        $results = [];
        foreach ($plants as $plant) { // Mengubah $selectedPlants menjadi $plants
            $utility = 0;
            $detail = [];

            foreach ($criterias as $criteria) {
                $nilai = $nilaiInput[$plant->idplant][$criteria->idkriteria] ?? 0;

                // Normalisasi nilai (0-1)
                $maxValue = $criterias->where('kodekriteria', $criteria->kodekriteria)->max('bobotkriteria') * 10;
                $minValue = 0;

                if ($criteria->jeniskriteria == 'benefit') {
                    $normalizedValue = ($nilai - $minValue) / ($maxValue - $minValue);
                } else { // cost
                    $normalizedValue = ($maxValue - $nilai) / ($maxValue - $minValue);
                }

                // Hitung utility
                $weightedUtility = $normalizedValue * $normalizedWeights[$criteria->idkriteria];
                $utility += $weightedUtility;

                $detail[] = [
                    'kode' => $criteria->kodekriteria,
                    'nama' => $criteria->namakriteria,
                    'jenis' => $criteria->jeniskriteria,
                    'nilai' => $nilai,
                    'normalized' => $normalizedValue,
                    'bobot' => $normalizedWeights[$criteria->idkriteria],
                    'utility' => $weightedUtility
                ];
            }

            $results[] = [
                'plant' => $plant,
                'total_utility' => $utility,
                'detail' => $detail
            ];
        }

        // Urutkan berdasarkan utility tertinggi
        usort($results, function ($a, $b) {
            return $b['total_utility'] <=> $a['total_utility'];
        });

        return $results;
    }

    public function getCriterias()
    {
        return response()->json(KriteriaModel::orderBy('kodekriteria', 'asc')->get());
    }

    public function selectPlants()
    {
        $breadcrumb = (object) [
            'title' => 'Pilih Plant',
            'list' => ['Home', 'Rekomendasi', 'Pilih Plant']
        ];

        $activeMenu = 'alternatif';

        $plants = PlantModel::where('status', 'aktif')->get();
        
        return view('rekomendasi.select-plants', [
            'breadcrumb' => $breadcrumb,
            'plants' => $plants,
            'activeMenu' => $activeMenu
        ]);
    }

    public function storePlants(Request $request)
    {
        $request->validate([
            'plants' => 'required|array',
            'plants.*' => 'exists:plant,idplant'
        ]);

        // Simpan ke session
        session(['selected_plants' => $request->plants]);

        return redirect()->route('rekomendasi.input-nilai');
    }

    public function inputNilai()
    {
        $breadcrumb = (object) [
            'title' => 'Form Penilaian Plant',
            'list' => ['Home', 'Rekomendasi', 'Form Penilaian Plant']
        ];

        $activeMenu = 'alternatif';

        // Ambil dari session
        $plantIds = session('selected_plants');

        if (!$plantIds) {
            return redirect()->route('rekomendasi.select-plants')
                ->with('error', 'Silakan pilih plant terlebih dahulu');
        }

        $plants = PlantModel::whereIn('idplant', $plantIds)->get();
        $criterias = KriteriaModel::orderBy('kodekriteria', 'asc')->get();

        return view('rekomendasi.input-nilai', [
            'breadcrumb' => $breadcrumb,
            'plants' => $plants,
            'criterias' => $criterias,
            'activeMenu' => $activeMenu
        ]);
    }

    public function showDetail()
{
    // Ambil hasil perhitungan dari session atau hitung ulang
    $results = session('calculation_results');
    
    if (!$results) {
        return redirect()->route('rekomendasi.index')
               ->with('error', 'Data perhitungan tidak ditemukan');
    }

    return view('rekomendasi.detail', [
        'results' => $results,
        'breadcrumb' => (object) [
            'title' => 'Detail Perhitungan',
            'list' => ['Home', 'Rekomendasi', 'Detail']
        ],
        'activeMenu' => 'rekomendasi'
    ]);
}
}