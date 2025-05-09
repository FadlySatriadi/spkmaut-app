@extends('layouts.template')

@section('content')
<div class="container">
    <form action="{{ route('rekomendasi.calculate') }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <p>Berikan nilai untuk setiap kriteria (skala 1-10)</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Kriteria</th>
                            @foreach($plants as $plant)
                                <th>{{ $plant->kodealternatif }} - {{ $plant->namaplant }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criterias as $criteria)
                            <tr>
                                <td>
                                    {{ $criteria->kodekriteria }} - {{ $criteria->namakriteria }}
                                    <br><small>Bobot : {{ $criteria->bobotkriteria }} ({{ $criteria->jeniskriteria }})</small>
                                </td>
                                @foreach($plants as $plant)
                                    <td>
                                        <input type="number" 
                                               name="nilai[{{ $plant->idplant }}][{{ $criteria->idkriteria }}]" 
                                               class="form-control" 
                                               min="0" max="10" 
                                               required>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('rekomendasi.select-plants') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary custom-btn float-right" style="background-color: #800000; border:#800000 1px">
                    <i class="fas fa-calculator"></i> Hitung Rekomendasi
                </button>
            </div>
        </div>
    </form>
</div>
@endsection