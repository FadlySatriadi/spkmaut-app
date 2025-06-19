@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary" style="border-top: 3px solid #800000;">
        <div class="card-body">
            @empty($kriteria)
                <a href="{{ url('kriteria') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/kriteria/' . $kriteria->idkriteria) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode Kriteria</label>
                        <div class="col-11">
                            <input type="text" class="form-control" style="border: 1px solid #800000;" id="kodekriteria"
                                name="kodekriteria" value="{{ old('kodekriteria', $kriteria->kodekriteria) }}" required>
                            @error('kodekriteria')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Kriteria</label>
                        <div class="col-11">
                            <input type="text" class="form-control" style="border: 1px solid #800000;" id="namakriteria"
                                name="namakriteria" value="{{ old('namakriteria', $kriteria->namakriteria) }}" required>
                            @error('namakriteria')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Urutan</label>
                        <div class="col-11">
                            <input type="number" step="0.01" class="form-control" style="border: 1px solid #800000;"
                                id="bobotkriteria" name="bobotkriteria"
                                value="{{ old('bobotkriteria', $kriteria->bobotkriteria) }}" required>
                            @error('bobotkriteria')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jenis Kriteria</label>
                        <div class="col-11">
                            <select class="form-control" style="border: 1px solid #800000;" id="jeniskriteria"
                                name="jeniskriteria" required>
                                <option value="benefit"
                                    {{ old('jeniskriteria', $kriteria->jeniskriteria) == 'benefit' ? 'selected' : '' }}>Benefit
                                </option>
                                <option value="cost"
                                    {{ old('jeniskriteria', $kriteria->jeniskriteria) == 'cost' ? 'selected' : '' }}>Cost
                                </option>
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
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
    <script>
        document.getElementById('bobotkriteria').addEventListener('input', function(e) {
            if (parseFloat(this.value) > 5) {
                this.setCustomValidity('Nilai maksimal bobot adalah 5');
                this.reportValidity();
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
@endpush
