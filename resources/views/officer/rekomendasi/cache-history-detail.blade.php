@extends('olayouts.template')

@section('content')
    <style>
        .card-header-maroon {
            background-color: #800000 !important;
            color: white !important;
        }

        .table-dark {
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* Untuk semua th dalam tabel */
        .table th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .recommendation-text {
            color: #800000;
            font-weight: bold;
        }

        .bg-best-alternative {
            background-color: #ffcce6;
        }

        /* Tambahan style untuk box rekomendasi */
        .best-recommendation-box {
            border: 2px solid #800000;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff9f9;
        }

        .recommendation-header {
            color: #800000;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .recommendation-detail {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
    </style>
    <div class="container">
        <!-- Box Rekomendasi Terbaik -->
        @if (count($rankedResults) > 0)
            <div class="best-recommendation-box">
                <div class="recommendation-header">
                    <i class="fas fa-trophy"></i> Rekomendasi Terbaik
                </div>
                <div class="recommendation-detail">
                    Tanggal : {{ \Carbon\Carbon::parse($historyData['date'])->format('d M Y H:i') }}
                </div>
                <div class="recommendation-detail">
                    Plant : <strong>{{ $rankedResults[0]['plant']->kodealternatif }} -
                        {{ $rankedResults[0]['plant']->namaplant }} -
                        {{ $rankedResults[0]['plant']->aub->namaaub }}</strong>
                </div>
                <div class="recommendation-detail">
                    Skor : {{ number_format($rankedResults[0]['total_utility'], 4) }}
                </div>
            </div>
        @endif
        <div class="alert alert-info mb-4" style="text-align: center">
            <i class="fas fa-info-circle"></i> Data ini diambil dari riwayat perhitungan pada : {{ $historyData['date'] }}
        </div>

        <!-- Tabel Bobot Kriteria -->
        <div class="card mb-4">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Perbandingan Bobot Kriteria</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Kode Kriteria</th>
                                <th>Nama Kriteria</th>
                                <th>Jenis</th>
                                <th>Bobot ROC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criterias->sortByDesc('bobotkriteria') as $criteria)
                                <tr>
                                    <td>{{ $criteria->kodekriteria }}</td>
                                    <td>{{ $criteria->namakriteria }}</td>
                                    <td>{{ ucfirst($criteria->jeniskriteria) }}</td>
                                    <td>{{ number_format($rocWeights[$criteria->idkriteria] ?? 0, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total</strong></td>
                                <td>{{ number_format(array_sum($rocWeights), 4) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <p class="mt-3"><em>Metode ROC (Rank Order Centroid) digunakan untuk normalisasi bobot berdasarkan
                        peringkat kriteria</em></p>
            </div>
        </div>

        <!-- 1. Tabel Identifikasi Kriteria dan Alternatif -->
        <div class="card mb-4">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Identifikasi Kriteria dan Alternatif</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                @foreach ($criterias as $criteria)
                                    <th>{{ $criteria->kodekriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plants as $plant)
                                <tr>
                                    <td><strong>{{ $plant->kodealternatif }}</strong></td>
                                    @foreach ($criterias as $criteria)
                                        <td>{{ $nilai[$plant->idplant][$criteria->idkriteria] ?? 0 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Nilai Maksimal dan Minimal per Kriteria</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Jenis Nilai</th>
                                @foreach ($criterias as $criteria)
                                    <th>{{ $criteria->kodekriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Nilai Minimal</strong></td>
                                @foreach ($criterias as $criteria)
                                    @php
                                        $values = [];
                                        foreach ($plants as $plant) {
                                            if (isset($nilai[$plant->idplant][$criteria->idkriteria])) {
                                                $values[] = $nilai[$plant->idplant][$criteria->idkriteria];
                                            }
                                        }
                                        $min = !empty($values) ? min($values) : 0;
                                    @endphp
                                    <td>{{ $min }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td><strong>Nilai Maksimal</strong></td>
                                @foreach ($criterias as $criteria)
                                    @php
                                        $values = [];
                                        foreach ($plants as $plant) {
                                            if (isset($nilai[$plant->idplant][$criteria->idkriteria])) {
                                                $values[] = $nilai[$plant->idplant][$criteria->idkriteria];
                                            }
                                        }
                                        $max = !empty($values) ? max($values) : 0;
                                    @endphp
                                    <td>{{ $max }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 3. Normalisasi Nilai Kriteria -->
        <div class="card mb-4">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Normalisasi Nilai Kriteria</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                @foreach ($criterias as $criteria)
                                    <th>{{ $criteria->kodekriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plants as $plant)
                                <tr>
                                    <td><strong>{{ $plant->kodealternatif }}</strong></td>
                                    @foreach ($criterias as $criteria)
                                        <td>{{ number_format($normalized[$plant->idplant][$criteria->idkriteria] ?? 0, 2) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-3"><em>Rumus normalisasi :
                        Benefit = (nilai - min)/(max - min),
                        Cost = 1 + (min - nilai)/(max - min)</em></p>
            </div>
        </div>

        <!-- 4. Tabel Utilitas Marginal -->
        <div class="card mb-4">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Perhitungan Utilitas Marginal</h5>
            </div>
            <div class="card-body">
                <div class="formula-box">
                    <strong>Rumus Utilitas Marginal:</strong> U<sub>ij</sub> = (e<sup>(r*<sub>ij</sub>)²</sup> - 1) / 1.71
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($criterias as $criteria)
                                    <th>{{ $criteria->kodekriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plants as $plant)
                                <tr>
                                    <td><strong>{{ $plant->kodealternatif }}</strong></td>
                                    @foreach ($criterias as $criteria)
                                        @php
                                            $detail = collect($results[$plant->idplant]['detail'])->firstWhere(
                                                'kriteria_id',
                                                $criteria->idkriteria,
                                            );
                                        @endphp
                                        <td>{{ number_format($detail['marginal_utility'], 3) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 4. Perhitungan Nilai Kepuasan (Utility) -->
        <div class="card mb-4">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Perhitungan Nilai Utility</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                @foreach ($criterias as $criteria)
                                    <th>{{ $criteria->kodekriteria }}</th>
                                @endforeach
                                <th>Total Utility</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plants as $plant)
                                <tr>
                                    <td><strong>{{ $plant->kodealternatif }}</strong></td>
                                    @foreach ($criterias as $criteria)
                                        <td>{{ number_format($utility[$plant->idplant][$criteria->idkriteria], 3) }}</td>
                                    @endforeach
                                    <td class="table-success">
                                        {{ number_format($results[$plant->idplant]['total_utility'], 5) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-3"><em>Utility = Nilai Normalisasi Marginal × Bobot Normalisasi Kriteria</em></p>
            </div>
        </div>

        <!-- 5. Hasil Perangkingan -->
        <div class="card">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Hasil Perangkingan</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Ranking</th>
                            <th>Kode Alternatif</th>
                            <th>AUB</th>
                            <th>Nama Plant</th>
                            <th>Total Utility</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rankedResults as $index => $result)
                            <tr
                                class="{{ $index === 0 ? 'bg-best-alternative' : '' }} 
                               {{ $index === 0 ? 'best-alternative' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result['plant']->kodealternatif }}</td>
                                <td>{{ $result['plant']->aub->namaaub }}</td>
                                <td>{{ $result['plant']->namaplant }}</td>
                                <td>{{ number_format($result['total_utility'], 5) }}</td>
                                <td>
                                    @if ($index === 0)
                                        <span class="recommendation-text">
                                            <i class="fas fa-exclamation-triangle recommendation-icon mr-2"
                                                style="color: #800000;"></i>Direkomendasikan
                                            untuk ditutup
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="alert alert-info mb-4" style="text-align: center">
            <i class="fas fa-info-circle"></i> Berdasarkan hasil perhitungan yang dilakukan menggunakan metode <em>Multi
                Attribute Utility Theory</em> didapat hasil bahwa Batching Plant
            <strong>"{{ $topPlant['plant']->namaplant ?? 'N/A' }}"</strong> dari
            <strong>{{ $topPlant['plant']->aub->namaaub ?? 'N/A' }}</strong>
            direkomendasikan untuk <strong>DITUTUP.</strong> Segala
            bentuk pengambilan keputusan sepenuhnya tetap berada dalam wewenang stakeholder terkait.
        </div>

        <div class="mt-4">
            <a href="{{ route('officer.rekomendasi.cache-history') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
            </a>
            <a href="{{ route('officer.rekomendasi.print-history', $timestamp) }}" class="btn btn-primary"
                style="background-color: #800000; color: white; border: 1px solid #800000;">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    </div>
@endsection
