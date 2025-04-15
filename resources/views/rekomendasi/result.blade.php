@extends('layouts.template')

@section('content')
    <div class="container">
        <h2>Hasil Rekomendasi</h2>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Ranking Plant</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Kode Alternatif</th>
                            <th>Nama Plant</th>
                            <th>Total Utility</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result['plant']->kodealternatif }}</td>
                                <td>{{ $result['plant']->namaplant }}</td>
                                <td>{{ number_format($result['total_utility'], 4) }}</td>   
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('rekomendasi.detail') }}" class="btn btn-primary">
                <i class="fas fa-calculator"></i> Lihat Detail Perhitungan Lengkap
            </a>
        </div>
        {{-- <a href="{{ route('rekomendasi.index') }}" class="btn btn-secondary">Kembali</a> --}}
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.detail-btn').click(function() {
                    let index = $(this).data('index');
                    $('#detail-' + index).toggle();

                    // Ganti teks tombol
                    if ($(this).text() === 'Detail Perhitungan') {
                        $(this).text('Sembunyikan Detail');
                    } else {
                        $(this).text('Detail Perhitungan');
                    }
                });
            });
        </script>
    @endpush
@endsection
