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
                        <li class="breadcrumb-item active">Jurusan</li>
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
                    <h4 class="card-title">Data Jurusan</h4>
                    <div class="card-title-desc">
                        <button type="button" class="btn btn-primary waves-effect waves-light"
                            onclick="window.location.href='{{ route('admin.jurusan.create') }}'">
                            <i class="ri-add-box-line align-middle mr-1"></i>Tambah Data
                        </button>
                        <form id="sinkronForm" action="{{ route('admin.jurusan.sinkron') }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-info waves-effect waves-light">
                                <i class="ri-refresh-line align-middle mr-1"></i>Sinkron SIA
                            </button>
                        </form>
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap text-center"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="col-2">No</th>
                                <th>Kode</th>
                                <th>Jurusan</th>
                                <th>Jenjang</th>
                                <th>Akreditasi</th>
                                <th>Kaprodi</th>
                                <th>Image</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $jurusan)
                                <tr>
                                    <td class="align-middle"> {{ $loop->iteration }} </td>
                                    <td class="align-middle"> {{ $jurusan->code }} </td>
                                    <td class="align-middle"> {{ $jurusan->name }} </td>
                                    <td class="align-middle"> {{ $jurusan->jenjang }} </td>
                                    <td class="align-middle"> {{ $jurusan->akreditasi }} </td>
                                    <td class="align-middle"> {{ $jurusan->kaprodi }} </td>
                                    <td class="align-middle">
                                        <img src="{{ Storage::url($jurusan->image) }}" alt="{{ $jurusan->name }}"
                                            width="75px" style="cursor: pointer;"
                                            onclick="showImageModal('{{ Storage::url($jurusan->image) }}')">
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('admin.jurusan.destroy', $jurusan->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-info"
                                                onclick="window.location.href='{{ route('admin.jurusan.edit', $jurusan->id) }}'">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger waves-effect waves-light"
                                                data-toggle="modal"
                                                data-target=".bs-example-modal-center{{ $jurusan->id }}"> <i
                                                    class="ri-delete-bin-line"></i></button>

                                            <!-- Modal -->
                                            <div class="modal fade bs-example-modal-center{{ $jurusan->id }}"
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

                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
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
