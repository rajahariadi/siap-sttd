<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Dashboard</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Data Transaksi</li>

                <li>
                    <a href="{{ route('admin.tagihan.index') }}" class="waves-effect">
                        <i class=" ri-bank-card-2-line"></i>
                        <span>Tagihan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.jenis-pembayaran.index') }}" class="waves-effect">
                        <i class="ri-wallet-line"></i>
                        <span>Pembayaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.laporan') }}" class="waves-effect">
                        <i class="ri-file-list-2-line"></i>
                        <span>Laporan</span>
                    </a>
                </li>

                <li class="menu-title">Data Mahasiswa</li>


                <li>
                    <a href="{{ route('admin.mahasiswa.index') }}" class=" waves-effect">
                        <i class="ri-group-line"></i>
                        <span>Mahasiswa</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.jurusan.index') }}" class=" waves-effect">
                        <i class=" ri-building-line"></i>
                        <span>Jurusan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.gelombang.index') }}" class=" waves-effect">
                        <i class=" ri-article-line"></i>
                        <span>Pendaftaran</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
