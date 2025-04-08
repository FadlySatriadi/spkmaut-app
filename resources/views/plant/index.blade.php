@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-tools mb-3" style="float: right;">
                <a class="btn btn-sm mt-1" href="{{ url('plant/create') }}" style="background-color: #800000; color: white;">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="GET" action="{{ url('/plant') }}" class="form-inline">
                        <!-- Filter by Kode AUB -->
                        <div class="form-group mr-2">
                            <select name="kodeaub" style="border: 1px solid #800000;" class="form-control">
                                <option value="">- Pilih Kode AUB -</option>
                                @foreach ($filterKodeAUB as $kode)
                                    <option value="{{ $kode }}" {{ request('kodeaub') == $kode ? 'selected' : '' }}>
                                        {{ $kode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter by Nama Plant -->
                        <div class="form-group mr-2">
                            <input type="text" style="border: 1px solid #800000;" name="namaplant" id="namaplant-search"
                                class="form-control" placeholder="Nama Plant" value="{{ request('namaplant') }}"
                                autocomplete="off">
                        </div>

                        <!-- Filter by Status -->
                        <div class="form-group mr-2">
                            <select name="status" style="border: 1px solid #800000;" class="form-control">
                                <option value="">- Semua Status -</option>
                                @foreach ($statusOptions as $status)
                                    <option value="{{ $status }}"
                                        {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Button Filter -->
                        <button type="submit" class="btn btn-primary"
                            style= "border: 1px solid #03254c; background-color: #03254c; color: white;">
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
                    @foreach ($plant as $item)
                        <tr>
                            <td class="text-center">{{ $item->idplant }}</td>
                            <td class="text-center">{{ $item->kodeplant }}</td>
                            <td class="text-center">{{ $item->namaplant }}</td>
                            <td class="text-center">{{ $item->status }}</td>
                            <td class="text-center">
                                <a href="{{ url('/plant/' . $item->idplant) }}" class="btn btn-info btn-sm"
                                    style="background-color: #03254c  ; color: white; border-color: #03254c;">Detail</a>
                                <a href="{{ url('/plant/' . $item->idplant . '/edit') }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form method="POST" action="{{ url('/plant/' . $item->idplant) }}"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin menghapus data ini?')"
                                        style="background-color: #800000; color: white;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    {{-- Previous Page Link --}}
                    @if ($plant->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $plant->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                    @endif
            
                    {{-- Pagination Elements --}}
                    @foreach ($plant->getUrlRange(1, $plant->lastPage()) as $page => $url)
                        @if ($page == $plant->currentPage())
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
                    @if ($plant->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $plant->nextPageUrl() }}" rel="next">&raquo;</a>
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
