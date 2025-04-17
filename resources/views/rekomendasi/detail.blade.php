@extends('layouts.template')



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
    </style>
    <div class="container">

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
                <div class="mt-3">
                    <p><strong>Keterangan Kriteria :</strong></p>
                    <ul>
                        @foreach ($criterias as $criteria)
                            <li>{{ $criteria->kodekriteria }}: {{ $criteria->namakriteria }}
                                ({{ $criteria->jeniskriteria }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- 2. Proses Pembobotan Kriteria -->
        <div class="card mb-4">
            <div class="card-header card-header-maroon">
                <h5 class="text-center">Pembobotan Kriteria</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Kriteria</th>
                            <th>Bobot Awal</th>
                            <th>Bobot Normalisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($criterias as $criteria)
                            <tr>
                                <td>{{ $criteria->kodekriteria }} - {{ $criteria->namakriteria }}</td>
                                <td>{{ $criteria->bobotkriteria }}</td>
                                <td>{{ number_format($normalizedWeights[$criteria->idkriteria], 5) }}</td>
                            </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td><strong>Total</strong></td>
                            <td>{{ array_sum(array_column($criterias->toArray(), 'bobotkriteria')) }}</td>
                            <td>{{ number_format(array_sum($normalizedWeights), 5) }}</td>
                        </tr>
                    </tbody>
                </table>
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
                                        <td>{{ number_format($normalized[$plant->idplant][$criteria->idkriteria], 2) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-3"><em>Rumus normalisasi :
                        Benefit = (nilai - min)/(max - min),
                        Cost = (max - nilai)/(max - min)</em></p>
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
                                    <td class="table-success">{{ number_format($results[$plant->idplant]['total'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-3"><em>Utility = Nilai Normalisasi × Bobot Normalisasi</em></p>
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
                                <td>{{ $result['plant']->namaplant }}</td>
                                <td>{{ number_format($result['total'], 5) }}</td>
                                <td>
                                    @if ($index === 0)
                                        <span class="recommendation-text">! Direkomendasikan untuk ditutup</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{-- <a href="{{ route('rekomendasi.index') }}" class="btn btn-secondary"> --}}
            <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
