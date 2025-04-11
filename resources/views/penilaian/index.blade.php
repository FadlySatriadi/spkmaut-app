@extends('layouts.template')

@section('container')
    <h1 class="mb-4">Data Penilaian</h1>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Penilaian</h5>
            <a href="/penilaian/create" class="btn btn-primary">Tambah Penilaian</a>
        </div>
        <div class="card-body">
            <form action="/penilaian" method="get" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari alternatif..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Alternatif</th>
                            <th>Kriteria</th>
                            <th>Min/Max</th>
                            <th>Matrix Normalisasi</th>
                            <th>Hasil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penilaian as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->alternatif->kodealternatif }}</td>
                            <td>{{ $item->kriteria->namakriteria }}</td>
                            <td>{{ $item->minmax }}</td>
                            <td>{{ $item->matrixnormalisasi }}</td>
                            <td>{{ $item->hasil }}</td>
                            <td>
                                <a href="/penilaian/{{ $item->idpenilalan }}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/penilaian/{{ $item->idpenilalan }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $penilaian->links() }}
        </div>
    </div>
@endsection