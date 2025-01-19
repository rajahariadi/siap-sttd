<!DOCTYPE html>
<html lang="en">

<!--head-->
@include('admin.component.head')
<!--end head-->

<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- End Loader -->

    <!-- Navigation Bar-->
    @include('admin.component.navbar')
    <!-- End Navigation Bar-->

    <!-- Page Content -->
    <div class="wrapper">
        <div class="container-fluid">
            @yield('content')
        </div> <!-- end container -->
    </div> <!-- end wrapper -->
    <!-- End Page Content -->

    <!-- Footer -->
    @include('admin.component.footer')
    <!-- End Footer -->

    <!-- Script -->
    @include('admin.component.script')
    <!-- End Script -->

</body>

</html>
