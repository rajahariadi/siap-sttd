@extends('admin.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Laporan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
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
                    <h4 class="card-title mb-3">Data Laporan</h4>
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
                                <option value="Pending"> Pending </option>
                                <option value="Success"> Success</option>
                                <option value="Failed"> Failed </option>
                            </select>
                        </div>
                    </div>
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap text-center"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Transaksi</th>
                                <th>Nama | NIM</th>
                                <th>Jurusan</th>
                                <th>Tagihan</th>
                                <th>Total</th>
                                <th>Tanggal Bayar</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th hidden>Gelombang</th>
                                <th hidden>Angkatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $payment)
                                <tr>
                                    <td class="align-middle"> {{ $loop->iteration }} </td>
                                    <td class="align-middle">
                                        {{ $payment->transaction_id === null ? '-' : $payment->transaction_id }}</td>
                                    <td class="align-middle"> {{ $payment->bill->student->user->name }} |
                                        {{ $payment->bill->student->user->nim }} </td>
                                    <td class="align-middle"> {{ $payment->bill->student->major->name }} </td>
                                    <td class="align-middle"> {{ $payment->bill->payment_type->name }} </td>
                                    <td class="align-middle"> {{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}
                                    <td class="align-middle"> {{ $payment->updated_at->format('d M Y H:i') }} </td>
                                    <td class="align-middle">
                                        <span
                                            class="badge {{ $payment->status === 'success' ? 'badge-success' : 'badge-danger' }} ">
                                            {{ Str::upper($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        @if ($payment->status === 'success')
                                            <button type="button" class="btn btn-primary"
                                                onclick="window.open('{{ route('admin.invoice', $payment->transaction_id) }}', '_blank')">
                                                <i class="ri-file-text-line"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td hidden>{{ $payment->bill->student->registration->name }}</td>
                                    <td hidden>{{ $payment->bill->student->registration->year }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('dataTable')
    <script>
        $(document).ready(function() {
            var table = $("#datatable-buttons").DataTable({
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
                dom: 'Bfrtip', // Mengatur tata letak elemen
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'btn btn-success mr-2', // Tambahkan class untuk styling
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                            modifier: {
                                search: 'applied' // Only export filtered data
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        className: 'btn btn-info mr-2', // Tambahkan class untuk styling
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                            modifier: {
                                search: 'applied' // Only export filtered data
                            }
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        className: 'btn btn-warning', // Tambahkan class untuk styling
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                            modifier: {
                                search: 'applied' // Only export filtered data
                            }
                        }
                    }
                ]
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
                table.column(7).search(this.value).draw(); // Kolom status adalah kolom ke-7
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
                table.column(10).search(this.value).draw();
            });
        });
    </script>
@endsection
