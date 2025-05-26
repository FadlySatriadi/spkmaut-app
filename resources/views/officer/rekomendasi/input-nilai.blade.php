@extends('olayouts.template')

@section('content')
    <div class="container">
        <form action="{{ route('officer.rekomendasi.calculate') }}" method="POST" id="calculationForm">
            @csrf

            <div class="card">
                <div class="card-header">
                    <p>Berikan nilai untuk setiap kriteria (skala 1-5)</p>
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
                                        {{ $criteria->kodekriteria }} - {{ $criteria->namakriteria }}
                                        <br><small>Bobot : {{ $criteria->bobotkriteria }}
                                            ({{ $criteria->jeniskriteria }})</small>
                                    </td>
                                    @foreach ($plants as $plant)
                                        <td>
                                            <input type="number"
                                                name="nilai[{{ $plant->idplant }}][{{ $criteria->idkriteria }}]"
                                                class="form-control" min="1" max="5" required>
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

                    // Validasi semua input
                    let isValid = true;
                    $('input[type="number"]').each(function() {
                        const value = parseInt($(this).val());
                        if (isNaN(value) || value < 1 || value > 5) {
                            isValid = false;
                            return false; // Keluar dari loop
                        }
                    });

                    if (!isValid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Semua nilai harus antara 1-5',
                            confirmButtonColor: '#800000'
                        });
                        return;
                    }

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
