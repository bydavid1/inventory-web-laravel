{{-- style blade file --}}
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/vendors.min.css')}}">
    @yield('vendor-styles')
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/themes/semi-dark-layout.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    @if($configData['mainLayoutType'] == 'horizontal-menu')
    <link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
    @else
    <link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/vertical-menu.css')}}">
    @endif
    @yield('page-styles')
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->

    <!-- END: Custom CSS-->
