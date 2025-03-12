<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>SIAP - STT Dumai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-sm.png') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        .password-input-container {
            position: relative;
        }

        .password-toggle-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 2;
        }

        .form-control {
            padding-right: 40px;
        }
    </style>
</head>

<body class="auth-body-bg">
    <div>
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-lg-4">
                    <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                        <div class="w-100">
                            <div class="row justify-content-center">
                                <div class="col-lg-9">
                                    <div>
                                        <div class="text-center">
                                            <div>
                                                <a href="{{ route('login') }}" class="logo"><img
                                                        src="{{ asset('assets/images/logo-dark.png') }}" height="50"
                                                        alt="logo"></a>
                                            </div>

                                            <h4 class="font-size-18 mt-4">SIAP - STT DUMAI</h4>
                                            <p class="text-muted">Sistem Administrasi Pembayaran (SIAP)</p>
                                        </div>

                                        <div class="p-2 mt-5">
                                            <form class="form-horizontal" action="{{ route('login') }}" method="POST">
                                                @csrf

                                                <div class="form-group auth-form-group-custom mb-4">
                                                    <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                    <label for="username">NIM</label>
                                                    <input type="text" class="form-control" id="username"
                                                        placeholder="Enter NIM" name="nim">
                                                    @error('nim')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="form-group auth-form-group-custom mb-4">
                                                    <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                    <label for="userpassword">Password</label>
                                                    <input type="password" class="form-control" id="userpassword"
                                                        placeholder="Enter password" name="password">
                                                    <i class="ri-eye-close-line password-toggle-icon text-primary" id="togglePassword"></i>
                                                    @error('password')
                                                        <p class="text-danger"> {{ $message }} </p>
                                                    @enderror
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <button
                                                        class="btn btn-block btn-primary w-md waves-effect waves-light"
                                                        type="submit">Log In</button>
                                                </div>

                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p>© 2025 Raja Hariadi. Crafted with <i
                                                    class="mdi mdi-heart text-danger"></i> by Raja Hariadi</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="authentication-bg">
                        <div class="bg-overlay"></div>
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

    <script>
        document.getElementById('togglePassword').addEventListener('click', function(e) {
            const passwordInput = document.getElementById('userpassword');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('ri-eye-line');
            this.classList.toggle('ri-eye-close-line');
        });
    </script>

</body>

</html>
