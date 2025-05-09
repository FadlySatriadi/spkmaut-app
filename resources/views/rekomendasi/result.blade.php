@extends('layouts.template')

<style>
    .bg-best-alternative {
        background-color: #ffcce6;
    }

    .best-alternative {
        position: relative;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(255, 204, 230, 0.3);
    }
    
    .recommendation-text {
        color: #800000;
        font-weight: bold;
    }
    
    /* Center align text in status column */
    td:nth-child(5) {
        text-align: center;
        vertical-align: middle;
    }
</style>

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Rank</th>
                            <th class="text-center">Kode Alternatif</th>
                            <th class="text-center">Nama Plant</th>
                            <th class="text-center">Total Utility</th>
                            <th class="text-center">Status</th> <!-- Added text-center class -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $index => $result)
                            <tr
                                class="{{ $index === 0 ? 'bg-best-alternative' : '' }} 
                                       {{ $index === 0 ? 'best-alternative' : '' }}">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $result['plant']->kodealternatif }}</td>
                                <td class="text-center">{{ $result['plant']->namaplant }}</td>
                                <td class="text-center">{{ number_format($result['total_utility'], 4) }}</td>
                                <td>
                                    @if($index === 0)
                                    <span class="recommendation-text">
                                        <i class="fas fa-exclamation-triangle recommendation-icon mr-2" style="color: #800000;"></i>Direkomendasikan
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
        <div class="mt-4">
            <form action="{{ route('rekomendasi.save-cache') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success" style="background-color: midnightblue; border:midnightblue">
                    <i class="fas fa-save"></i> Simpan ke Riwayat
                </button>
                <a href="{{ route('rekomendasi.detail') }}" class="btn btn-primary" style="background-color: #800000; border:#800000">
                    <i class="fas fa-calculator"></i> Lihat Detail Perhitungan
                </a>
                <a href="{{ route('rekomendasi.cetak') }}" class="btn btn-primary" style="background-color: darkgoldenrod; border:darkgoldenrod">
                    <i class="fas fa-calculator"></i> Cetak PDF
                </a>
            </form>
        </div>
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