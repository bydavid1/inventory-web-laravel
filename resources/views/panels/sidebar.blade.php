{{-------------------------------------------------------------------------------------------}}
{{----------------------------- vertical-menu ---------------------------------------------}}
{{-------------------------------------------------------------------------------------------}}

@if($configData['mainLayoutType'] == 'vertical-menu')
<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow"
    data-scroll-to-active="true">
      <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/')}}">
          <div class="brand-logo">
            <img src="{{asset('assets/media/logos/logo-light.png')}}" class="logo" alt="">
          </div>
          <h2 class="brand-text mb-0">
            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
            {{$configData['templateTitle']}}
            @else
            Frest
            @endif
          </h2>
          </a>
      </li>
          <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
            <i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
            <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i>
          </a>
          </li>
      </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">
            <i class='bx bxs-dashboard'></i>
              <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('suppliers') }}">
                <i class='bx bxs-purchase-tag' ></i>
                <span>Propiedades</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products') }}">
                <i class='bx bxs-package'></i>
                <span>Inventario</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customers') }}">
                <i class='bx bxs-user-detail' ></i>
                <span>Clientes</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('sales') }}">
            <i class='bx bxs-cart-alt' ></i>
              <span>Ventas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('purchases') }}">
            <i class='bx bxs-dollar-circle' ></i>
              <span>Compras</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('kardex') }}">
            <i class='bx bxs-layer' ></i>
              <span>Kardex</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">
            <i class='bx bx-stats' ></i>
              <span>Reportes</span>
          </a>
        </li>
      </ul>
      </div>
  </div>
@endif

{{-------------------------------------------------------------------------------------------}}
{{----------------------------- horizontal-menu ---------------------------------------------}}
{{-------------------------------------------------------------------------------------------}}

@if($configData['mainLayoutType'] == 'horizontal-menu')
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-light navbar-without-dd-arrow
@if($configData['navbarType'] === 'navbar-static') {{'navbar-sticky'}} @endif" role="navigation" data-menu="menu-wrapper">
  <div class="navbar-header d-xl-none d-block">
      <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/')}}">
          <div class="brand-logo">
            <img src="{{asset('assets/media/logos/logo-light.png')}}" class="logo" alt="">
          </div>
          <h2 class="brand-text mb-0">
            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
            {{$configData['templateTitle']}}
            @else
            Frest
            @endif
          </h2>
          </a>
      </li>
      <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
          </a>
      </li>
      </ul>
  </div>
  <div class="shadow-bottom"></div>
  <!-- Horizontal menu content-->
  <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
          <li class="nav-item sidebar-group-active active">
              <a class="nav-link" href="{{ route('home') }}">
                <i class='bx bxs-dashboard'></i>
                  <span>Dashboard</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('suppliers') }}">
                <i class='bx bxs-purchase-tag' ></i>
                  <span>Propiedades</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('products') }}">
                <i class='bx bxs-package'></i>
                  <span>Inventario</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('customers') }}">
                <i class='bx bxs-user-detail' ></i>
                  <span>Clientes</span>
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('sales') }}">
                <i class='bx bxs-cart-alt' ></i>
                <span>Ventas</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('purchases') }}">
                <i class='bx bxs-dollar-circle' ></i>
                <span>Compras</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('kardex') }}">
                <i class='bx bxs-layer' ></i>
                <span>Kardex</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class='bx bx-stats' ></i>
                <span>Reportes</span>
            </a>
          </li>
      </ul>
  </div>
  <!-- /horizontal menu content-->
  </div>
@endif
