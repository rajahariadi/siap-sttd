@extends('admin.index')

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
        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Total Mahasiswa</p>
                                    <h4 class="mb-0"> {{ $totalMahasiswa }} </h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-group-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Total Jurusan</p>
                                    <h4 class="mb-0"> {{ $totalJurusan }} </h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-building-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Total Pendapatan</p>
                                    <h4 class="mb-0"> {{ 'Rp. ' . number_format($totalPendapatan, 0, ',', '.') }} </h4>
                                </div>
                                <div class="text-primary">
                                    <i class="ri-money-dollar-circle-fill font-size-24"></i>
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
                                    <th>No</th>
                                    <th>ID Transaksi</th>
                                    <th>Nama | NIM</th>
                                    <th>Jurusan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataTransaksi as $data)
                                    <tr>
                                        <td class="text-dark font-weight-bold"> {{ $loop->iteration }} </td>
                                        <td> {{ $data->transaction_id }} </td>
                                        <td> {{ $data->bill->student->user->name }} | {{ $data->bill->student->user->nim }}
                                        </td>
                                        <td> {{ $data->bill->student->major->name }} </td>
                                        <td> {{ 'Rp. ' . number_format($data->amount, 0, ',', '.') }} </td>
                                        <td>
                                            <div
                                                class="badge badge-soft-{{ $data->status === 'success' ? 'success' : 'danger' }} font-size-12">
                                                {{ Str::ucfirst($data->status) }}
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Tagihan Pending</h4>

                    <div id="donut-chart" class="apex-charts"></div>

                    <div class="row">
                        <div class="col-4">
                            <div class="text-center mt-4">
                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary font-size-10 mr-1"></i>
                                    Teknik Informatika</p>
                                <h5>{{ $persentaseBelumBayar['55201'] ?? 0 }} %</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center mt-4">
                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success font-size-10 mr-1"></i>
                                    Teknik Industri</p>
                                <h5>{{ $persentaseBelumBayar['26201'] ?? 0 }} %</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center mt-4">
                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-warning font-size-10 mr-1"></i>
                                    Teknik Sipil</p>
                                <h5>{{ $persentaseBelumBayar['22201'] ?? 0 }} %</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Pendapatan Program Studi</h4>
                    <div class="text-center">
                        <div class="row">

                            <div class="col-sm-4">
                                <div>
                                    <div class="mb-3">
                                        <div id="radialchart-1" class="apex-charts"></div>
                                    </div>
                                    <p class="text-muted text-truncate mb-2">Teknik Informatika</p>
                                    <p class="font-weight-bold">Rp.
                                        {{ number_format($jumlahPendapatan['55201'] ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mt-5 mt-sm-0">
                                    <div class="mb-3">
                                        <div id="radialchart-2" class="apex-charts"></div>
                                    </div>
                                    <p class="text-muted text-truncate mb-2">Teknik Industri</p>
                                    <p class="font-weight-bold">Rp.
                                        {{ number_format($jumlahPendapatan['26201'] ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mt-5 mt-sm-0">
                                    <div class="mb-3">
                                        <div id="radialchart-3" class="apex-charts"></div>
                                    </div>
                                    <p class="text-muted text-truncate mb-2">Teknik Sipil</p>
                                    <p class="font-weight-bold">Rp.
                                        {{ number_format($jumlahPendapatan['22201'] ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection

@section('dashboard')
    <script>
        options = {
            series: [
                {{ $jumlahBelumBayar['55201'] ?? 0 }},
                {{ $jumlahBelumBayar['26201'] ?? 0 }},
                {{ $jumlahBelumBayar['22201'] ?? 0 }}
            ],
            chart: {
                height: 230,
                type: "donut"
            },
            labels: ["Teknik Informatika", "Teknik Industri", "Teknik Sipil"],
            plotOptions: {
                pie: {
                    donut: {
                        size: "75%"
                    }
                }
            },
            dataLabels: {
                enabled: !1
            },
            legend: {
                show: !1
            },
            colors: ["#5664d2", "#1cbb8c", "#eeb902"]
        };
        (chart = new ApexCharts(document.querySelector("#donut-chart"), options)).render();

        // Radial Chart 1: Teknik Informatika
        var radialOptions1 = {
            series: [{{ $persentasePendapatan['55201'] ?? 0 }}],
            chart: {
                type: "radialBar",
                width: 60,
                height: 60,
                sparkline: {
                    enabled: !0
                }
            },
            dataLabels: {
                enabled: !1
            },
            colors: ["#5664d2"], // Warna Teknik Informatika
            stroke: {
                lineCap: "round"
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "70%"
                    },
                    track: {
                        margin: 0
                    },
                    dataLabels: {
                        show: !1
                    }
                }
            }
        };
        var radialChart1 = new ApexCharts(document.querySelector("#radialchart-1"), radialOptions1);
        radialChart1.render();

        // Radial Chart 2: Teknik Industri
        var radialOptions2 = {
            series: [{{ $persentasePendapatan['26201'] ?? 0 }}],
            chart: {
                type: "radialBar",
                width: 60,
                height: 60,
                sparkline: {
                    enabled: !0
                }
            },
            dataLabels: {
                enabled: !1
            },
            colors: ["#1cbb8c"], // Warna Teknik Industri
            stroke: {
                lineCap: "round"
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "70%"
                    },
                    track: {
                        margin: 0
                    },
                    dataLabels: {
                        show: !1
                    }
                }
            }
        };
        var radialChart2 = new ApexCharts(document.querySelector("#radialchart-2"), radialOptions2);
        radialChart2.render();

        // Radial Chart 3: Teknik Sipil
        var radialOptions3 = {
            series: [{{ $persentasePendapatan['22201'] ?? 0 }}],
            chart: {
                type: "radialBar",
                width: 60,
                height: 60,
                sparkline: {
                    enabled: !0
                }
            },
            dataLabels: {
                enabled: !1
            },
            colors: ["#eeb902"], // Warna Teknik Sipil
            stroke: {
                lineCap: "round"
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "70%"
                    },
                    track: {
                        margin: 0
                    },
                    dataLabels: {
                        show: !1
                    }
                }
            }
        };
        var radialChart3 = new ApexCharts(document.querySelector("#radialchart-3"), radialOptions3);
        radialChart3.render();
    </script>
@endsection
