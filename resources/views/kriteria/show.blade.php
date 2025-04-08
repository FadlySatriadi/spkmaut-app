@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary" style="border-top: 3px solid #800000;">
        <div class="card-body">
            @empty($kriteria)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>No</th>
                        <td>{{ $kriteria->idkriteria }}</td>
                    </tr>
                    <tr>
                        <th>Kode Kriteria</th>
                        <td>{{ $kriteria->kodekriteria }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kriteria</th>
                        <td>{{ $kriteria->namakriteria }}</td>
                    </tr>
                    <tr>
                        <th>Bobot</th>
                        <td>{{ $kriteria->bobotkriteria }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $kriteria->deskripsi }}</td>
                    </tr>
                </table>
            @endempty
            <div class="mb-3"></div>
            <a href="{{ url('kriteria') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush