@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-tools mb-3" style="float: right;">
            <a class="btn btn-sm mt-1" href="{{ url('alternatif/create') }}" 
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
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Alternatif</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alternatif as $item)
                    <tr>
                        <td class="text-center">{{ $item->idalternatif }}</td>
                        <td class="text-center">{{ $item->kodealternatif }}</td>
                        <td class="text-center">
                            <a href="{{ url('/alternatif/'.$item->idalternatif) }}" class="btn btn-info btn-sm" style="background-color: #03254c  ; color: white; border-color: #03254c;">Detail</a>
                            <a href="{{ url('/alternatif/'.$item->idalternatif.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="{{ url('/alternatif/'.$item->idalternatif) }}" style="display: inline-block;">
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
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    {{-- Previous Page Link --}}
                    @if ($alternatif->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $alternatif->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                    @endif
            
                    {{-- Pagination Elements --}}
                    @foreach ($alternatif->getUrlRange(1, $alternatif->lastPage()) as $page => $url)
                        @if ($page == $alternatif->currentPage())
                            <li class="page-item active">
                                <span class="page-link" style="background-color: #800000; border-color: #800000;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
            
                    {{-- Next Page Link --}}
                    @if ($alternatif->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $alternatif->nextPageUrl() }}" rel="next">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
            <style>
                /* Custom Pagination Styles */
                .page-item.active .page-link {
                    background-color: #800000 !important;
                    border-color: #800000 !important;
                }
                .page-link {
                    color: #800000;
                }
                .page-link:hover {
                    color: #600000;
                }
                .page-item.disabled .page-link {
                    color: #6c757d;
                }
            </style>
        </div>
    </div>
</div>
@endsection