@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-tools mb-3" style="float: right;">
            <a class="btn btn-sm mt-1" href="{{ url('plant/create') }}" 
               style="background-color: #800000; color: white;">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="GET" action="{{ url('/plant') }}" class="form-inline">
                    <!-- Filter by Kode AUB -->
                    <div class="form-group mr-2">
                        <select name="kodeaub" class="form-control">
                            <option value="">- Pilih Kode AUB -</option>
                            @foreach($filterKodeAUB as $kode)
                            <option value="{{ $kode }}" {{ request('kodeaub') == $kode ? 'selected' : '' }}>
                                {{ $kode }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Filter by Nama Plant -->
                    <div class="form-group mr-2">
                        <input type="text" name="namaplant" id="namaplant-search" class="form-control" placeholder="Nama Plant" 
                               value="{{ request('namaplant') }}" autocomplete="off">
                    </div>
                    
                    <!-- Button Filter -->
                    <button type="submit" class="btn btn-primary" style="background-color: #03254c; color: white;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </form>
            </div>
        </div>

            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Plant</th>
                        <th class="text-center">Nama Plant</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plant as $item)
                    <tr>
                        <td class="text-center">{{ $item->idplant }}</td>
                        <td class="text-center">{{ $item->kodeplant }}</td>
                        <td class="text-center">{{ $item->namaplant }}</td>
                        <td class="text-center">{{ $item->status }}</td>
                        <td class="text-center">
                            <a href="{{ url('/plant/'.$item->idplant) }}" class="btn btn-info btn-sm" style="background-color: #03254c  ; color: white; border-color: #03254c;">Detail</a>
                            <a href="{{ url('/plant/'.$item->idplant.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="{{ url('/plant/'.$item->idplant) }}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin menghapus data ini?')" style="background-color: #800000; color: white;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection