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
                        <th class="text-center">ID AUB</th>
                        <th class="text-center">Kode AUB</th>
                        <th class="text-center">Nama AUB</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($officeraub as $item)
                    <tr>
                        <td class="text-center">{{ $item->idaub }}</td>
                        <td class="text-center">{{ $item->kodeaub }}</td>
                        <td class="text-center">{{ $item->namaaub }}</td>
                        <td class="text-center">
                            <a href="{{ url('/officeraub/'.$item->idaub) }}" class="btn btn-info btn-sm" style="background-color: #03254c  ; color: white; border-color: #03254c;">Detail</a>
                            <form method="POST" action="{{ url('/officeraub/'.$item->idaub) }}" style="display: inline-block;">
                                @csrf
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