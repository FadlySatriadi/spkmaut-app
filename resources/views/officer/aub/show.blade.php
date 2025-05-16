@extends('olayouts.template')

@section('content')
    <div class="card card-outline card-primary" style="border-top: 3px solid #800000;">
        <div class="card-body">
            @empty($oaub)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>ID AUB</th>
                        <td>{{ $oaub->idaub }}</td>
                    </tr>
                    <tr>
                        <th>Kode AUB</th>
                        <td>{{ $oaub->kodeaub }}</td>
                    </tr>
                    <tr>
                        <th>Nama AUB</th>
                        <td>{{ $oaub->namaaub }}</td>
                    </tr>
                </table>
            @endempty
            <div class="mb-3"></div>
            <a href="{{ url('officeraub') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush