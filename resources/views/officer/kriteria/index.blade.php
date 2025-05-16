@extends('olayouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Kriteria</th>
                        <th class="text-center">Nama Kriteria</th>
                        <th class="text-center">Bobot</th>
                        <th class="text-center">Bobot Normalisasi</th>
                        <th class="text-center">Jenis Kriteria</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($okriteria as $item)
                    <tr>
                        <td class="text-center">{{ $item->idkriteria }}</td>
                        <td class="text-center">{{ $item->kodekriteria }}</td>
                        <td class="text-center">{{ $item->namakriteria }}</td>
                        <td class="text-center">{{ $item->bobotkriteria }}</td>
                        <td class="text-center">{{ number_format($item->bobotnormalisasi, 4) }}</td>
                        <td class="text-center">{{ $item->jeniskriteria }}</td>
                        <td class="text-center">
                            <a href="{{ url('/okriteria/'.$item->idkriteria) }}" class="btn btn-info btn-sm" style="background-color: #03254c  ; color: white; border-color: #03254c;">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td colspan="3" class="text-center">TOTAL</td>
                        <td class="text-center">{{ number_format($totalBobot) }}</td>
                        <td class="text-center">{{ number_format($totalBobotNormalisasi, 1) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection