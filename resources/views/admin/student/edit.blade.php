@extends('admin.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Mahasiswa</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Mahasiswa</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Data</h4>
                    <div id="basic-pills-wizard" class="twitter-bs-wizard">
                        <ul class="twitter-bs-wizard-nav">
                            <li class="nav-item">
                                <a href="#user-details" class="nav-link" data-toggle="tab">
                                    <span class="step-number">01</span>
                                    <span class="step-title">Detail User</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#student-details" class="nav-link" data-toggle="tab">
                                    <span class="step-number">02</span>
                                    <span class="step-title">Detail Mahasiswa</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#upload-photo" class="nav-link" data-toggle="tab">
                                    <span class="step-number">03</span>
                                    <span class="step-title">Upload Photo</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#confirm-detail" class="nav-link" data-toggle="tab">
                                    <span class="step-number">04</span>
                                    <span class="step-title">Konfirmasi Data</span>
                                </a>
                            </li>
                        </ul>
                        <form action="{{ route('admin.mahasiswa.update', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <!-- Step 1: User Details -->
                                <div class="tab-pane" id="user-details">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Nama <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $data->user->name }}">
                                                @error('name')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Email <sup class="text-danger">*</sup></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $data->user->email }}">
                                                @error('email')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password">Password <sup class="text-danger">*</sup></label>
                                                <input type="password" class="form-control" id="password" name="password">
                                                @error('password')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password <sup
                                                        class="text-danger">*</sup></label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation">
                                                @error('password_confirmation')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div> --}}
                                    </div>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous">
                                            <button class="btn btn-secondary" type="button"
                                                onclick="window.location.href='{{ route('admin.mahasiswa.index') }}'">Cancel</button>
                                        </li>
                                        <li class="next">
                                            <a href="#" id="next-button">Next</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Step 2: Student Details -->
                                <div class="tab-pane" id="student-details">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="major_id">Program Studi <sup class="text-danger">*</sup></label>
                                                <select class="form-control select2" name="major_id" id="major_id">
                                                    @foreach ($dataJurusan as $jurusan)
                                                        <option value="{{ $jurusan->id }}"
                                                            {{ $data->jurusan_id === $jurusan->id ? 'selected' : '' }}>
                                                            {{ $jurusan->name }} |
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
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="registration_id">Pendaftaran <sup
                                                        class="text-danger">*</sup></label>
                                                <select class="form-control select2" name="registration_id"
                                                    id="registration_id">
                                                    @foreach ($dataGelombang as $gelombang)
                                                        <option value="{{ $gelombang->id }}"
                                                            {{ $data->registration_id === $gelombang->id ? 'selected' : '' }}>
                                                            {{ $gelombang->name }} |
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
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nim">NIM <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control" id="nim" name="nim"
                                                    value="{{ $data->user->nim }}">
                                                @error('nim')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="gender">Jenis Kelamin <sup
                                                        class="text-danger">*</sup></label>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        value="L" id="laki-laki"
                                                        {{ $data->gender === 'L' ? 'checked' : '' }}>
                                                    <label class="form-check-label mr-4" for="laki-laki">Laki-laki</label>
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        value="P" id="perempuan"
                                                        {{ $data->gender === 'P' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                                </div>
                                                @error('gender')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"> <a href="#">Previous</a></li>
                                        <li class="next">
                                            <a href="#" id="next-button">Next</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Step 3: Upload Photo -->
                                <div class="tab-pane" id="upload-photo">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="phone">No Handphone <sup
                                                        class="text-danger">*</sup></label>
                                                <input type="number" class="form-control" id="phone" name="phone"
                                                    value="{{ $data->phone }}">
                                                @error('phone')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="birthdate">Tanggal Lahir <sup
                                                        class="text-danger">*</sup></label>
                                                <input type="date" class="form-control" id="birthdate"
                                                    name="birthdate" value="{{ $data->birthdate }}">
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
                                                <textarea class="form-control" id="address" name="address" rows="2">{{ $data->address }}</textarea>
                                                @error('address')
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
                                                <label for="image">Pas Foto</label>
                                                <div class="custom-file mb-3">
                                                    <input type="file" class="custom-file-input" id="customFile"
                                                        accept="image/*" name="image">
                                                    <label class="custom-file-label" for="customFile">
                                                        {{ str_replace('mahasiswa/', '', $data->image) }} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"> <a href="#">Previous</a></li>
                                        <li class="next">
                                            <a href="#" id="next-button">Next</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Step 4: Confirm Details -->
                                <div class="tab-pane" id="confirm-detail">
                                    <h5>Confirm Your Details</h5>

                                    <table class="table table-striped ">
                                        <tr>
                                            <th rowspan="9" class="align-middle">
                                                <div
                                                    style="text-align: center; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                    @if ($data->image == null && $data->gender == 'P')
                                                        <img id="imagePreview"
                                                            src="{{ asset('assets/images/studentFemale.png') }}"
                                                            alt="image preview" width="350" height="400">
                                                    @elseif ($data->image == null && $data->gender == 'L')
                                                        <img id="imagePreview"
                                                            src="{{ asset('assets/images/studentMale.png') }}"
                                                            alt="image preview" width="350" height="400">
                                                    @else
                                                        <img id="imagePreview" src="{{ Storage::url($data->image) }}"
                                                            alt="image preview" width="300" height="400"
                                                            style="display: {{ $data->image ? 'block' : 'none' }};">
                                                    @endif
                                                </div>
                                            </th>
                                            <th>Nama</th>
                                            <th id="confirm-name"></th>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td id="confirm-email"></td>
                                        </tr>
                                        <tr>
                                            <td>Program Studi</td>
                                            <td id="confirm-major"></td>
                                        </tr>
                                        <tr>
                                            <td>NIM</td>
                                            <td id="confirm-nim"></td>
                                        </tr>
                                        <tr>
                                            <td>Pendaftaran</td>
                                            <td id="confirm-registration"></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td id="confirm-gender"></td>
                                        </tr>
                                        <tr>
                                            <td>No Handphone</td>
                                            <td id="confirm-phone"></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Lahir</td>
                                            <td id="confirm-birthdate"></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td id="confirm-address"></td>
                                        </tr>
                                    </table>

                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"> <a href="#">Previous</a></li>
                                        <li class="next">
                                            <button class="btn btn-primary" type="">Submit</button>
                                        </li>
                                    </ul>

                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const registrationSelect = document.getElementById('registration_id');
        const majorSelect = document.getElementById('major_id');
        const nimInput = document.getElementById('nim');
        const genderInputs = document.getElementsByName('gender');
        const phoneInput = document.getElementById('phone');
        const birthdateInput = document.getElementById('birthdate');
        const addressInput = document.getElementById('address');

        const confirmName = document.getElementById('confirm-name');
        const confirmEmail = document.getElementById('confirm-email');
        const confirmRegistration = document.getElementById('confirm-registration');
        const confirmMajor = document.getElementById('confirm-major');
        const confirmNim = document.getElementById('confirm-nim');
        const confirmGender = document.getElementById('confirm-gender');
        const confirmPhone = document.getElementById('confirm-phone');
        const confirmBirthdate = document.getElementById('confirm-birthdate');
        const confirmAddress = document.getElementById('confirm-address');

        // Fungsi untuk update teks di <p> berdasarkan input
        function updateConfirmation() {
            confirmName.textContent = ': ' + nameInput.value;
            confirmEmail.textContent = ': ' + emailInput.value;
            confirmNim.textContent = ': ' + nimInput.value;

            const selectedRegistrationOption = registrationSelect.options[registrationSelect.selectedIndex];
            const registrationName = selectedRegistrationOption ? selectedRegistrationOption.text : '';
            confirmRegistration.textContent = ': ' + registrationName;

            const selectedMajorOption = majorSelect.options[majorSelect.selectedIndex];
            const majorName = selectedMajorOption ? selectedMajorOption.text : '';
            confirmMajor.textContent = ': ' + majorName;

            let genderText = '';
            for (let gender of genderInputs) {
                if (gender.checked) {
                    genderText = gender.value === 'L' ? 'Laki-laki' : 'Perempuan';
                    break;
                }
            }
            confirmGender.textContent = ': ' + genderText;

            confirmPhone.textContent = ': ' + phoneInput.value;
            confirmBirthdate.textContent = ': ' + birthdateInput.value;
            confirmAddress.textContent = ': ' + addressInput.value;
        }

        // Menambahkan event listener pada input untuk update <p> setiap kali ada perubahan
        nameInput.addEventListener('input', updateConfirmation);
        emailInput.addEventListener('input', updateConfirmation);
        registrationSelect.addEventListener('change', updateConfirmation);
        majorSelect.addEventListener('change', updateConfirmation);
        nimInput.addEventListener('input', updateConfirmation);
        for (let gender of genderInputs) {
            gender.addEventListener('change', updateConfirmation);
        }
        phoneInput.addEventListener('input', updateConfirmation);
        birthdateInput.addEventListener('input', updateConfirmation);
        addressInput.addEventListener('input', updateConfirmation);

        // Panggil updateConfirmation untuk inisialisasi saat halaman dimuat
        updateConfirmation();



        document.getElementById('name').value
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
