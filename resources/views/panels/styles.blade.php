{{-- style blade file --}}
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/vendors.min.css')}}">
    @yield('vendor-styles')
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    @if($configData['mainLayoutType'] == 'horizontal-menu')
    <link rel="stylesheet" type="text/css" href="{{asset('css/horizontal-menu.css')}}">
    @else
    <link rel="stylesheet" type="text/css" href="{{asset('css/vertical-menu.css')}}">
    @endif
    @yield('page-styles')
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->

    <!-- END: Custom CSS-->
