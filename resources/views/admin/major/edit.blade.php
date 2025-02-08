@extends('admin.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Jurusan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Jurusan</li>
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
                    <form action="{{ route('admin.jurusan.update',$data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Kode Jurusan <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="code" value="{{$data->code}}">
                                @error('code')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Jurusan <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" value="{{$data->name}}">
                                @error('name')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label">Image <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-10">
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile" accept="image/*"
                                        name="image">
                                    <label class="custom-file-label" for="customFile">{{str_replace('jurusan/','',$data->image)}}</label>
                                </div>
                                @error('image')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <img id="imagePreview" src="{{Storage::url($data->image)}}" alt="image preview" width="300px" height="250"
                                    style="display: {{ $data->image ? 'block' : 'none' }};">
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-secondary"
                                onclick="window.location.href='{{ route('admin.jurusan.index') }}' "
                                type="button">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->

    <script>
        document.getElementById('customFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('imagePreview');
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                reader.readAsDataURL(file);
                const label = document.querySelector('.custom-file-label');
                label.textContent = file.name;
            }
        });
    </script>
@endsection
