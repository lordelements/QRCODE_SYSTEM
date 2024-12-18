<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">


    <!-- Bootstrap CSS-->
    <link href="{{ asset('theme/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    
    <!-- Font Awesome CSS-->
    <link href="{{ asset('theme/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />

    <!-- Custom Font Icons CSS-->
    <link href="{{ asset('theme/css/font.css') }}" rel="stylesheet" />

    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">

    <!-- theme stylesheet-->
    <link href="{{ asset('theme/css/style.default.css') }}" rel="stylesheet" />

    <!-- Custom stylesheet - for your changes-->
    <link href="{{ asset('theme/css/custom.css') }}" rel="stylesheet" />

    <!-- Favicon-->
    <link href="{{ asset('theme/img/favicon.ico') }}" rel="stylesheet" />
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
</head>

<body>

    @include('admin.theme.header')

    <div class="d-flex align-items-stretch">
        @include('admin.theme.sidebar')
        <div class="page-content">
            <div class="page-header">
                <div class="container-fluid">
                    <h2 class="h5 no-margin-bottom">Dashboard</h2>
                </div>
            </div>

            <main>
                @yield('content')
            </main>

            @include('admin.theme.footer')

        </div>
    </div>

     
     <!-- JavaScript files-->
     <script src="{{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('theme/vendor/popper.js/umd/popper.min.js') }}"></script>
     <script src="{{ asset('theme/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
     <script src="{{ asset('theme/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
     <script src="{{ asset('theme/vendor/chart.js/Chart.min.js') }}"></script>
     <script src="{{ asset('theme/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
     <script src="{{ asset('theme/js/charts-home.js') }}"></script>
     <script src="{{ asset('theme/js/front.js') }}"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  </body>
</html>