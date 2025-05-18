@extends('layouts.template')

@section('content')
  <div class="card card-outline" style="border-top: 3px solid #800000;">
    <div class="card-body">
      <form method="POST" action="{{ url('user') }}" class="form-horizontal">
        @csrf
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">ID</label>
          <div class="col-11">
            <input type="text" class="form-control" style="border: 1px solid #800000;" id="iduser" name="iduser" value="{{ old('iduser') }}"
              required>
            @error('iduser')
              <small class="form-text text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">Username</label>
          <div class="col-11">
            <input type="text" class="form-control" style="border: 1px solid #800000;" id="username" name="username" value="{{ old('username') }}"
              required>
            @error('username')
              <small class="form-text text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">Nama</label>
          <div class="col-11">
            <input type="text" class="form-control" style="border: 1px solid #800000;" id="nama" name="nama" value="{{ old('nama') }}"
              required>
            @error('user')
              <small class="form-text text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">Role</label>
          <div class="col-11">
            <input type="text" class="form-control" style="border: 1px solid #800000;" id="role" name="role" value="{{ old('role') }}"
              required>
            @error('role')
              <small class="form-text text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">Password</label>
          <div class="col-11">
            <input type="text" class="form-control" style="border: 1px solid #800000;" id="password" name="password" value="{{ old('password') }}"
              required>
            @error('password')
              <small class="form-text text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-1 control-label col-form-label"></label>
          <div class="col-11">
            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #800000; color: white; border-color: #800000;">Simpan</button>
            <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">Kembali</a>
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