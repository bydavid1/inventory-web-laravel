<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-brand-center @if($configData['navbarBgColor'] !== 'bg-white' )) {{$configData['navbarBgColor']}} @else {{'bg-primary'}} @endif
@if($configData['navbarType'] === 'navbar-static') {{'navbar-static-top'}} @else {{'fixed-top'}} @endif
@if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif">
  <div class="navbar-header d-xl-block d-none">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item">
      <a class="navbar-brand" href="{{asset('/')}}">
          <div class="brand-logo">
          <img src="{{asset('assets/media/e-box-light.png')}}" class="logo" alt="">
          </div>
          <h2 class="brand-text mb-0">
            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
            {{$configData['templateTitle']}}
            @else
            e-box
            @endif
          </h2>
        </a>
      </li>
    </ul>
  </div>
  <div class="navbar-wrapper">
    <div class="navbar-container content">
      <div class="navbar-collapse" id="navbar-mobile">
        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
          <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu mr-auto"><a class="nav-link nav-menu-main menu-toggle" href="#"><i class="bx bx-menu"></i></a></li>
          </ul>
          <ul class="nav navbar-nav bookmark-icons">
            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{route('addSale')}}" data-toggle="tooltip" data-placement="top" title="Nueva venta"><i class="ficon bx bxs-cart"></i></a></li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{route('addPurchase')}}" data-toggle="tooltip" data-placement="top" title="Nueva compra"><i class="ficon bx bxs-truck"></i></a></li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="" data-toggle="tooltip" data-placement="top" title="Reportes"><i class="ficon bx bxs-chart"></i></a></li>
          </ul>
          <ul class="nav navbar-nav">
            {{-- <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon bx bx-star warning"></i></a> --}}
              <div class="bookmark-input search-input">
                <div class="bookmark-input-icon"><i class="bx bx-search primary"></i></div>
                <input class="form-control input" type="text" placeholder="Deshabilitado." tabindex="0" data-search="template-search">
                <ul class="search-list"></ul>
              </div>
            </li>
          </ul>
        </div>
        <ul class="nav navbar-nav float-right d-flex align-items-center">
          <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
          <li class="nav-item nav-search"><a class="nav-link nav-link-search pt-2"><i class="ficon bx bx-search"></i></a>
            <div class="search-input">
              <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
              <input class="input" type="text" placeholder="Deshabilitado" tabindex="-1" data-search="template-search">
              <div class="search-input-close"><i class="bx bx-x"></i></div>
              <ul class="search-list"></ul>
            </div>
          </li>
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
              <div class="user-nav d-lg-flex d-none">
                <span class="user-name">{{ Auth::user()->username }}</span><span class="user-status">Activo</span>
              </div>
              <span><img class="round" src="{{asset('assets/media/user.jpg')}}" alt="avatar" height="40" width="40"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right pb-0">
                <a class="dropdown-item disabled" href=""><i class="bx bx-user mr-50"></i> Editar perfil</a>
                <a class="dropdown-item" href="{{ route('configuration') }}"><i class="bx bx-building mr-50"></i> Configuración</a>
                <div class="dropdown-divider mb-0"></div>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bx bx-power-off mr-50"></i> Salir
                </a>
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
