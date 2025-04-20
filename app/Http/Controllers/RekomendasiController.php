<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantModel;
use App\Models\KriteriaModel;
use App\Models\HistoryModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

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
        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|array',
            'nilai.*.*' => 'required|numeric|min:0|max:10'
        ]);

        session(['input_values' => $validated['nilai']]);

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
                    'nilai' => $nilaiInput,
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
        return response()->json(KriteriaModel::orderByRaw('LENGTH(kodekriteria), kodekriteria')->get());
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
        $criterias = KriteriaModel::orderByRaw('LENGTH(kodekriteria), kodekriteria')->get();

        return view('rekomendasi.input-nilai', [
            'breadcrumb' => $breadcrumb,
            'plants' => $plants,
            'criterias' => $criterias,
            'activeMenu' => $activeMenu
        ]);
    }

    public function showDetail()
    {
        // 1. Validasi Data Session
        if (!session()->has('input_values') || !session()->has('selected_plants')) {
            return redirect()->route('rekomendasi.select-plant')
                ->with('error', 'Data sesi tidak lengkap. Silakan lakukan perhitungan ulang.');
        }

        // 2. Ambil data dengan error handling
        try {
            $nilaiInput = session('input_values');
            $selectedPlants = session('selected_plants');

            // 3. Validasi struktur data
            if (!is_array($nilaiInput) || !is_array($selectedPlants)) {
                throw new \Exception("Format data sesi tidak valid");
            }

            $plants = PlantModel::whereIn('idplant', $selectedPlants)->get();
            $criterias = KriteriaModel::orderByRaw('LENGTH(kodekriteria), kodekriteria')->get();

            // 4. Validasi data plant dan kriteria
            if ($plants->isEmpty() || $criterias->isEmpty()) {
                throw new \Exception("Data referensi tidak ditemukan");
            }

            // 5. Perhitungan dengan logging
            $totalBobot = $criterias->sum('bobotkriteria');

            if ($totalBobot <= 0) {
                throw new \Exception("Total bobot kriteria tidak valid");
            }

            // Normalisasi bobot
            $normalizedWeights = $criterias->mapWithKeys(function ($criteria) use ($totalBobot) {
                return [$criteria->idkriteria => $criteria->bobotkriteria / $totalBobot];
            })->all();

            // Normalisasi nilai dengan handling division by zero
            $normalized = [];
            foreach ($plants as $plant) {
                foreach ($criterias as $criteria) {
                    $nilai = $nilaiInput[$plant->idplant][$criteria->idkriteria] ?? 0;
                    $max = $criterias->where('kodekriteria', $criteria->kodekriteria)->max('bobotkriteria') * 10;
                    $min = 0;
                    $range = $max - $min;

                    if ($range == 0) {
                        $normalizedValue = 0; // Handle kasus pembagian nol
                    } else {
                        $normalizedValue = ($criteria->jeniskriteria == 'benefit')
                            ? ($nilai - $min) / $range
                            : ($max - $nilai) / $range;
                    }

                    $normalized[$plant->idplant][$criteria->idkriteria] = $normalizedValue;
                }
            }

            // Hitung utility
            $utility = [];
            $results = [];
            foreach ($plants as $plant) {
                $total = 0;
                $details = [];

                foreach ($criterias as $criteria) {
                    $utilityValue = $normalized[$plant->idplant][$criteria->idkriteria]
                        * $normalizedWeights[$criteria->idkriteria];

                    $details[] = [
                        'kriteria_id' => $criteria->idkriteria,
                        'utility' => $utilityValue
                    ];

                    $total += $utilityValue;
                    $utility[$plant->idplant][$criteria->idkriteria] = $utilityValue;
                }

                $results[$plant->idplant] = [
                    'plant' => $plant,
                    'total' => $total,
                    'detail' => $details
                ];
            }

            // 6. Ranking dengan handling tie score
            $rankedResults = collect($results)
                ->sortByDesc('total')
                ->values()
                ->map(function ($item, $index) {
                    $item['rank'] = $index + 1;
                    return $item;
                })
                ->all();

            return view('rekomendasi.detail', [
                'plants' => $plants,
                'criterias' => $criterias,
                'nilai' => $nilaiInput,
                'normalizedWeights' => $normalizedWeights,
                'normalized' => $normalized,
                'utility' => $utility,
                'results' => $results,
                'rankedResults' => $rankedResults,
                'breadcrumb' => (object) [
                    'title' => 'Detail Perhitungan',
                    'list' => ['Home', 'Rekomendasi', 'Detail']
                ],
                'activeMenu' => 'rekomendasi'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in showDetail: ' . $e->getMessage(), [
                'exception' => $e,
                'session_data' => session()->all()
            ]);

            return redirect()->route('rekomendasi.select-plants')
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    protected function getDefaultRankedResults()
    {
        return session('calculation_results', []);
    }

    public function saveToCache(Request $request)
    {
        $user = Auth::user();
        $cacheKey = 'user_' . $user->iduser . '_recommendation_history';

        $newEntry = [
            'timestamp' => now()->timestamp,
            'date' => now()->format('d M Y H:i'),
            'user' => $user->nama,
            'top_ranking' => [
                'plant_code' => session('calculation_results')[0]['plant']->kodealternatif,
                'plant_name' => session('calculation_results')[0]['plant']->namaplant,
                'score' => session('calculation_results')[0]['total_utility']
            ],
            'all_data' => [
                'results' => session('calculation_results'),
                'criterias' => session('criterias'),
                'input_values' => session('input_values'),
                'normalized_weights' => session('normalized_weights'),
                'normalized_values' => session('normalized_values'),
                'utility_values' => session('utility_values'),
                'ranked_results' => session('ranked_results') ?? session('calculation_results')
            ]
        ];

        $history = Cache::get($cacheKey, []);
        array_unshift($history, $newEntry);
        Cache::put($cacheKey, array_slice($history, 0, 20), now()->addDays(30));

        return redirect()->route('rekomendasi.cache-history')
            ->with('success', 'Rekomendasi berhasil disimpan di riwayat');
    }

    public function showCacheHistory()
    {
        $user = Auth::user();
        $cacheKey = 'user_' . $user->iduser . '_recommendation_history';
        $histories = Cache::get($cacheKey, []);

        return view('rekomendasi.cache-history', [
            'histories' => $histories,
            'breadcrumb' => (object) [
                'title' => 'Riwayat Rekomendasi',
                'list' => ['Home', 'Riwayat']
            ],
            'activeMenu' => 'history'
        ]);
    }

    public function showCacheHistoryDetail($timestamp)
    {
        $user = Auth::user();
        $cacheKey = 'user_' . $user->iduser . '_recommendation_history';
        $histories = Cache::get($cacheKey, []);

        $selectedHistory = collect($histories)->firstWhere('timestamp', $timestamp);

        if (!$selectedHistory) {
            abort(404, 'Riwayat tidak ditemukan');
        }

        $allData = $selectedHistory['all_data'];

        // Rekonstruksi data untuk tampilan detail
        $plants = collect($allData['results'])->map(function ($result) {
            return $result['plant'];
        });

        $criterias = collect($allData['criterias']);

        return view('rekomendasi.cache-history-detail', [
            'history' => $selectedHistory,
            'plants' => $plants,
            'criterias' => $criterias,
            'nilai' => $allData['input_values'] ?? [],
            'normalizedWeights' => $allData['normalized_weights'] ?? [],
            'normalized' => $allData['normalized_values'] ?? [],
            'utility' => $allData['utility_values'] ?? [],
            'results' => $allData['results'] ?? [],
            'rankedResults' => $allData['ranked_results'] ?? $allData['results'] ?? [],
            'breadcrumb' => (object) [
                'title' => 'Detail Riwayat',
                'list' => ['Home', 'Riwayat', 'Detail']
            ],
            'activeMenu' => 'history'
        ]);
    }

    public function deleteHistory($timestamp)
    {
        $user = Auth::user();
        $cacheKey = 'user_' . $user->iduser . '_recommendation_history';
        $histories = Cache::get($cacheKey, []);

        // Filter out the history to be deleted
        $updatedHistories = array_filter($histories, function ($history) use ($timestamp) {
            return $history['timestamp'] != $timestamp;
        });

        // Save back to cache
        Cache::put($cacheKey, $updatedHistories, now()->addDays(30));

        return redirect()->route('rekomendasi.cache-history')
            ->with('success', 'Riwayat berhasil dihapus');
    }
}
