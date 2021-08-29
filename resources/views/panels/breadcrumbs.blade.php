<<<<<<< HEAD
<div class="content-header-left col-12">
    <div class="card">
        <div class="card-body">
            <div class="row breadcrumbs-top">
                <div class="col-6">
                    <h4 class="content-header-title float-left pr-1 mb-0">@yield('title')</h4>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
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
=======
<div class="content-header-left col-12 mb-2 mt-1">
    <div class="row breadcrumbs-top">
        <div class="col-6">
            <h4 class="content-header-title float-left pr-1 mb-0">@yield('title')</h4>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb p-0 mb-0">
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
>>>>>>> database
