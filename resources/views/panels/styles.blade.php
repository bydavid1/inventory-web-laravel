{{-- style blade file --}}
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/vendors.min.css')}}">
=======
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/vendors.min.css')}}">
>>>>>>> database
    @yield('vendor-styles')
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    @if($configData['mainLayoutType'] == 'horizontal-menu')
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="{{asset('css/horizontal-menu.css')}}">
    @else
    <link rel="stylesheet" type="text/css" href="{{asset('css/vertical-menu.css')}}">
=======
    <link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
    @else
    <link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/vertical-menu.css')}}">
>>>>>>> database
    @endif
    @yield('page-styles')
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->

    <!-- END: Custom CSS-->
