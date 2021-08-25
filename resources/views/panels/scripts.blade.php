
    <!-- BEGIN: Vendor JS-->
    <script>
        var assetBaseUrl = "{{ asset('') }}";
    </script>
<<<<<<< HEAD
    <script src="{{asset('js/libs/vendors.min.js')}}"></script>
=======
    <script src="{{asset('vendors/vendors.min.js')}}"></script>
>>>>>>> database
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @yield('vendor-scripts')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    @if($configData['mainLayoutType'] == 'vertical-menu')
<<<<<<< HEAD
    <script src="{{asset('js/vertical-menu-light.js')}}"></script>
    @else
    <script src="{{asset('js/horizontal-menu.js')}}"></script>
    @endif
    <script src="{{asset('js/app.js')}}"></script>
=======
    <script src="{{asset('js/core/menu/vertical-menu-light.js')}}"></script>
    @else
    <script src="{{asset('js/core/menu/horizontal-menu.js')}}"></script>
    @endif
    <script src="{{asset('js/core/app.js')}}"></script>
>>>>>>> database

    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    @yield('page-scripts')
    <!-- END: Page JS-->
