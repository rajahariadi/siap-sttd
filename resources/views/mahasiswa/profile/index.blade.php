@extends('mahasiswa.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Profile</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    @if (session('success'))
        <div class="col-6 alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="col-6 alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-block-helper mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form action="{{ route('mahasiswa.myprofile.update') }}" method="post" enctype="multipart/form-data"> @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header font-size-16"> <b>Profile Picture</b> </div>
                    <div class="card-body text-center">
                        @if (Auth::user()->student->image == null && Auth::user()->student->gender == 'L')
                            <img id="imagePreview" class="img-fluid  mb-2"
                                src="{{ asset('assets/images/studentMale.png') }}" alt="{{ Auth::user()->name }}"
                                width="300" height="350">
                        @elseif (Auth::user()->student->image == null && Auth::user()->student->gender == 'P')
                            <img id="imagePreview" class="img-fluid  mb-2"
                                src="{{ asset('assets/images/studentFemale.png') }} " alt="{{ Auth::user()->name }}"
                                width="300" height="350">
                        @else
                            <img id="imagePreview" class="img-fluid  mb-2"
                                src=" {{ Storage::url(Auth::user()->student->image) }} " alt="{{ Auth::user()->name }}"
                                width="250" height="300">
                        @endif
                        <input type="file" id="imageUpload" name="image" accept="image/*" style="display: none;">
                        <button class="btn btn-primary" type="button"
                            onclick="document.getElementById('imageUpload').click()">
                            Upload new image
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header font-size-16"> <b>Account Details</b> </div>
                    <div class="card-body">
                        <!-- Form Group (username)-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                    @error('name')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="major">Prodi <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->student->major->name }}"  aria-label="Disabled input example" disabled readonly>
                                    @error('major')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nim">NIM <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control disable" value="{{ Auth::user()->nim }}"
                                        disabled>
                                    @error('nim')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="major">Pendaftaran <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->student->registration->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nim">Angkatan <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->student->registration->year }}" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Form Group (email address)-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email">Email <sup class="text-danger">*</sup></label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ Auth::user()->email }}">
                                    @error('email')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">No Handphone <sup class="text-danger">*</sup></label>
                                    <input type="number" class="form-control" name="phone"
                                        value="{{ Auth::user()->student->phone }}">
                                    @error('phone')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="birthdate">Tanggal Lahir <sup class="text-danger">*</sup></label>
                                    <input type="date" class="form-control" name="birthdate"
                                        value="{{ Auth::user()->student->birthdate }}">
                                    @error('birthdate')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="address">Alamat <sup class="text-danger">*</sup></label>
                                    <textarea name="address" id="" cols="30" rows="3" class="form-control">{{ Auth::user()->student->address }}</textarea>
                                    @error('address')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <div class="text-right">
                            <button class="btn btn-secondary"
                                onclick="window.location.href='{{ route('mahasiswa.home') }}' "
                                type="button">Cancel</button>
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </form>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('imagePreview').setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
