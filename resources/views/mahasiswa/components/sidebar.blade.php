<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Dashboard</li>

                <li>
                    <a href="{{ route('mahasiswa.home') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Data Transaksi</li>

                <li>
                    <a href="{{ route('mahasiswa.bill-payment') }}" class="waves-effect">
                        <i class=" ri-secure-payment-line"></i>
                        <span>Bayar Tagihan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('mahasiswa.history-payment') }}" class="waves-effect">
                        <i class=" ri-bill-line"></i>
                        <span>Riwayat Pembayaran</span>
                    </a>
                </li>

                <li class="menu-title">Mahasiswa</li>

                <li>
                    <a href="{{ route('mahasiswa.myprofile') }}" class="waves-effect">
                        <i class="ri-user-line align-middle mr-1"></i>
                        <span>Profile</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
