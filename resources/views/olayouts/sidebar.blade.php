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
        background-color: wheat !important;
        color: #000 !important;
        font-weight: bold;
        /* Menebalkan teks */
    }

    .nav-sidebar .nav-item .nav-link {
        color: wheat !important;
    }

    .nav-sidebar .nav-item .nav-link.active {
        background-color: wheat !important;
        color: #000 !important;
        font-weight: bold;
    }

    /* Mengubah background search bar menjadi putih */
    .form-control-sidebar {
        background-color: wheat !important;
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
        background-color: wheat !important;
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

    .logout-btn {
        color: #800000 !important;
        background: wheat !important;
        border: none !important;
        padding: 10px 15px !important;
        transition: all 0.3s ease;
        border-radius: 4px;
        width: 100%;
        text-align: left;
    }

    .logout-btn:hover {
        background-color: rgb(255, 220, 138) !important;
        color: #800000e !important;
        transform: translateX(5px);
    }

    .logout-btn i {
        transition: transform 0.3s ease;
    }

    .logout-btn:hover i {
        transform: rotate(180deg);
    }

    .logout-btn span {
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .logout-btn:hover span {
        transform: translateX(5px);
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
                            <a href="{{ dynamic_dashboard_url() }}"
                                class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/officeraub') }}" class="nav-link {{ $activeMenu == 'officeraub' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-marked-alt"></i>
                                <p>Anak Usaha</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/oplant') }}" class="nav-link {{ $activeMenu == 'oplant' ? 'active' : '' }}">
                                <i class="nav-icon fa fa-industry"></i>
                                <p>Batching Plant</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/okriteria') }}"
                                class="nav-link {{ $activeMenu == 'okriteria' ? 'active' : '' }}">
                                <i class="nav-icon fa fa-envelope"></i>
                                <p>Kriteria</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('o/rekomendasi/select-plants') }}"
                                class="nav-link {{ $activeMenu == 'rekomendasi' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hard-hat"></i>
                                <p>Penilaian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('o/recommendation/cache-history') }}"
                                class="nav-link {{ $activeMenu == 'ohistory' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>History</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="sidebar-footer p-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-block text-left logout-btn {{ request()->is('logout') ? 'active' : '' }}"
                            style="color: #ffffff; background: wheat; border: none; padding: 0.5rem 1rem;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p style="display: inline;">Logout</p>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    </div>
</body>
