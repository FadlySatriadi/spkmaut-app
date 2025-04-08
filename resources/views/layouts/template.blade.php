<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Footer tetap di bawah dan ukuran konsisten */
        .main-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            /* Tinggi tetap */
            margin-left: 250px;
            /* Sesuaikan dengan lebar sidebar */
            z-index: 1000;
            background-color: #f4f6f9;
            border-top: 1px solid #dee2e6;
            padding: 15px;
        }

        .brand-text {
            color: #ffffff !important;
            /* Warna putih */
            font-weight: bold;
            /* Opsional: Tambah ketebalan */
        }

        .brand-link {
            border-bottom: 2px solid #800000 !important;
            /* Mengubah garis bawah menjadi putih */
        }

        .content-wrapper {
            margin-left: 250px;
            /* Sama dengan lebar sidebar */
            min-height: 100vh;
            padding: 20px;
            background: url("{{ asset('lte/dist/img/sig1.jpg') }}") no-repeat center center;
            background-size: 50%;
            background-position: center;
            background-attachment: fixed;
            background-color: #ffffff
        }

        .logo-background {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            opacity: 0.2;
            z-index: -1;
            background-blend-mode: lighten;
            /* Pastikan warna menyatu */
        }

        body {
            background-color: white !important;
        }

        .content-wrapper {
            background-color: white !important;

        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SPK Batching Plant') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

    <style>
        :root {
            --font-family-sans-serif: 'Poppins', sans-serif;
        }

        body,
        .main-header .navbar,
        .main-sidebar,
        .brand-link,
        .nav-sidebar>.nav-item>.nav-link,
        .card,
        .table,
        .btn,
        .form-control,
        .dropdown-menu {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link text-center d-flex flex-column align-items-center">
                <img src="{{ asset('lte/dist/img/sig.png') }}" alt="Logo" class="brand-image mb-2"
                    style="opacity: .9; width: 100px; height: 100px; object-fit: contain;">
                <span class="brand-text" style="font-family: 'Poppins', sans-serif; font-weight: 700; color: white;">
                    SPK Batching Plant
                </span>
            </a>
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('layouts.breadcrumb')
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
