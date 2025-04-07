<style>
    .main-sidebar {
      background-color: #800000!important;
    }
    .nav-sidebar .nav-item .nav-link.active {
      background-color: #ffffff !important;
      color: #000 !important;
      font-weight: bold; /* Menebalkan teks */
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
      background-color: #ffffff !important; /* Background putih */
      color: #000 !important; /* Warna teks hitam */
      border: 1px solid #ccc !important; /* Tambahkan border agar terlihat */
  }

  /* Mengubah warna placeholder agar terlihat */
  .form-control-sidebar::placeholder {
      color: #777 !important; /* Warna placeholder abu-abu */
  }

  /* Mengubah warna tombol search agar sesuai */
  .btn-sidebar {
      background-color: #ffffff !important; /* Warna tombol putih */
      border: 1px solid #ccc !important; /* Border tombol */
      color: #000 !important; /* Warna ikon hitam */
  }

  /* Efek saat search bar aktif (diklik) */
  .form-control-sidebar:focus {
      border-color: #ffb300 !important; /* Border warna biru saat diklik */
      box-shadow: 0 0 5px rgb(255, 179, 0);
  }
  /* Mengubah warna divider (garis pemisah) menjadi putih */
  .nav-header {
      color: #fff !important; /* Warna teks header menu menjadi putih */
      border-bottom: 1px solid #fff !important; /* Garis bawah putih */
      padding-bottom: 5px;
      margin-bottom: 5px;
  }

  /* Mengubah warna garis di sidebar */
  .sidebar nav ul li.nav-header {
      border-bottom: 1px solid #fff !important;
  }
  </style>
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
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
        </ul>
    </nav>
</div>