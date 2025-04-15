@extends('layouts.template')

@section('content')
<div class="container">
    
    @foreach($results as $index => $result)
    <div class="card mb-4">
        <div class="card-header">
            <h4>Peringkat {{ $index + 1 }} - {{ $result['plant']->namaplant }}</h4>
            <span class="badge bg-primary">Total Utility: {{ number_format($result['total_utility'], 4) }}</span>
        </div>
        
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Nilai Input</th>
                        <th>Normalisasi</th>
                        <th>Bobot</th>
                        <th>Utility</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result['detail'] as $detail)
                    <tr>
                        <td>
                            {{ $detail['kode'] }} - {{ $detail['nama'] }}
                            <br><small class="text-muted">{{ $detail['jenis'] }}</small>
                        </td>
                        <td>{{ $detail['nilai'] }}</td>
                        <td>{{ number_format($detail['normalized'], 4) }}</td>
                        <td>{{ number_format($detail['bobot'], 4) }}</td>
                        <td>{{ number_format($detail['utility'], 4) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    {{-- <a href="{{ route('rekomendasi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Hasil
    </a> --}}
</div>
@endsection