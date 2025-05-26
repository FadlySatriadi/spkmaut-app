@extends('olayouts.template')

@section('content')
    <div class="container">
        <form action="{{ route('officer.rekomendasi.store-plants') }}" method="POST" id="plantForm">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <select name="plants[]" class="form-control select2" multiple required>
                            @foreach ($plants as $plant)
                                <option value="{{ $plant->idplant }}">
                                    {{ $plant->kodealternatif }} - {{ $plant->namaplant }}
                                </option>
                            @endforeach
                        </select>
                        @error('plants')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #800000; color: white; border: 1px solid #800000;">
                        Lanjut ke Input Nilai <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                placeholder: "Pilih plant...",
                width: '100%',
                minimumSelectionLength: 2
            });

            $('#plantForm').on('submit', function(e) {
                const selected = $(this).find('select[name="plants[]"]').val();

                if (!selected || selected.length < 2) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Peringatan',
                        text: 'Pilih minimal 2 Plant untuk dinilai',
                        confirmButtonColor: '#800000'
                    });
                }
            });
        });
    </script>
@endpush
