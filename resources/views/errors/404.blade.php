<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>404 Error | SIAP - STT Dumai </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-sm.png') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.cs') }}s" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center my-5">
                        <h1 class="font-weight-bold text-error">4 <span class="error-text">0<img
                                    src="{{ asset('assets/images/error-img.png') }}" alt=""
                                    class="error-img"></span> 4</h1>
                        <h3 class="text-uppercase">Sorry, page not found</h3>
                        <div class="mt-5 text-center">
                            @if (Auth::user()->role === 'admin')
                                <a class="btn btn-primary waves-effect waves-light"
                                    href="{{ route('admin.dashboard') }}">Go Back to Dashboard</a>
                            @else
                                <a class="btn btn-primary waves-effect waves-light"
                                    href="{{ route('mahasiswa.home') }}">Go Back to Home</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
