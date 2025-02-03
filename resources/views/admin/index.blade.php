<!doctype html>
<html lang="en">

<!-- Head -->
@include('admin.components.head')
<!-- End Head -->

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Head -->
        @include('admin.components.header')
        <!-- End Head -->


        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.components.sidebar')
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
            @include('admin.components.footer')
            <!-- Footer -->

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Script -->
    @include('admin.components.scripts')
    <!-- End Script -->

</body>

</html>
