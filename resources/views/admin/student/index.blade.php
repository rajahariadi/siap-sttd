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
                        <li class="breadcrumb-item active">Mahasiswa</li>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Mahasiswa</h4>
                    <div class="card-title-desc">
                        <button type="button" class="btn btn-primary waves-effect waves-light"
                            onclick="window.location.href='{{ route('admin.mahasiswa.create') }}'">
                            <i class="ri-add-box-line align-middle mr-1"></i>Tambah Data
                        </button>
                        {{-- <form action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data"
                            style="display: inline-block;">
                            @csrf
                            <button type="button" class="btn btn-success waves-effect waves-light"
                                onclick="document.getElementById('fileInput').click()">
                                <i class="ri-download-line align-middle mr-1"></i>Import Data
                            </button>
                            <input type="file" name="file" id="fileInput" style="display: none;"
                                onchange="this.form.submit()">
                        </form> --}}
                        <form id="sinkronForm" action="{{ route('admin.mahasiswa.sinkron') }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-info waves-effect waves-light">
                                <i class="ri-refresh-line align-middle mr-1"></i>Sinkron SIA
                            </button>
                        </form>
                    </div>
                    <div class="mb-2 form-inline mb-3">
                        <div class="form-group mr-3">
                            <select class="form-control select2 mr-3" id="filter_jurusan">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($dataJurusan as $jurusan)
                                    <option value="{{ $jurusan->name }}"> {{ $jurusan->name }} |
                                        {{ $jurusan->code }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-3">
                            <select class="form-control select2 mr-3" id="filter_gelombang">
                                <option value="">-- Pilih Gelombang --</option>
                                @foreach ($dataGelombang as $gelombang)
                                    <option value="{{ $gelombang->name }}"> {{ $gelombang->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-3">
                            <select class="form-control select2 mr-3" id="filter_angkatan">
                                <option value="">-- Pilih Angkatan --</option>
                                @foreach ($dataAngkatan as $angkatan)
                                    <option value="{{ $angkatan->year }}"> {{ $angkatan->year }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-3">
                            <select class="form-control select2 mr-3" id="filter_status">
                                <option value="">-- Pilih Status --</option>
                                @foreach ($dataStatus as $status)
                                    <option value="{{ $status->name }}"> {{ $status->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap text-center"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="col-2">No</th>
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Jurusan</th>
                                <th>Jenis Kelamin</th>
                                <th>Pendaftaran</th>
                                <th>Status</th>
                                <th>Foto</th>
                                <th class="col-2">Action</th>
                                <th hidden>Gelombang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $mahasiswa)
                                <tr>
                                    <td class="align-middle"> {{ $loop->iteration }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->user->name }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->user->nim }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->major->name }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                    <td class="align-middle"> {{ $mahasiswa->registration->name }} |
                                        {{ $mahasiswa->registration->year }} </td>
                                    <td class="align-middle">
                                        @php
                                            $statusClass = match ($mahasiswa->statusStudent->name) {
                                                'Aktif' => 'success',
                                                'Cuti' => 'warning',
                                                'Drop-out' => 'danger',
                                                'Keluar' => 'danger',
                                                'Lulus' => 'primary',
                                                'Pasif' => 'secondary',
                                                'Tunggu Ujian' => 'warning',
                                                default => 'info',
                                            };
                                        @endphp
                                        <div class="badge badge-soft-{{ $statusClass }} font-size-14">
                                            {{ Str::ucfirst($mahasiswa->statusStudent->name) }}
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @if ($mahasiswa->image === null && $mahasiswa->gender === 'L')
                                            <img src="{{ asset('assets/images/studentMale.png') }}"
                                                alt="{{ $mahasiswa->user->name }}" class="img-fluid"
                                                style="cursor: pointer;"
                                                onclick="showImageModal('{{ asset('assets/images/studentMale.png') }}')">
                                        @elseif ($mahasiswa->image === null && $mahasiswa->gender === 'P')
                                            <img src="{{ asset('assets/images/studentFemale.png') }}"
                                                alt="{{ $mahasiswa->user->name }}" class="img-fluid"
                                                style="cursor: pointer;"
                                                onclick="showImageModal('{{ asset('assets/images/studentFemale.png') }}')">
                                        @else
                                            <img src="{{ Storage::url($mahasiswa->image) }}"
                                                alt="{{ $mahasiswa->user->name }}"class="img-fluid"
                                                style="cursor: pointer;"
                                                onclick="showImageModal('{{ Storage::url($mahasiswa->image) }}')">
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa->id) }}"
                                            method="post"> @csrf @method('DELETE')
                                            <button type="button" class="btn btn-info"
                                                onclick="window.location.href='{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}'">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning waves-effect waves-light"
                                                data-toggle="modal" data-target="#detailModal{{ $mahasiswa->id }}">
                                                <i class="ri-eye-line"></i>
                                            </button>

                                            <!-- Modal Detail Mahasiswa -->
                                            <div class="modal fade" id="detailModal{{ $mahasiswa->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <!-- Tambahkan modal-lg untuk modal yang lebih lebar -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailModalLabel">Detail Mahasiswa
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div
                                                                    class="col-md-4 d-flex align-items-center justify-content-center">
                                                                    @if ($mahasiswa->image === null && $mahasiswa->gender === 'L')
                                                                        <img src="{{ asset('assets/images/studentMale.png') }}"
                                                                            alt="{{ $mahasiswa->user->name }}"
                                                                            style="cursor: pointer;" class="img-fluid"
                                                                            onclick="showImageModal('{{ asset('assets/images/studentMale.png') }}')">
                                                                    @elseif ($mahasiswa->image === null && $mahasiswa->gender === 'P')
                                                                        <img src="{{ asset('assets/images/studentFemale.png') }}"
                                                                            alt="{{ $mahasiswa->user->name }}"
                                                                            style="cursor: pointer;" class="img-fluid"
                                                                            onclick="showImageModal('{{ asset('assets/images/studentFemale.png') }}')">
                                                                    @else
                                                                        <img src="{{ Storage::url($mahasiswa->image) }}"
                                                                            alt="{{ $mahasiswa->user->name }}"
                                                                            style="cursor: pointer;" class="img-fluid"
                                                                            onclick="showImageModal('{{ Storage::url($mahasiswa->image) }}')">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <table
                                                                        class="table table-striped table-responsive table-sm text-left">
                                                                        <tr>
                                                                            <td>Nama</td>
                                                                            <td>: <b>{{ $mahasiswa->user->name }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Email</td>
                                                                            <td>: <b>{{ $mahasiswa->user->email }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Program Studi</td>
                                                                            <td>: <b>{{ $mahasiswa->major->name }} | {{ $mahasiswa->major->code }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Pendaftaran</td>
                                                                            <td>:
                                                                                <b>{{ $mahasiswa->registration->name }} | {{ $mahasiswa->registration->year }}</b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>NIM</td>
                                                                            <td>: <b>{{ $mahasiswa->user->nim }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Status</td>
                                                                            <td>: <b>{{ $mahasiswa->statusStudent->name }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Jenis Kelamin</td>
                                                                            <td>:
                                                                                <b>{{ $mahasiswa->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>No. Handphone</td>
                                                                            <td>: <b>{{ $mahasiswa->phone }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Tanggal Lahir</td>
                                                                            <td>:
                                                                                <b>{{ \Carbon\Carbon::parse($mahasiswa->birthdate)->translatedFormat('d F Y') }}</b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Alamat</td>
                                                                            <td>: <b>{{ $mahasiswa->address }}</b></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger waves-effect waves-light"
                                                data-toggle="modal"
                                                data-target=".bs-example-modal-center{{ $mahasiswa->id }}"> <i
                                                    class="ri-delete-bin-line"></i></button>

                                            <!-- Modal -->
                                            <div class="modal fade bs-example-modal-center{{ $mahasiswa->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Are you sure want to delete this data ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-secondary"data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

                                        </form>
                                    </td>
                                    <td hidden>{{ $mahasiswa->registration->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
                        aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="modalImage" src="" class="img-fluid" alt="Preview Gambar">
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function showImageModal(imageUrl) {
                            document.getElementById('modalImage').src = imageUrl;
                            $('#imageModal').modal('show');
                        }
                    </script>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('dataTable')
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2();

            // Inisialisasi DataTable untuk #datatable
            if (!$.fn.DataTable.isDataTable('#datatable')) {
                var table = $('#datatable').DataTable({
                    language: {
                        paginate: {
                            previous: "<i class='mdi mdi-chevron-left'>",
                            next: "<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback: function() {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    }
                });

                // Filter berdasarkan jurusan
                $('#filter_jurusan').on('change', function() {
                    table.column(3).search(this.value).draw();
                });

                // Filter berdasarkan gelombang
                $('#filter_gelombang').on('change', function() {
                    var gelombang = this.value;
                    if (gelombang) {
                        // Filter berdasarkan kolom tersembunyi (indeks 8)
                        table.column(9).search('^' + gelombang + '$', true, false).draw();
                    } else {
                        table.column(9).search('').draw();
                    }
                });

                // Filter berdasarkan angkatan
                $('#filter_angkatan').on('change', function() {
                    table.column(5).search(this.value).draw();
                });

                // Filter berdasarkan status
                $('#filter_status').on('change', function() {
                    table.column(6).search(this.value).draw();
                });
            }
        });
    </script>
@endsection

@section('sweet-alerts')
    <script>
        document.getElementById('sinkronForm').addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Memproses Sinkronisasi',
                text: 'Harap tunggu...',
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(this.action, {
                    method: this.method,
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat melakukan sinkronisasi.',
                    });
                });
        });
    </script>
@endsection
