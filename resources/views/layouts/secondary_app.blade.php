<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ config('app.name', 'Admin') }}</title>
    <link rel="apple-touch-icon" href="{{ URL::asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/app.css') }}">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/css/core/menu/menu-types/vertical-overlay-menu.css') }}">
    <!-- END Page Level CSS-->
    @yield('custom_header')
</head>

<body class="vertical-layout vertical-overlay-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-overlay-menu" data-col="2-columns">
    <!-- fixed-top-->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark bg-primary navbar-shadow navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="index.html">
                            <img class="brand-logo" alt="stack admin logo"
                                src="{{ URL::asset('app-assets/images/logo/stack-logo-light.png') }}">
                            <h2 class="brand-text">POS Mokalico</h2>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                                class="fa fa-ellipsis-v"></i></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                href="#"><i class="ft-menu"></i></a></li>
                        <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link" href="#"
                                data-toggle="dropdown">Mega</a>
                            <ul class="mega-dropdown-menu dropdown-menu row">
                            </ul>
                        </li>
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                    class="ficon ft-maximize"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i
                                    class="ficon ft-search"></i></a>
                            <div class="search-input">
                                <input class="input" type="text" placeholder="Explore Stack...">
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i
                                    class="ficon ft-bell"></i>
                                <span
                                    class="badge badge-pill badge-default badge-danger badge-default badge-up">5</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0">
                                        <span class="grey darken-2">Notifications</span>
                                        <span
                                            class="notification-tag badge badge-default badge-danger float-right m-0">5
                                            New</span>
                                    </h6>
                                </li>
                                <li class="scrollable-container media-list">
                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                        href="javascript:void(0)">Read all notifications</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i
                                    class="ficon ft-mail"></i>
                                <span
                                    class="badge badge-pill badge-default badge-warning badge-default badge-up">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0">
                                        <span class="grey darken-2">Messages</span>
                                        <span
                                            class="notification-tag badge badge-default badge-warning float-right m-0">4
                                            New</span>
                                    </h6>
                                </li>
                                <li class="scrollable-container media-list">
                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                        href="javascript:void(0)">Read all messages</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online">
                                    <img src="{{ URL::asset('app-assets/images/portrait/small/avatar-s-1.png') }}"
                                        alt="avatar"><i></i></span>
                                <span class="user-name">{{ Auth::user()->username }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                    href="user-profile.html"><i class="ft-user"></i> Edit Profile</a>
                                <a class="dropdown-item" href="email-application.html"><i class="ft-mail"></i> My
                                    Inbox</a>
                                <a class="dropdown-item" href="user-cards.html"><i class="ft-check-square"></i> Task</a>
                                <a class="dropdown-item" href="chat-application.html"><i class="ft-message-square"></i>
                                    Chats</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="ft-power"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <!-- main menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-border">
        <!-- main menu header-->
        <!-- include includes/menu-header-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="navigation-header">
                    <span>General</span><i class=" ft-minus" data-toggle="tooltip" data-placement="right"
                        data-original-title="General"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}"><i class="ft-home"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('suppliers') }}"><i class="ft-monitor"></i>
                        <span class="menu-title">Propiedades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products') }}"><i class="ft-layout"></i>
                        <span class="menu-title">Inventario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customers') }}"><i class="ft-zap"></i>
                        <span class="menu-title">Clientes</span>
                    </a>
                </li>
                <li class="nav-item" data-menu="megamenu">
                    <a href="{{ route('sales') }}"><i class="ft-box"></i>
                        <span class="menu-title">Ventas y facturas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('purchases') }}"><i class="ft-droplet"></i>
                        <span class="menu-title">Compras</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kardex') }}"><i class="ft-briefcase"></i>
                        <span class="menu-title">Kardex</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="ft-grid"></i>
                        <span class="menu-title">Reportes</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main menu content-->
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
    </div>
    <!-- / main menu-->

    @yield('content')

    <!-- BEGIN VENDOR JS-->
    <script src="{{ URL::asset('app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript">
    </script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script type="text/javascript" src="{{ URL::asset('app-assets/vendors/js/ui/jquery.sticky.j') }}s"></script>
    </script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN STACK JS-->
    <script src="{{ URL::asset('app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('app-assets/js/core/app.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
    <!-- END STACK JS-->
    @yield('custom_footer')
</body>

</html>