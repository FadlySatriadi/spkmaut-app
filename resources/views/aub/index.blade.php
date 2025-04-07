@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-tools mb-3" style="float: right; margin-right: auto;">
            <a class="btn btn-sm mt-1" href="{{ url('aub/create') }}" 
               style="background-color: #800000; color: white; border-color: #800000;">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama AUB</th>
                    <th>Kode AUB</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aub as $item)
                <tr>
                    <td>{{ $item->idaub }}</td>
                    <td>{{ $item->aub }}</td>
                    <td>{{ $item->kodeaub }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection