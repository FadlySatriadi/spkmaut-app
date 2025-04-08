@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary" style="border-top: 3px solid #800000;">
        <div class="card-body">
            @empty($plant)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>ID Plant</th>
                        <td>{{ $plant->idplant }}</td>
                    </tr>
                    <tr>
                        <th>Kode Plant</th>
                        <td>{{ $plant->kodeplant }}</td>
                    </tr>
                    <tr>
                        <th>Nama Plant</th>
                        <td>{{ $plant->namaplant }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Plant</th>
                        <td>{{ $plant->lokasi }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $plant->status }}</td>
                    </tr>
                </table>
            @endempty
            <div class="mb-3"></div>
            <a href="{{ url('plant') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush