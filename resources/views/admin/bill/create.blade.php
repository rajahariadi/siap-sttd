@extends('admin.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Tagihan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Tagihan</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Create Data</h4>
                    <form action="{{ route('admin.tagihan.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Program Studi<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="major_id" id="major_id">
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($dataJurusan as $jurusan)
                                        <option value="{{ $jurusan->id }}"> {{ $jurusan->name }} |
                                            {{ $jurusan->code }} </option>
                                    @endforeach
                                </select>
                                @error('major_id')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Pendaftaran <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="registration_id" id="registration_id">
                                    <option value="">-- Pilih Pendaftaran --</option>
                                    @foreach ($dataGelombang as $gelombang)
                                        <option value="{{ $gelombang->id }}"> {{ $gelombang->name }} |
                                            {{ $gelombang->year }} </option>
                                    @endforeach
                                </select>
                                @error('registration_id')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Pilih Mahasiswa <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="student_option" id="all_students"
                                        value="all" checked>
                                    <label class="form-check-label mr-4" for="all_students">Semua Mahasiswa</label>
                                    <input class="form-check-input" type="radio" name="student_option"
                                        id="select_students" value="select">
                                    <label class="form-check-label" for="select_students">Pilih Mahasiswa</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="student_select" style="display: none;">
                            <label for="example-search-input" class="col-md-2 col-form-label">Mahasiswa <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="student_ids[]" id="student_ids" multiple>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Pembayaran <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="payment_type_id">
                                    <option value="">-- Pilih Pembayaran --</option>
                                    @foreach ($dataPembayaran as $pembayaran)
                                        <option value="{{ $pembayaran->id }}"> {{ $pembayaran->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_type_id')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Jumlah <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control rupiah" name="amount" inputmode="numeric">
                                </div>
                                @error('amount')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-secondary"
                                onclick="window.location.href='{{ route('admin.tagihan.index') }}' "
                                type="button">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
@endsection

@section('select2')
    <script>
        $(document).ready(function() {
            $('input[name="student_option"]').change(function() {
                if ($(this).val() === 'select') {
                    $('#student_select').show();
                } else {
                    $('#student_select').hide();
                }
            });

            $('#major_id, #registration_id').change(function() {
                var majorId = $('#major_id').val();
                var registrationId = $('#registration_id').val();

                if (majorId && registrationId) {
                    $.ajax({
                        url: "{{ route('admin.tagihan.getStudents') }}",
                        type: "GET",
                        data: {
                            major_id: majorId,
                            registration_id: registrationId
                        },
                        success: function(response) {
                            $('#student_ids').empty();
                            $.each(response, function(key, value) {
                                $('#student_ids').append('<option value="' + value.id +
                                    '">' + value.name + ' | ' + value.nim + '</option>');
                            });
                            $('#student_ids').select2();
                        }
                    });
                }
            });
        });
    </script>
@endsection
