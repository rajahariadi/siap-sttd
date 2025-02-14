@extends('mahasiswa.index')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Total Tagihan</p>
                                    <h4 class="mb-0"> {{ $dataTagihan }} </h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-bank-card-2-line font-size-24"></i>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Jumlah Tagihan</p>
                                    <h4 class="mb-0"> {{ 'Rp. ' . number_format($dataJumlahTagihan, 0, ',', '.') }} </h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-money-dollar-circle-line font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Tagihan Dibayar</p>
                                    <h4 class="mb-0"> {{ $dataTagihanDibayar }} </h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-wallet-line font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Jumlah Tagihan Dibayar</p>
                                    <h4 class="mb-0">{{ 'Rp. ' . number_format($dataJumlahTagihanDibayar, 0, ',', '.') }}
                                    </h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-money-dollar-circle-line font-size-24"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Transaksi Terbaru</h4>

                    <div class="table-responsive">
                        <table class="table table-centered datatable dt-responsive nowrap text-center" data-page-length="5"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Total</th>
                                    <th>Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataTransaksi as $data)
                                    <tr>
                                        <td class="text-dark font-weight-bold">{{ $data->transaction_id }} </td>
                                        <td> {{ $data->updated_at->format('d M Y H:i') }} </td>
                                        <td> {{ Str::upper($data->payment_method) }} </td>
                                        <td>{{ 'Rp. ' . number_format($data->amount, 0, ',', '.') }} </td>
                                        <td>
                                            <div
                                                class="badge badge-soft-{{ $data->status === 'success' ? 'success' : 'danger' }} font-size-12">
                                                {{ Str::ucfirst($data->status) }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->
@endsection
