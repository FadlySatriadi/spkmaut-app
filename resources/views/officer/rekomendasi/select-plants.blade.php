@extends('olayouts.template')

@section('content')
<div class="container">
    <form action="{{ route('officer.rekomendasi.store-plants') }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <select name="plants[]" class="form-control select2" multiple required>
                        @foreach($plants as $plant)
                            <option value="{{ $plant->idplant }}">
                                {{ $plant->kodealternatif }} - {{ $plant->namaplant }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" style="background-color: #800000; color: white; border: 1px solid #800000;">
                    Lanjut ke Input Nilai <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: "Pilih plant...",
            width: '100%'
        });
    });
</script>
@endpush