@extends('admin.index')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">SIAP - STT Dumai</a></li>
                        <li class="breadcrumb-item">Data Akademik</li>
                        <li class="breadcrumb-item active">Data Gelombang</li>
                    </ol>
                </div>
                <h4 class="page-title">Data Gelombang</h4>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->

    @if (@session('success'))
        <div class="row col-sm-6">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Well done!</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <div class="col-sm-12 col-md-6">
                        <div>
                            <!-- create button -->
                            <button class="btn btn-primary"
                                onclick="window.location.href='{{ route('admin.gelombangs.create') }}'">
                                <i class="mdi mdi-library-plus"></i> Tambah Gelombang</button>
                            <!-- end create button -->

                            <!-- create button -->
                            <button class="btn btn-secondary"><i class="mdi mdi-upload"></i> Export</button>
                            <!-- end create button -->

                            <!-- create button -->
                            <button class="btn btn-secondary"><i class="mdi mdi-download"></i> Import</button>
                            <!-- end create button -->
                        </div>
                        <br>
                    </div>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap text-center"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="col-2">No</th>
                                <th>Gelombang</th>
                                <th class="col-2">Action</th>
                            </tr>
                        </thead>
                    </table>




                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <!-- end row -->
@endsection

@section('dtTable')
    <script>
        $(document).ready(function() {
            var dtTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: ['_all']
                }],
                ajax: '{{ route('admin.gelombangs.dt') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'Action',
                        name: 'Action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endsection
