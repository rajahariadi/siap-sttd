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
                    <h4 class="card-title mb-3">Create Data</h4>
                    <form action="{{ route('admin.gelombang.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Pendaftaran <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <select class="form-control select2" name="name">
                                    <option value="">-- Pilih Pendaftaran --</option>
                                    <option value="Gelombang I">Gelombang I</option>
                                    <option value="Gelombang II">Gelombang II</option>
                                    <option value="Gelombang III">Gelombang III</option>
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
                                    <option value="">-- Pilih Tahun --</option>
                                    <option value="2026">2026</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
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
