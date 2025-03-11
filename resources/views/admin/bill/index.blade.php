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
                        <li class="breadcrumb-item active">Tagihan</li>
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
                    <h4 class="card-title">Data Tagihan</h4>
                    <div class="card-title-desc">
                        <button type="button" class="btn btn-primary waves-effect waves-light"
                            onclick="window.location.href='{{ route('admin.tagihan.create') }}'">
                            <i class="ri-add-box-line align-middle mr-1"></i>Tambah Data
                        </button>
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
                            <select class="form-control select2 mr-3" id="filter_pembayaran">
                                <option value="">-- Pilih Pembayaran --</option>
                                @foreach ($dataPembayaran as $pembayaran)
                                <option value="{{ $pembayaran->name }}"> {{ $pembayaran->name }} </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-3">
                            <select class="form-control select2 mr-3" id="filter_status">
                                <option value="">-- Pilih Status --</option>
                                <option value="Paid"> Paid </option>
                                <option value="Pending"> Pending </option>
                            </select>
                        </div>
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap text-center"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="col-2">No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <th>Pembayaran</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th class="col-2">Action</th>
                                <th hidden>Gelombang</th>
                                <th hidden>Angkatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $tagihan)
                                <tr>
                                    <td class="align-middle"> {{ $loop->iteration }} </td>
                                    <td class="align-middle"> {{ $tagihan->student->user->name }} </td>
                                    <td class="align-middle"> {{ $tagihan->student->user->nim }} </td>
                                    <td class="align-middle"> {{ $tagihan->student->major->name }} </td>
                                    <td class="align-middle"> {{ $tagihan->payment_type->name }} </td>
                                    <td class="align-middle"> {{ 'Rp ' . number_format($tagihan->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle"> <span
                                            class="badge  {{ $tagihan->status === 'paid' ? 'badge-success' : 'badge-warning' }} ">
                                            {{ Str::upper($tagihan->status) }} </span> </td>
                                    <td class="align-middle">
                                        @if ($tagihan->status === 'pending')
                                            <form action="{{ route('admin.tagihan.destroy', $tagihan->id) }}"
                                                method="post">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-info"
                                                    onclick="window.location.href='{{ route('admin.tagihan.edit', $tagihan->id) }}'">
                                                    <i class="ri-edit-line"></i>
                                                </button>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                                    data-toggle="modal"
                                                    data-target=".bs-example-modal-center{{ $tagihan->id }}"> <i
                                                        class="ri-delete-bin-line"></i></button>

                                                <!-- Modal -->
                                                <div class="modal fade bs-example-modal-center{{ $tagihan->id }}"
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
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </form>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td hidden>{{ $tagihan->student->registration->name }}</td>
                                    <td hidden>{{ $tagihan->student->registration->year }}</td>


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

                // Filter berdasarkan pembayaran
                $('#filter_pembayaran').on('change', function() {
                    table.column(4).search(this.value).draw();
                });

                // Filter berdasarkan status
                $('#filter_status').on('change', function() {
                    table.column(6).search(this.value).draw();
                });

                // Filter berdasarkan gelombang
                $('#filter_gelombang').on('change', function() {
                    var gelombang = this.value;
                    if (gelombang) {
                        // Filter berdasarkan kolom tersembunyi (indeks 8)
                        table.column(8).search('^' + gelombang + '$', true, false).draw();
                    } else {
                        table.column(8).search('').draw();
                    }
                });

                // Filter berdasarkan angkatan
                $('#filter_angkatan').on('change', function() {
                    table.column(9).search(this.value).draw();
                });

            }
        });
    </script>
@endsection
