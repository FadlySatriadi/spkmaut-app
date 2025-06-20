<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantModel;
use App\Models\KriteriaModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ORekomendasiController extends Controller
{
    public function calculate(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Pilih Plant',
            'list' => ['DSS Batching Plant', 'Rekomendasi', 'Pilih Plant']
        ];

        $activeMenu = 'rekomendasi';

        // Daftar nilai maksimal untuk validasi
        $maxValues = [
            'C1' => 5,
            'C2' => 4,
            'C3' => 4,
            'C4' => 3,
            'C5' => 4,
            'C6' => 3,
            'C7' => 4,
            'C8' => 5,
            'C9' => 4,
            'C10' => 4,
            'C11' => 3,
            'C12' => 4,
            'C13' => 5
        ];

        // Ambil semua kriteria untuk validasi
        $allCriterias = KriteriaModel::all()->keyBy('idkriteria');

        // Buat rules validasi dinamis
        $rules = ['nilai' => 'required|array'];
        $customMessages = [];

        foreach ($allCriterias as $id => $criteria) {
            $max = $maxValues[$criteria->kodekriteria] ?? 5;

            $rules["nilai.*.{$id}"] = [
                'required',
                'numeric',
                'min:1',
                "max:{$max}"
            ];

            $customMessages["nilai.*.{$id}.max"] = "Nilai untuk kriteria {$criteria->kodekriteria} tidak boleh lebih dari {$max}";
            $customMessages["nilai.*.{$id}.min"] = "Nilai untuk kriteria {$criteria->kodekriteria} tidak boleh kurang dari 1";
        }

        // Validasi input
        $validated = $request->validate($rules, $customMessages);

        // Simpan nilai input ke session
        session(['input_values' => $validated['nilai']]);

        // Ambil data dari session
        $plantIds = session('selected_plants');
        $plants = PlantModel::whereIn('idplant', $plantIds)->get();
        $criterias = KriteriaModel::all();

        // Lakukan perhitungan MAUT
        $results = $this->calculateMaut($validated['nilai'], $plants, $criterias);
        session(['calculation_results' => $results]);

        // Tampilkan hasil
        return view('officer.rekomendasi.result', [
            'breadcrumb' => $breadcrumb,
            'results' => $results,
            'criterias' => $criterias,
            'activeMenu' => $activeMenu
        ])->with('success', 'Berhasil melakukan perhitungan rekomendasi');
    }

    private function calculateMaut($nilaiInput, $plants, $criterias)
    {
        // Hitung total bobot untuk normalisasi
        $totalBobot = $criterias->sum('bobotkriteria');

        // Normalisasi bobot kriteria
        $normalizedWeights = [];
        foreach ($criterias as $criteria) {
            $normalizedWeights[$criteria->idkriteria] = $criteria->bobotkriteria / $totalBobot;
        }

        // Hitung nilai min dan max untuk setiap kriteria
        $criteriaRanges = [];
        foreach ($criterias as $criteria) {
            $values = [];
            foreach ($plants as $plant) {
                if (isset($nilaiInput[$plant->idplant][$criteria->idkriteria])) {
                    $values[] = $nilaiInput[$plant->idplant][$criteria->idkriteria];
                }
            }
            $criteriaRanges[$criteria->idkriteria] = [
                'min' => !empty($values) ? min($values) : 0,
                'max' => !empty($values) ? max($values) : 0,
                'type' => $criteria->jeniskriteria
            ];
        }

        // Proses perhitungan MAUT
        $results = [];
        foreach ($plants as $plant) {
            $totalUtility = 0;
            $detail = [];

            foreach ($criterias as $criteria) {
                $nilai = $nilaiInput[$plant->idplant][$criteria->idkriteria] ?? 0;
                $minValue = $criteriaRanges[$criteria->idkriteria]['min'];
                $maxValue = $criteriaRanges[$criteria->idkriteria]['max'];
                $range = $maxValue - $minValue;

                // Normalisasi nilai (r*_ij)
                if ($range == 0) {
                    $normalizedValue = 0; // Handle division by zero
                } else {
                    if ($criteria->jeniskriteria == 'benefit') {
                        $normalizedValue = (($nilai - $minValue) / ($maxValue - $minValue));
                    } else { // cost
                        $normalizedValue = 1 + (($minValue - $nilai) / ($maxValue - $minValue));
                    }
                }

                // Hitung Utilitas Marginal (U_ij)
                $marginalUtility = (exp(pow($normalizedValue, 2)) - 1) / 1.71;

                // Hitung kontribusi kriteria dengan bobot (U_ij * W_j)
                $weightedUtility = $marginalUtility * $normalizedWeights[$criteria->idkriteria];
                $totalUtility += $weightedUtility;

                $detail[] = [
                    'kode' => $criteria->kodekriteria,
                    'nama' => $criteria->namakriteria,
                    'jenis' => $criteria->jeniskriteria,
                    'nilai_input' => $nilai,
                    'min' => $minValue,
                    'max' => $maxValue,
                    'normalized' => $normalizedValue,
                    'marginal_utility' => $marginalUtility, // Nilai utilitas marginal
                    'bobot' => $normalizedWeights[$criteria->idkriteria],
                    'weighted_utility' => $weightedUtility
                ];
            }

            $results[] = [
                'plant' => $plant,
                'total_utility' => $totalUtility,
                'detail' => $detail
            ];
        }

        // Urutkan berdasarkan total utility tertinggi
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
            'list' => ['DSS Batching Plant', 'Rekomendasi', 'Pilih Plant']
        ];

        $activeMenu = 'rekomendasi';

        $plants = PlantModel::where('status', 'aktif')->get();

        return view('officer.rekomendasi.select-plants', [
            'breadcrumb' => $breadcrumb,
            'plants' => $plants,
            'activeMenu' => $activeMenu
        ]);
    }

    public function storePlants(Request $request)
    {
        $request->validate(
            [
                'plants' => 'required|array|min:2',
                'plants.*' => 'exists:plant,idplant'
            ],
            [
                'plants.min' => 'Pilih minimal 2 Plant untuk dinilai'
            ]
        );

        // Simpan ke session
        session(['selected_plants' => $request->plants]);

        return redirect()->route('officer.rekomendasi.input-nilai');
    }

    public function inputNilai()
    {
        $breadcrumb = (object) [
            'title' => 'Form Penilaian Plant',
            'list' => ['DSS Batching Plant', 'Rekomendasi', 'Form Penilaian Plant']
        ];

        $activeMenu = 'rekomendasi';

        // Ambil dari session
        $plantIds = session('selected_plants');

        if (!$plantIds || count($plantIds) < 2) {
            return redirect()->route('officer.rekomendasi.select-plants')
                ->with('error', 'Silakan pilih minimal 2 plant terlebih dahulu');
        }

        $plants = PlantModel::whereIn('idplant', $plantIds)->get();

        // Daftar nilai maksimal untuk setiap kriteria
        $maxValues = [
            'C1' => 5,  // Available Market
            'C2' => 4,  // Utilisasi Plant
            'C3' => 4,  // Avail Raw Material
            'C4' => 3,  // Break Even Point
            'C5' => 4,  // Kedekatan dengan Pasar
            'C6' => 3,  // Keamanan Investasi
            'C7' => 4,  // Biaya Investasi
            'C8' => 5,  // Biaya Operasional
            'C9' => 4,  // Dampak Lingkungan
            'C10' => 4, // Kebisingan dan Polusi
            'C11' => 3, // Kesesuaian Regulasi
            'C12' => 4, // Kompetisi Pasar
            'C13' => 5  // Aksesibilitas
        ];

        $criterias = KriteriaModel::orderByRaw('LENGTH(kodekriteria), kodekriteria')
            ->get()
            ->map(function ($criteria) use ($maxValues) {
                // Tambahkan nilai maksimal ke setiap kriteria
                $criteria->max_value = $maxValues[$criteria->kodekriteria] ?? 5;
                return $criteria;
            });

        return view('officer.rekomendasi.input-nilai', [
            'breadcrumb' => $breadcrumb,
            'plants' => $plants,
            'criterias' => $criterias,
            'activeMenu' => $activeMenu
        ]);
    }

    public function showDetail()
    {
        // 1. Validate session data
        if (!session()->has('input_values') || !session()->has('selected_plants')) {
            return redirect()->route('officer.rekomendasi.select-plants')
                ->with('error', 'Data sesi tidak lengkap. Silakan lakukan perhitungan ulang.');
        }

        try {
            $nilaiInput = session('input_values');
            $selectedPlants = session('selected_plants');

            // 2. Validate data structure
            if (!is_array($nilaiInput) || !is_array($selectedPlants)) {
                throw new \Exception("Format data sesi tidak valid");
            }

            $plants = PlantModel::whereIn('idplant', $selectedPlants)->get();
            $criterias = KriteriaModel::orderBy('bobotkriteria', 'desc')->get();

            // 3. Validate reference data
            if ($plants->isEmpty() || $criterias->isEmpty()) {
                throw new \Exception("Data referensi tidak ditemukan");
            }

            // 4. Calculate ROC weights
            $n = $criterias->count();
            $rocWeights = [];

            foreach ($criterias as $index => $criteria) {
                $rank = $index + 1;
                $rocWeight = 0;

                for ($i = $rank; $i <= $n; $i++) {
                    $rocWeight += 1 / $i;
                }
                $rocWeight = $rocWeight / $n;

                $rocWeights[$criteria->idkriteria] = $rocWeight;
            }

            // 5. Calculate total weight for normalization
            $totalBobot = $criterias->sum('bobotkriteria');
            if ($totalBobot <= 0) {
                throw new \Exception("Total bobot kriteria tidak valid");
            }

            // Normalize weights
            $normalizedWeights = $criterias->mapWithKeys(function ($criteria) use ($totalBobot) {
                return [$criteria->idkriteria => $criteria->bobotkriteria / $totalBobot];
            })->all();

            // Calculate min/max for each criteria
            $criteriaRanges = [];
            foreach ($criterias as $criteria) {
                $values = array_column($nilaiInput, $criteria->idkriteria);
                $criteriaRanges[$criteria->idkriteria] = [
                    'min' => !empty($values) ? min($values) : 0,
                    'max' => !empty($values) ? max($values) : 0,
                    'type' => $criteria->jeniskriteria
                ];
            }

            // MAUT calculation process
            $results = [];
            $normalized = [];
            $utility = [];
            $utilityROC = []; // For ROC-based utility calculation

            foreach ($plants as $plant) {
                $totalUtility = 0;
                $totalUtilityROC = 0; // For ROC-based total
                $details = [];

                foreach ($criterias as $criteria) {
                    $nilai = $nilaiInput[$plant->idplant][$criteria->idkriteria] ?? 0;
                    $minValue = $criteriaRanges[$criteria->idkriteria]['min'];
                    $maxValue = $criteriaRanges[$criteria->idkriteria]['max'];
                    $range = $maxValue - $minValue;

                    // Normalize value (r*_ij)
                    if ($range == 0) {
                        $normalizedValue = 0;
                    } else {
                        $normalizedValue = ($criteria->jeniskriteria == 'benefit')
                            ? ($nilai - $minValue) / $range
                            : 1 + (($minValue - $nilai) / $range);
                    }

                    // Calculate Marginal Utility (U_ij)
                    $marginalUtility = (exp(pow($normalizedValue, 2)) - 1) / 1.71;

                    // Calculate criteria contribution with weight (U_ij * W_j)
                    $weightedUtility = $marginalUtility * $rocWeights[$criteria->idkriteria];
                    $totalUtility += $weightedUtility;

                    // Calculate with ROC weights
                    $weightedUtilityROC = $marginalUtility * $rocWeights[$criteria->idkriteria];
                    $totalUtilityROC += $weightedUtilityROC;

                    $details[] = [
                        'kriteria_id' => $criteria->idkriteria,
                        'kode' => $criteria->kodekriteria,
                        'nama' => $criteria->namakriteria,
                        'jenis' => $criteria->jeniskriteria,
                        'nilai_input' => $nilai,
                        'min' => $minValue,
                        'max' => $maxValue,
                        'normalized' => $normalizedValue,
                        'marginal_utility' => $marginalUtility,
                        'bobot' => $rocWeights[$criteria->idkriteria],
                        'weighted_utility' => $weightedUtility,
                    ];

                    $utility[$plant->idplant][$criteria->idkriteria] = $weightedUtility;
                }

                $results[$plant->idplant] = [
                    'plant' => $plant,
                    'total_utility' => $totalUtility,
                    'detail' => $details
                ];
            }

            // Ranking results
            $rankedResults = collect($results)
                ->sortBy('total_utility')
                ->values()
                ->map(function ($item, $index) {
                    $item['rank'] = $index + 1;
                    return $item;
                })
                ->all();

            $rankedResultsROC = collect($results)
                ->sortBy('total_utility_roc')
                ->values()
                ->map(function ($item, $index) {
                    $item['rank_roc'] = $index + 1;
                    return $item;
                })
                ->all();

            $topPlant = $rankedResults[0] ?? null;
            $topPlantROC = $rankedResultsROC[0] ?? null;

            return view('officer.rekomendasi.detail', [
                'plants' => $plants,
                'criterias' => $criterias,
                'nilai' => $nilaiInput,
                'results' => $results,
                'criteriaRanges' => $criteriaRanges,
                'rankedResults' => $rankedResults,
                'rankedResultsROC' => $rankedResultsROC,
                'normalizedWeights' => $normalizedWeights,
                'rocWeights' => $rocWeights,
                'normalized' => $normalized,
                'utility' => $utility,
                'utilityROC' => $utilityROC,
                'topPlant' => $topPlant,
                'topPlantROC' => $topPlantROC,
                'breadcrumb' => (object) [
                    'title' => 'Detail Perhitungan MAUT',
                    'list' => ['DSS Batching Plant', 'Rekomendasi', 'Detail']
                ],
                'activeMenu' => 'rekomendasi'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in showDetail: ' . $e->getMessage());
            return redirect()->route('officer.rekomendasi.select-plants')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    protected function getDefaultRankedResults()
    {
        return session('calculation_results', []);
    }

    public function saveToCache(Request $request)
    {
        $user = Auth::user();
        $cacheKey = 'all_recommendation_history';

        // Validasi data sebelum menyimpan
        $calculationResults = session('calculation_results', []);
        if (!is_array($calculationResults)) {
            Log::error('Invalid calculation results format', ['results' => $calculationResults]);
            return back()->with('error', 'Format data perhitungan tidak valid');
        }

        // Pastikan ada data plant
        if (empty($calculationResults) || !isset($calculationResults[0]['plant'])) {
            return back()->with('error', 'Data plant tidak ditemukan');
        }

        $newEntry = [
            'timestamp' => now()->timestamp,
            'date' => now()->format('d M Y H:i'),
            'user' => $user->nama,
            'top_ranking' => [
                'plant_code' => $calculationResults[0]['plant']->kodealternatif,
                'plant_name' => $calculationResults[0]['plant']->namaplant,
                'score' => $calculationResults[0]['total_utility'] ?? 0
            ],
            'all_data' => [
                'results' => $calculationResults,
                'criterias' => session('criterias', []),
                'input_values' => session('input_values', []),
                'utility_values' => session('utility_values', [])
            ]
        ];

        // Ambil data yang sudah ada
        $existingHistories = Cache::get($cacheKey, []);
        if (!is_array($existingHistories)) {
            $existingHistories = [];
        }

        // Tambahkan entry baru
        array_unshift($existingHistories, $newEntry);

        // Simpan ke cache
        Cache::put($cacheKey, array_slice($existingHistories, 0, 20), now()->addDays(30));

        return redirect()->route('officer.rekomendasi.cache-history')
            ->with('success', 'Rekomendasi berhasil disimpan');
    }

    public function showCacheHistory()
    {
        $activeMenu = 'ohistory';
        $user = Auth::user();
        $cacheKey = 'all_recommendation_history';

        // Pastikan selalu mengembalikan array
        $histories = Cache::get($cacheKey, []);

        // Validasi data
        if (!is_array($histories)) {
            Log::error('Invalid history data format', ['histories' => $histories]);
            $histories = [];
        }

        return view('officer.rekomendasi.cache-history', [
            'histories' => $histories,
            'breadcrumb' => (object) [
                'title' => 'Riwayat Rekomendasi',
                'list' => ['DSS Batching Plant', 'Riwayat']
            ],
            'activeMenu' => $activeMenu,
        ]);
    }

    public function showCacheHistoryDetail($timestamp)
    {
        try {
            $user = Auth::user();
            $cacheKey = 'all_recommendation_history';
            $histories = Cache::get($cacheKey, []);

            // Validasi data history
            if (!is_array($histories)) {
                throw new \Exception("Format data cache tidak valid");
            }

            // Cari history berdasarkan timestamp
            $historyData = collect($histories)->firstWhere('timestamp', (int)$timestamp);

            if (!$historyData || !isset($historyData['all_data'])) {
                return redirect()->route('officer.rekomendasi.cache-history')
                    ->with('error', 'Data riwayat tidak ditemukan atau format tidak valid');
            }

            // Rekonstruksi data dari cache
            $allData = $historyData['all_data'];

            // Validasi data penting
            if (!isset($allData['input_values'], $allData['results'])) {
                throw new \Exception("Data penting tidak ditemukan dalam cache");
            }

            $plantIds = array_keys($allData['input_values']);
            $plants = PlantModel::whereIn('idplant', $plantIds)->get();

            if ($plants->isEmpty()) {
                throw new \Exception("Data plant tidak ditemukan");
            }

            $criterias = KriteriaModel::orderBy('bobotkriteria', 'desc')->get();

            if ($criterias->isEmpty()) {
                throw new \Exception("Data kriteria tidak ditemukan");
            }

            // Calculate ROC weights
            $n = $criterias->count();
            $rocWeights = [];
            foreach ($criterias as $index => $criteria) {
                $rank = $index + 1;
                $rocWeight = 0;

                for ($i = $rank; $i <= $n; $i++) {
                    $rocWeight += 1 / $i;
                }
                $rocWeight = $rocWeight / $n;

                $rocWeights[$criteria->idkriteria] = $rocWeight;
            }

            // Inisialisasi variabel untuk view
            $nilai = $allData['input_values'];
            $results = [];
            $normalized = [];
            $utility = [];
            $criteriaRanges = [];

            // Hitung total bobot kriteria
            $totalBobot = $criterias->sum('bobotkriteria');

            if ($totalBobot <= 0) {
                throw new \Exception("Total bobot kriteria tidak valid");
            }

            // Normalisasi bobot kriteria
            $normalizedWeights = [];
            foreach ($criterias as $criteria) {
                $normalizedWeights[$criteria->idkriteria] = $criteria->bobotkriteria / $totalBobot;
            }

            // Hitung min/max untuk setiap kriteria
            foreach ($criterias as $criteria) {
                $values = [];
                foreach ($plants as $plant) {
                    if (isset($nilai[$plant->idplant][$criteria->idkriteria])) {
                        $values[] = $nilai[$plant->idplant][$criteria->idkriteria];
                    }
                }

                $criteriaRanges[$criteria->idkriteria] = [
                    'min' => !empty($values) ? min($values) : 0,
                    'max' => !empty($values) ? max($values) : 0,
                    'type' => $criteria->jeniskriteria
                ];
            }

            // Proses perhitungan untuk setiap plant
            foreach ($plants as $plant) {
                $totalUtility = 0;
                $details = [];

                foreach ($criterias as $criteria) {
                    $nilaiInput = $nilai[$plant->idplant][$criteria->idkriteria] ?? 0;
                    $minValue = $criteriaRanges[$criteria->idkriteria]['min'];
                    $maxValue = $criteriaRanges[$criteria->idkriteria]['max'];
                    $range = $maxValue - $minValue;

                    // Normalisasi nilai (r*_ij)
                    if ($range == 0) {
                        $normalizedValue = 0;
                    } else {
                        if ($criteria->jeniskriteria == 'benefit') {
                            $normalizedValue = ($nilaiInput - $minValue) / $range;
                        } else { // cost
                            $normalizedValue = ($maxValue - $nilaiInput) / $range;
                        }
                    }

                    // Hitung Utilitas Marginal (U_ij)
                    $marginalUtility = (exp(pow($normalizedValue, 2)) - 1) / 1.71;

                    // Hitung kontribusi kriteria dengan bobot (U_ij * W_j)
                    $weightedUtility = $marginalUtility * $rocWeights[$criteria->idkriteria];
                    $totalUtility += $weightedUtility;

                    // Simpan data untuk view
                    $normalized[$plant->idplant][$criteria->idkriteria] = $normalizedValue;
                    $utility[$plant->idplant][$criteria->idkriteria] = $weightedUtility;

                    $details[] = [
                        'kriteria_id' => $criteria->idkriteria,
                        'marginal_utility' => $marginalUtility,
                        'weighted_utility' => $weightedUtility
                    ];
                }

                $results[$plant->idplant] = [
                    'plant' => $plant,
                    'total_utility' => $totalUtility,
                    'detail' => $details
                ];
            }

            // Ranking hasil
            $rankedResults = collect($results)
                ->sortBy('total_utility')
                ->values()
                ->map(function ($item, $index) {
                    $item['rank'] = $index + 1;
                    return $item;
                })
                ->all();

            // Ambil plant terbaik
            $topPlant = $rankedResults[0] ?? null;

            return view('officer.rekomendasi.cache-history-detail', [
                'historyData' => $historyData,
                'plants' => $plants,
                'criterias' => $criterias,
                'nilai' => $nilai,
                'normalized' => $normalized,
                'utility' => $utility,
                'results' => $results,
                'rankedResults' => $rankedResults,
                'topPlant' => $topPlant,
                'criteriaRanges' => $criteriaRanges,
                'normalizedWeights' => $normalizedWeights,
                'rocWeights' => $rocWeights, // Make sure this is passed to the view
                'breadcrumb' => (object) [
                    'title' => 'Detail Riwayat Perhitungan',
                    'list' => ['DSS Batching Plant', 'Rekomendasi', 'Riwayat', 'Detail']
                ],
                'timestamp' => $timestamp,
                'activeMenu' => 'history'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in showCacheHistoryDetail: ' . $e->getMessage(), [
                'exception' => $e,
                'timestamp' => $timestamp,
                'user' => Auth::id()
            ]);

            return redirect()->route('officer.rekomendasi.cache-history')
                ->with('error', 'Terjadi kesalahan saat memuat data riwayat: ' . $e->getMessage());
        }
    }

    protected function calculateCriteriaRanges($criterias, $plants, $nilai)
    {
        $ranges = [];

        foreach ($criterias as $criteria) {
            $values = [];
            foreach ($plants as $plant) {
                if (isset($nilai[$plant->idplant][$criteria->idkriteria])) {
                    $values[] = $nilai[$plant->idplant][$criteria->idkriteria];
                }
            }

            // Handle ketika tidak ada nilai
            if (empty($values)) {
                $ranges[$criteria->idkriteria] = [
                    'min' => 0,
                    'max' => 0,
                    'type' => $criteria->jeniskriteria // Tambahkan type ke range
                ];
                continue;
            }

            $ranges[$criteria->idkriteria] = [
                'min' => min($values),
                'max' => max($values),
                'type' => $criteria->jeniskriteria // Tambahkan type ke range
            ];
        }

        return $ranges;
    }

    protected function calculateNormalizedValue($value, $min, $max, $type)
    {
        $range = $max - $min;

        // Handle ketika semua nilai sama
        if ($range == 0) {
            return $type == 'benefit' ? 1 : 0; // Atau nilai default lainnya
        }

        return $type == 'benefit'
            ? ($value - $min) / $range
            : ($max - $value) / $range;
    }

    protected function getUtilityDetails($criterias, $utility, $plantId)
    {
        $details = [];

        foreach ($criterias as $criteria) {
            $details[] = [
                'kriteria_id' => $criteria->idkriteria,
                'utility' => $utility[$plantId][$criteria->idkriteria] ?? 0
            ];
        }

        return $details;
    }

    public function deleteHistory($timestamp)
    {
        $user = Auth::user();
        $cacheKey = 'all_recommendation_history';
        $histories = Cache::get($cacheKey, []);

        // Filter out the history to be deleted
        $updatedHistories = array_filter($histories, function ($history) use ($timestamp) {
            return $history['timestamp'] != $timestamp;
        });

        // Save back to cache
        Cache::put($cacheKey, $updatedHistories, now()->addDays(30));

        return redirect()->route('officer.rekomendasi.cache-history')
            ->with('success', 'Riwayat berhasil dihapus');
    }

    public function cetakpdf()
    {
        // Ambil data dari session
        $results = session('calculation_results', []);

        // Validasi data
        if (empty($results)) {
            return redirect()->back()
                ->with('error', 'Tidak ada data perhitungan untuk dicetak');
        }

        // Urutkan hasil
        usort($results, function ($a, $b) {
            return ($b['total_utility'] ?? 0) <=> ($a['total_utility'] ?? 0);
        });

        // Tambahkan ranking dan ambil plant teratas
        $rankedResults = array_map(function ($item, $index) {
            $item['rank'] = $index + 1;
            return $item;
        }, $results, array_keys($results));

        $topPlant = $rankedResults[0] ?? null;

        // Data tambahan untuk header
        $data = [
            'results' => $results,
            'topPlant' => $topPlant,
            'tanggal' => now()->format('d F Y'),
            'user' => Auth::user()->nama
        ];

        // Generate PDF
        $pdf = Pdf::loadView('officer.rekomendasi.cetak', $data);

        $pdf->setOption('defaultFont', 'Poppins');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);

        return $pdf->download('Hasil Rekomendasi Penutupan Plant.pdf');
    }

    public function printHistory($timestamp)
    {
        // Ambil data dari cache
        $user = Auth::user();
        $cacheKey = 'all_recommendation_history';
        $histories = Cache::get($cacheKey, []);

        // Cari history yang dipilih
        $selectedHistory = collect($histories)->firstWhere('timestamp', (int)$timestamp);

        // Validasi data
        if (!$selectedHistory || !isset($selectedHistory['all_data']['results'])) {
            return redirect()->back()
                ->with('error', 'Data riwayat tidak ditemukan atau tidak valid');
        }

        // Ambil dan urutkan hasil
        $results = $selectedHistory['all_data']['results'];

        // Urutkan berdasarkan total_utility (descending)
        usort($results, function ($a, $b) {
            return ($a['total_utility'] ?? 0) <=> ($b['total_utility'] ?? 0);
        });

        // Tambahkan ranking
        $rankedResults = array_map(function ($item, $index) {
            $item['rank'] = $index + 1;
            return $item;
        }, $results, array_keys($results));

        // Ambil plant teratas
        $topplant = $rankedResults[0] ?? null;

        // Data untuk PDF
        $data = [
            'results' => $results,
            'tanggal' => $selectedHistory['date'] ?? now()->format('d F Y'),
            'user' => $selectedHistory['user'] ?? 'Unknown',
            'topplant' => $topplant,
            'top_score' => number_format($selectedHistory['top_ranking']['score'] ?? 0, 4)
        ];

        // Generate PDF
        $pdf = Pdf::loadView('officer.rekomendasi.cetak-history', $data);

        $pdf->setOption('defaultFont', 'Poppins');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);

        return $pdf->download('Hasil Rekomendasi Penutupan Plant.pdf');
    }
}
