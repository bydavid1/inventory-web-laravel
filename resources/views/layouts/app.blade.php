<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal - Bootstrap 5 Admin Dashboard Template For Developers</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Vendor styles -->
    @yield('vendor-styles')

</head>
<body>
    @include('sections.menu')
    <div class="app-wrapper">
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
                <h1 class="app-page-title">@yield('title')</h1>
                @yield('content')
            </div>
        </div>
        @include('sections.footer')
    </div>

    <!-- Javascript -->
    <script src="{{ asset('plugins/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Charts JS -->
    <script src="{{ asset('plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('js/index-charts.js')}}"></script>

    <!-- Vendor scripts -->
    @yield('vendor-scripts')

    <!-- Page scripts -->
    @yield('page-scripts')

    <!-- Page Specific JS -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
