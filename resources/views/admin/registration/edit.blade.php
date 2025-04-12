@extends('admin.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Pendaftaran</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Pendaftaran</li>
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
                    <h4 class="card-title mb-3">Edit Data</h4>
                    <form action="{{ route('admin.gelombang.update', $data->id) }}" method="post" class="needs-validation">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Pendaftaran <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="name">
                                    <option value="Gelombang I" {{ $data->name == 'Gelombang I' ? 'selected' : '' }}>
                                        Gelombang I</option>
                                    <option value="Gelombang II" {{ $data->name == 'Gelombang II' ? 'selected' : '' }}>
                                        Gelombang II</option>
                                    <option value="Gelombang III"{{ $data->name == 'Gelombang III' ? 'selected' : '' }}>
                                        Gelombang III</option>
                                </select>
                                @error('name')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Tahun <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="year">
                                    <option value="2026" {{ $data->name == '2026' ? 'selected' : '' }}>2026</option>
                                    <option value="2025" {{ $data->name == '2025' ? 'selected' : '' }}>2025</option>
                                    <option value="2024" {{ $data->name == '2024' ? 'selected' : '' }}>2024</option>
                                    <option value="2023" {{ $data->name == '2023' ? 'selected' : '' }}>2023</option>
                                    <option value="2022" {{ $data->name == '2022' ? 'selected' : '' }}>2022</option>
                                    <option value="2021" {{ $data->name == '2021' ? 'selected' : '' }}>2021</option>
                                    <option value="2020" {{ $data->name == '2020' ? 'selected' : '' }}>2020</option>
                                </select>
                                @error('year')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-secondary"
                                onclick="window.location.href='{{ route('admin.gelombang.index') }}' "
                                type="button">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
