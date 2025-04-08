@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary" style="border-top: 3px solid #800000;">
        <div class="card-body">
            @empty($plant)
                <a href="{{ url('plant') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/plant/' . $plant->idplant) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode Plant</label>
                        <div class="col-11">
                            <input type="text" class="form-control" style="border: 1px solid #800000;" id="kodeplant" name="kodeplant"
                                value="{{ old('kodeplant', $plant->kodeplant) }}" required>
                            @error('kodeplant')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Plant</label>
                        <div class="col-11">
                            <input type="text" class="form-control" style="border: 1px solid #800000;" id="plant" name="plant"
                                value="{{ old('plant', $plant->plant) }}" required>
                            @error('plant')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #800000; color: white; border-color: #800000;">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('plant') }}">Kembali</a>
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