<div class="app-card mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <h4 class="content-header-title float-left pr-1 mb-0">@yield('title')</h4>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb bg-transparent p-0 mb-0">
                            @isset($breadcrumbs)
                                @foreach ($breadcrumbs as $breadcrumb)
                                <li class="breadcrumb-item {{ !isset($breadcrumb['link']) ? 'active' :''}}">
                                    @if(isset($breadcrumb['link']))
                                    <a href="{{asset($breadcrumb['link'])}}">@if($breadcrumb['name'] == "Home")<i
                                            class="bx bx-home-alt"></i>@else{{$breadcrumb['name']}}@endif</a>
                                    @else{{$breadcrumb['name']}}@endif
                                </li>
                                @endforeach
                            @endisset
                        </ol>
                    </div>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        @yield('tools')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

