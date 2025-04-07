@extends('layouts.template')

@section('content')
  <div class="card card-outline" style="border-top: 3px solid #800000;">
    <div class="card-body">
      <form method="POST" action="{{ url('aub') }}" class="form-horizontal">
        @csrf
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">AUB Kode</label>
          <div class="col-11">
            <input type="text" class="form-control" style="border: 1px solid #800000;" id="kodeaub" name="aub" value="{{ old('kodeaub') }}"
              required>
            @error('kodeaub')
              <small class="form-text text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">Nama AUB</label>
          <div class="col-11">
            <input type="text" class="form-control" style="border: 1px solid #800000;" id="aub" name="aub" value="{{ old('aub') }}"
              required>
            @error('aub')
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
    </div>
  </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush