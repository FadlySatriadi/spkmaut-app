  @extends('layouts.template')

  @section('content')
    <div class="card card-outline" style="border-top: 3px solid #800000;">
      <div class="card-body">
        <form method="POST" action="{{ url('plant') }}" class="form-horizontal">
          @csrf
          <div class="form-group row">
            <label class="col-1 control-label col-form-label">Kode AUB</label>
            <div class="col-11">
                <select name="idaub" class="form-control" style="border: 1px solid #800000;" required>
                    <option value="">- Pilih Kode AUB -</option>
                    @foreach($kodeAUBops as $aub)
                    <option value="{{ $aub->idaub }}" {{ old('idaub') == $aub->idaub ? 'selected' : '' }}>
                        {{ $aub->kodeaub }} <!-- Tampilkan kodeaub yang ingin dilihat user -->
                    </option>
                    @endforeach
                </select>
                @error('idaub')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
          <div class="form-group row">
            <label class="col-1 control-label col-form-label">Plant Kode</label>
            <div class="col-11">
              <input type="text" class="form-control" style="border: 1px solid #800000;" id="kodeplant" name="kodeplant" value="{{ old('kodeplant') }}"
                required>
              @error('kodeplant')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label class="col-1 control-label col-form-label">Kode Alternatif</label>
            <div class="col-11">
              <input type="text" class="form-control" style="border: 1px solid #800000;" id="kodealternatif" name="kodealternatif" value="{{ old('kodealternatif') }}"
                required>
              @error('kodealternatif')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label class="col-1 control-label col-form-label">Nama</label>
            <div class="col-11">
              <input type="text" class="form-control" style="border: 1px solid #800000;" id="namaplant" name="namaplant" value="{{ old('namaplant') }}"
                required>
              @error('plant')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label class="col-1 control-label col-form-label">Status</label>
            <div class="col-11">
                <select name="status" class="form-control" style="border: 1px solid #800000;" required>
                    <option value="">- Pilih Status -</option>
                    @foreach($statusOptions as $status)
                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                    @endforeach
                </select>
                @error('status')
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
      </div>
    </div>
  @endsection
  @push('css')
  @endpush
  @push('js')
  @endpush