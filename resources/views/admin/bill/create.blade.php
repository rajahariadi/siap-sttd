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
                                <select class="form-control select2" name="major_id">
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
                                <select class="form-control select2" name="registration_id">
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
