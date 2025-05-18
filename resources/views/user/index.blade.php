@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-tools mb-3" style="float: right;">
            <a class="btn btn-sm mt-1" href="{{ url('user/create') }}" 
               style="background-color: #800000; color: white;">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
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
                        <th class="text-center">ID User</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user as $item)
                    <tr>
                        <td class="text-center">{{ $item->iduser }}</td>
                        <td class="text-center">{{ $item->username }}</td>
                        <td class="text-center">{{ $item->nama }}</td>
                        <td class="text-center">
                            <a href="{{ url('/user/'.$item->iduser) }}" class="btn btn-info btn-sm" style="background-color: #03254c  ; color: white; border-color: #03254c;">Detail</a>
                            <a href="{{ url('/user/'.$item->iduser.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="{{ url('/user/'.$item->iduser) }}" style="display: inline-block;">
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