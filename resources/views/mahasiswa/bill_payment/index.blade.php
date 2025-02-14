@extends('mahasiswa.index')

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
                    <h4 class="card-title mb-3">Data Tagihan</h4>
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
                                    <td class="align-middle"> <span class="badge badge-warning ">
                                            {{ Str::upper($tagihan->status) }} </span> </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-warning pay-button"
                                            data-bill-id="{{ $tagihan->id }}">
                                            <i class="ri-wallet-line"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal untuk Snap Midtrans -->
                    <div class="" id="snapModal"></div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButtons = document.querySelectorAll('.pay-button');

            payButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const billId = this.getAttribute('data-bill-id');

                    // Cek apakah ada snapToken yang tersimpan di localStorage untuk bill ini
                    const storedSnapToken = localStorage.getItem(`snapToken_${billId}`);
                    const storedOrderId = localStorage.getItem(`orderId_${billId}`);

                    if (storedSnapToken && storedOrderId) {
                        // Gunakan snapToken yang sudah ada
                        snap.pay(storedSnapToken, {
                            onSuccess: function(result) {
                                alert('Pembayaran berhasil!');
                                handlePaymentSuccess(result);
                            },
                            onPending: function(result) {
                                alert('Pembayaran tertunda!');
                                // Tidak perlu reload halaman
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal!');
                                handlePaymentFailure(result);
                            },
                            onClose: function() {
                                alert(
                                    'Anda menutup popup pembayaran tanpa menyelesaikan transaksi.'
                                );
                                handlePaymentFailure({
                                    order_id: storedOrderId
                                });
                            }
                        });
                    } else {
                        // Buat transaksi baru
                        fetch(`/bill/pay/${billId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.snapToken) {
                                    // Simpan snapToken dan orderId di localStorage
                                    localStorage.setItem(`snapToken_${billId}`, data.snapToken);
                                    localStorage.setItem(`orderId_${billId}`, data.orderId);

                                    snap.pay(data.snapToken, {
                                        onSuccess: function(result) {
                                            alert('Pembayaran berhasil!');
                                            handlePaymentSuccess(result);
                                        },
                                        onPending: function(result) {
                                            alert('Pembayaran tertunda!');
                                            window.location.reload();
                                        },
                                        onError: function(result) {
                                            alert('Pembayaran gagal!');
                                            handlePaymentFailure(result);
                                        },
                                        onClose: function() {
                                            alert(
                                                'Anda menutup popup pembayaran tanpa menyelesaikan transaksi.'
                                            );
                                            handlePaymentFailure({
                                                order_id: data.orderId
                                            });
                                        }
                                    });
                                } else {
                                    alert('Gagal memproses pembayaran.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat memproses pembayaran.');
                            });
                    }
                });
            });

            // Fungsi untuk menangani pembayaran berhasil
            function handlePaymentSuccess(result) {
                fetch('/midtrans/notification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(result)
                }).then(() => {
                    // Hapus snapToken dan orderId dari localStorage setelah pembayaran berhasil
                    localStorage.removeItem(`snapToken_${result.order_id}`);
                    localStorage.removeItem(`orderId_${result.order_id}`);
                    // Redirect ke halaman yang sama untuk menampilkan flash message
                    window.location.href = "{{ route('mahasiswa.bill_payment') }}"; // Ganti dengan route yang sesuai
                });
            }

            // Fungsi untuk menangani pembayaran gagal
            function handlePaymentFailure(result) {
                fetch('/midtrans/notification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: result.order_id,
                        transaction_status: 'failed'
                    })
                }).then(() => {
                    // Hapus snapToken dan orderId dari localStorage setelah pembayaran gagal
                    localStorage.removeItem(`snapToken_${result.order_id}`);
                    localStorage.removeItem(`orderId_${result.order_id}`);
                    // Redirect ke halaman yang sama untuk menampilkan flash message
                    window.location.href = "{{ route('mahasiswa.bill_payment') }}"; // Ganti dengan route yang sesuai
                });
            }
        });
    </script>
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
