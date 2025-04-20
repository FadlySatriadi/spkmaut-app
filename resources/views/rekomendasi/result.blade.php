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
                            <th>Rank</th>
                            <th>Kode Alternatif</th>
                            <th>Nama Plant</th>
                            <th>Total Utility</th>
                            <th class="text-center">Status</th> <!-- Added text-center class -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $index => $result)
                            <tr
                                class="{{ $index === 0 ? 'bg-best-alternative' : '' }} 
                                       {{ $index === 0 ? 'best-alternative' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result['plant']->kodealternatif }}</td>
                                <td>{{ $result['plant']->namaplant }}</td>
                                <td>{{ number_format($result['total_utility'], 4) }}</td>
                                <td>
                                    @if($index === 0)
                                        <span class="recommendation-text">Direkomendasikan untuk ditutup</span>
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
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan ke Riwayat Cache
                </button>
            </form>
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