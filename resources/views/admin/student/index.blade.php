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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                <th>Foto</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $mahasiswa)
                                <tr>
                                    <td class="align-middle"> {{ $loop->iteration }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->user->name }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->user->nim }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->major->name }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->gender }} </td>
                                    <td class="align-middle"> {{ $mahasiswa->registration->name }} | {{ $mahasiswa->registration->year }} </td>
                                    <td class="align-middle">
                                        <img src="{{ Storage::url($mahasiswa->image) }}" alt="{{ $mahasiswa->user->name }}"
                                            width="75px" style="cursor: pointer;"
                                            onclick="showImageModal('{{ Storage::url($mahasiswa->image) }}')">
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
                                                <div class="modal-dialog modal-dialog-centered" role="document">
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

                                                            <table class="table table-sm table-borderless text-left">
                                                                <tr>
                                                                    <td class="col-2" rowspan="9">
                                                                        <img src="{{ Storage::url($mahasiswa->image) }}"
                                                                            alt="{{ $mahasiswa->user->name }}"
                                                                            width="120px" height=""
                                                                            style="cursor: pointer;"
                                                                            onclick="showImageModal('{{ Storage::url($mahasiswa->image) }}')">
                                                                    </td>
                                                                    <td>Nama</td>
                                                                    <td>: <b>{{ $mahasiswa->user->name }}</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td>: <b>{{ $mahasiswa->user->email }} </b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Program Studi</td>
                                                                    <td>: <b>{{ $mahasiswa->major->name }}</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pendaftaran</td>
                                                                    <td>: <b>{{ $mahasiswa->registration->name }}</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>NIM</td>
                                                                    <td>: <b>{{ $mahasiswa->user->nim }}</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jenis Kelamin</td>
                                                                    <td>: <b>{{ $mahasiswa->gender }}</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No. Handphone</td>
                                                                    <td>: <b>{{ $mahasiswa->phone }}</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tanggal Lahir</td>
                                                                    <td>: <b>{{ $mahasiswa->birthdate }}</b></td>
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
            $("#datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            });
            var a = $("#datatable-buttons").DataTable({
                lengthChange: !1,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                },
                buttons: ["copy", "excel", "pdf", "colvis"]
            });
            a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(
                "#selection-datatable").DataTable({
                select: {
                    style: "multi"
                },
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            }), $("#key-datatable").DataTable({
                keys: !0,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            }), a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(
                "#alternative-page-datatable").DataTable({
                pagingType: "full_numbers",
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            }), $("#scroll-vertical-datatable").DataTable({
                scrollY: "350px",
                scrollCollapse: !0,
                paging: !1,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            }), $("#complex-header-datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                },
                columnDefs: [{
                    visible: !1,
                    targets: -1
                }]
            }), $("#state-saving-datatable").DataTable({
                stateSave: !0,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            })
        });
    </script>
@endsection
