@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary" style="border-top: 3px solid #800000;">
        <div class="card-body">
            @empty($aub)
                <a href="{{ url('aub') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/aub/' . $aub->idaub) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode AUB</label>
                        <div class="col-11">
                            <input type="text" class="form-control" style="border: 1px solid #800000;" id="kodeaub" name="kodeaub"
                                value="{{ old('kodeaub', $aub->kodeaub) }}" required>
                            @error('kodeaub')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama AUB</label>
                        <div class="col-11">
                            <input type="text" class="form-control" style="border: 1px solid #800000;" id="namaaub" name="namaaub"
                                value="{{ old('namaaub', $aub->namaaub) }}" required>
                            @error('namaaub')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #800000; color: white; border-color: #800000;">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('aub') }}">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
@endpush