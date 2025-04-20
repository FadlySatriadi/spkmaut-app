<style>
    .main-sidebar {
        height: 100%;
        /* Full-height: remove this if you want "auto" height */
        width: 250px;
        /* Set the width of the sidebar */
        position: fixed;
        /* Fixed Sidebar (stay in place on scroll) */
        z-index: 1;
        /* Stay on top */
        top: 0;
        /* Stay at the top */
        left: 0;
        background-color: #800000;
        /* Black */
        overflow-x: hidden;
        /* Disable horizontal scroll */
        padding-top: 20px;
    }

    .nav-sidebar .nav-item .nav-link.active {
        background-color: #ffffff !important;
        color: #000 !important;
        font-weight: bold;
        /* Menebalkan teks */
    }

    .nav-sidebar .nav-item .nav-link {
        color: #ffffff !important;
    }

    .nav-sidebar .nav-item .nav-link.active {
        background-color: #ffffff !important;
        color: #000 !important;
        font-weight: bold;
    }

    /* Mengubah background search bar menjadi putih */
    .form-control-sidebar {
        background-color: #ffffff !important;
        /* Background putih */
        color: #000 !important;
        /* Warna teks hitam */
        border: 1px solid #ccc !important;
        /* Tambahkan border agar terlihat */
    }

    /* Mengubah warna placeholder agar terlihat */
    .form-control-sidebar::placeholder {
        color: #777 !important;
        /* Warna placeholder abu-abu */
    }

    /* Mengubah warna tombol search agar sesuai */
    .btn-sidebar {
        background-color: #ffffff !important;
        /* Warna tombol putih */
        border: 1px solid #ccc !important;
        /* Border tombol */
        color: #000 !important;
        /* Warna ikon hitam */
    }

    /* Efek saat search bar aktif (diklik) */
    .form-control-sidebar:focus {
        border-color: #ffb300 !important;
        /* Border warna biru saat diklik */
        box-shadow: 0 0 5px rgb(255, 179, 0);
    }

    /* Mengubah warna divider (garis pemisah) menjadi putih */
    .nav-header {
        color: #fff !important;
        /* Warna teks header menu menjadi putih */
        border-bottom: 1px solid #fff !important;
        /* Garis bawah putih */
        padding-bottom: 5px;
        margin-bottom: 5px;
    }

    /* Mengubah warna garis di sidebar */
    .sidebar nav ul li.nav-header {
        border-bottom: 1px solid #fff !important;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Sidebar Fixed -->
        <aside class="main-sidebar">
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('/welcome') }}"
                                class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/aub') }}" class="nav-link {{ $activeMenu == 'aub' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-marked-alt"></i>
                                <p>Data AUB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/plant') }}" class="nav-link {{ $activeMenu == 'plant' ? 'active' : '' }}">
                                <i class="nav-icon fa fa-industry"></i>
                                <p>Data Plant</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kriteria') }}"
                                class="nav-link {{ $activeMenu == 'kriteria' ? 'active' : '' }}">
                                <i class="nav-icon fa fa-envelope"></i>
                                <p>Data Kriteria</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/rekomendasi/select-plants') }}"
                                class="nav-link {{ $activeMenu == 'rekomendasi' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hard-hat"></i>
                                <p>Penilaian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rekomendasi.cache-history') }}" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>History</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="sidebar-footer p-2" style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-block text-left nav-link"
                            style="color: #ffffff; background: transparent; border: none; padding: 0.5rem 1rem;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p style="display: inline;">Logout</p>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    </div>
</body>
