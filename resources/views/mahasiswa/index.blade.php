<!doctype html>
<html lang="en">

<!-- Head -->
@include('mahasiswa.components.head')
<!-- End Head -->

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Head -->
        @include('mahasiswa.components.header')
        <!-- End Head -->


        <!-- ========== Left Sidebar Start ========== -->
        @include('mahasiswa.components.sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <!-- Footer -->
            @include('mahasiswa.components.footer')
            <!-- Footer -->

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Script -->
    @include('mahasiswa.components.scripts')
    <!-- End Script -->

</body>

</html>
