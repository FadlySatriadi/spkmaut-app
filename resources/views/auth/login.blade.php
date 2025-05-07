<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DSS Batching Plant | Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

    <style>
        body {
            background-image: url("{{ asset('lte/dist/img/loginfix.jpg') }}");
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .login-box {
            width: 475px;
            position: absolute;
            right: 150px;
            bottom: 120px;
            transform: translateY(-50%) animation: fadeInRight 1s ease-out;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border-top: 5px solid #800000 !important;
        }

        .card-header {
            background: white;
            border-bottom: none;
            padding: 30px 20px 10px;
        }

        .card-body {
            padding: 40px;
        }

        /* .login-page {
            background: transparent !important;
        } */

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .btn-primary {
            background-color: #800000;
            border-color: #700000;
        }

        .form-control::placeholder {
            color: #bdbdbd !important;
        }

        .btn-primary:hover {
            background-color: #700000;
            border-color: #600000;
        }

        .input-group-text {
            background-color: #c6c6c6;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary" style="border-top: 5px solid #800000;">
            <div class="card-header text-center">
                <div class="h2"><b>Decision Support System</b> Batching Plant Status</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('proses_login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="username" class="form-control" style="border: 2px solid #800000;" name="username"
                            placeholder="Username" autofocus>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" style="border: 2px solid #800000;" name="password"
                            placeholder="Password">
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block"
                                style="font-weight: bold;">LOGIN</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
