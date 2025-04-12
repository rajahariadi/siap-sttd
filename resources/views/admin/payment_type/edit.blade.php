@extends('admin.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Jenis Pembayaran</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Jenis Pembayaran</li>
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
                    <form action="{{ route('admin.jenis-pembayaran.update', $data->id) }}" method="post">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Pembayaran<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                                @error('name')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="description" id="" cols="30" rows="4" class="form-control">{{ $data->description }}</textarea>
                                @error('description')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-secondary"
                                onclick="window.location.href='{{ route('admin.jenis-pembayaran.index') }}' "
                                type="button">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
