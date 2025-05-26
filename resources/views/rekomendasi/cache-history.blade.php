@extends('layouts.template')

@section('content')
    <div class="container">
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });
                });
            </script>
        @endif
        <div class="card">
            <div class="card-body">
                @if (count($histories) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th style="background-color: #800000; color: white;">Tanggal</th>
                                    <th style="background-color: #800000; color: white;">User</th>
                                    <th style="background-color: #800000; color: white;">Rekomendasi Terbaik</th>
                                    <th style="background-color: #800000; color: white;">Skor</th>
                                    <th style="background-color: #800000; color: white; width: 190px; text-align: center;">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $history)
                                    <tr>
                                        <td class="text-center">{{ $history['date'] }}</td>
                                        <td class="text-center">{{ $history['user'] }}</td>
                                        <td class="text-center">
                                            <strong>{{ $history['top_ranking']['plant_code'] }}</strong> -
                                            {{ $history['top_ranking']['plant_name'] }}
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($history['top_ranking']['score'], 4) }}
                                        </td>
                                        <td style="text-align: center; padding: 8px;">
                                            <div class="d-flex justify-content-center">
                                                <!-- Button Detail -->
                                                <a href="{{ route('rekomendasi.cache-history.detail', $history['timestamp']) }}"
                                                    class="btn btn-sm btn-primary"
                                                    style="width: 90px; margin-right: 10px; background-color: #800000; color: white; border: 1px solid #800000;">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>

                                                <!-- Button Cetak PDF -->
                                                <a href="{{ route('rekomendasi.print-history', $history['timestamp']) }}"
                                                    class="btn btn-sm btn-danger" style="width: 90px; margin-right: 10px;">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a>

                                                <!-- Button Hapus -->
                                                <form
                                                    action="{{ route('rekomendasi.cache-history.delete', $history['timestamp']) }}"
                                                    method="POST" class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        style="width: 90px;" onclick="return confirm('Hapus riwayat ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Belum ada riwayat rekomendasi yang tersimpan.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
