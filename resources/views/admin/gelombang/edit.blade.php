@extends('admin.index')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Data Akademik</li>
                        <li class="breadcrumb-item"><a class="text-decoration-none"
                                href="{{ route('admin.gelombangs.index') }}">Data Gelombang</a></li>
                        <li class="breadcrumb-item active">Edit Gelombang</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Gelombang</h4>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="col-sm-6 col-md-6">
                        <br>
                        <form action="{{ route('admin.gelombangs.update', $dataGelombang->id) }}" method="post"> @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="name"
                                        value="{{ $dataGelombang->name }}">
                                    @error('name')
                                        <div class="mt-2 text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('admin.gelombangs.index') }}" class="btn btn-secondary">Cancel</a>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <!-- end row -->
@endsection
