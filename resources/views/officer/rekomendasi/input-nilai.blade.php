@extends('olayouts.template')

@section('content')
    <div class="container">
        <form action="{{ route('officer.rekomendasi.calculate') }}" method="POST" id="calculationForm">
            @csrf

            <div class="card">
                <div class="card-header">
                    <p>Berikan nilai untuk setiap kriteria sesuai skala yang ditentukan</p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Kriteria</th>
                                @foreach ($plants as $plant)
                                    <th>{{ $plant->kodealternatif }} - {{ $plant->namaplant }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criterias as $criteria)
                                <tr>
                                    <td>
                                        <strong>{{ $criteria->kodekriteria }} - {{ $criteria->namakriteria }}</strong>
                                        <br>
                                        <small>
                                            Bobot: {{ $criteria->bobotkriteria }} ({{ $criteria->jeniskriteria }}) |
                                            Skala: 1-{{ $criteria->max_value }}
                                            <br>
                                            @if ($criteria->kodekriteria == 'C1')
                                                1: Sangat kecil, 2: Kecil, 3: Sedang, 4: Besar, 5: Sangat besar
                                            @elseif($criteria->kodekriteria == 'C2')
                                                1: Rendah, 2: Cukup, 3: Tinggi, 4: Sangat tinggi
                                            @elseif($criteria->kodekriteria == 'C3')
                                                1: Sulit & tidak konsisten, 2: Minimal, 3: Stabil, 4: Sangat stabil
                                            @elseif($criteria->kodekriteria == 'C4')
                                                1: Sangat lama, 2: Sedang, 3: Cepat
                                            @elseif($criteria->kodekriteria == 'C5')
                                                1: Sangat jauh, 2: Jauh, 3: Dekat, 4: Sangat dekat
                                            @elseif($criteria->kodekriteria == 'C6')
                                                1: Risiko tinggi, 2: Risiko sedang, 3: Aman
                                            @elseif($criteria->kodekriteria == 'C7')
                                                1: Kecil, 2: Sedang, 3: Besar, 4: Sangat besar
                                            @elseif($criteria->kodekriteria == 'C8')
                                                1: Sangat rendah, 2: Rendah, 3: Sedang, 4: Tinggi, 5: Sangat tinggi
                                            @elseif($criteria->kodekriteria == 'C9')
                                                1: Ramah lingkungan, 2: Sedikit berdampak, 3: Cukup berdampak, 4: Sangat
                                                mengganggu
                                            @elseif($criteria->kodekriteria == 'C10')
                                                1: Aman, 2: Cukup aman, 3: Buruk, 4: Sangat buruk
                                            @elseif($criteria->kodekriteria == 'C11')
                                                1: Sesuai penuh, 2: Sesuai sebagian, 3: Tidak sesuai
                                            @elseif($criteria->kodekriteria == 'C12')
                                                1: Tidak ada kompetitor, 2: Lemah, 3: Sedang, 4: Kuat
                                            @elseif($criteria->kodekriteria == 'C13')
                                                1: Sangat mudah, 2: Mudah, 3: Sedang, 4: Sulit, 5: Sangat sulit
                                            @endif
                                        </small>
                                    </td>
                                    @foreach ($plants as $plant)
                                        <td>
                                            <select name="nilai[{{ $plant->idplant }}][{{ $criteria->idkriteria }}]"
                                                class="form-control" required
                                                data-kriteria="{{ $criteria->kodekriteria }}">
                                                @for ($i = 1; $i <= $criteria->max_value; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('officer.rekomendasi.select-plants') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary custom-btn float-right"
                        style="background-color: #800000; border:#800000 1px">
                        <i class="fas fa-calculator"></i> Hitung Rekomendasi
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#calculationForm').submit(function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Memproses',
                        html: 'Sedang melakukan perhitungan...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                        didOpen: () => {
                            // Submit form setelah SweetAlert muncul
                            $('#calculationForm').off('submit').submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
