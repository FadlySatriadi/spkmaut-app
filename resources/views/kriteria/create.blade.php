@extends('layouts.template')

@section('content')
    <div class="card card-outline" style="border-top: 3px solid #800000;">
        <div class="card-body">
            <form method="POST" action="{{ url('kriteria') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Kriteria</label>
                    <div class="col-11">
                        <input type="text" class="form-control" style="border: 1px solid #800000;" id="kodekriteria"
                            name="kodekriteria" value="{{ old('kodekriteria') }}" required>
                        @error('kodekriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Kriteria</label>
                    <div class="col-11">
                        <input type="text" class="form-control" style="border: 1px solid #800000;" id="namakriteria"
                            name="namakriteria" value="{{ old('namakriteria') }}" required>
                        @error('namakriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Bobot Kriteria</label>
                    <div class="col-11">
                        <input type="number" step="0.01" class="form-control" style="border: 1px solid #800000;"
                            id="bobotkriteria" name="bobotkriteria" value="{{ old('bobotkriteria') }}" required
                            min="1" max="5">
                        @error('bobotkriteria')
                            <small class="form-text text-danger">
                                {{ $message == 'The bobotkriteria must not be greater than 5.' ? 'Nilai maksimal bobot adalah 5' : $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Jenis Kriteria</label>
                    <div class="col-11">
                        <select class="form-control" style="border: 1px solid #800000;" id="jeniskriteria"
                            name="jeniskriteria" required>
                            <option value="">Pilih Jenis Kriteria</option>
                            <option value="benefit" {{ old('jeniskriteria') == 'benefit' ? 'selected' : '' }}>Benefit
                            </option>
                            <option value="cost" {{ old('jeniskriteria') == 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                        @error('jeniskriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #800000; color: white; border-color: #800000;">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('kriteria') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
