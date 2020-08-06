@extends('layouts.secondary_app')

@section('custom_header')
	  <!-- For Design -->
      <link rel="stylesheet" href="{{ asset('app-assets/vendors/css/extensions/sweetalert.css') }}">
      <link rel="stylesheet" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
@endsection

@section('content')
<div class="app-content content" style="height: 100%">
	<div class="content-header bg-white pb-0">
    </div>
    <div class="content-body h-100">
        <div class="row h-100">
            <div class="col-md-8 h-100 overflow-auto">
                <div class="col-md-12">
                    <input class="form-control form-control-lg mt-1"  id="searchInput" type="search" autofocus 
                    autocomplete="off" placeholder="Buscar en el inventario">
                </div>
                <div id="products">
                    @include('sales.list_products')
                </div>
            </div>
            <div class="col-md-4 p-0" style="height: 100%; border-left: 1px solid #707070">
                <div class="content-header bg-white p-2" style="height: 10%">
                    <div class="content-header row">
                        <div class="content-header-left col-md-4 h-100 my-auto">
                            <h4>Detalles</h4>
                        </div>
                        <div class="content-header-right col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nombre del cliente"
                                    autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 40%" class="overflow-auto">
                    <ul id="items" class="list-group py-1">

                    </ul>
                </div>
                <!-- card-->
                <div class="card card-outline card-danger" style="height: 50%">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                Cantidad total
                                <strong id="grandquantity">0</strong>
                                <input type="hidden" id="grandquantityvalue" name="grandquantityvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                Sub total
                                <strong id="subtotal">$0.00</strong>
                                <input type="hidden" id="subtotalvalue" name="subtotalvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                Descuentos
                                <strong id="discounts">$0.00</strong>
                                <input type="hidden" id="discountsvalue" name="discountsvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                Impuestos
                                <strong id="tax">$0.00</strong>
                                <input type="hidden" id="taxvalue" name="taxesvalue">
                            </li>
                            <li class="list-group-item d-none justify-content-between align-items-center py-05" id="grandinterest">
                                Interés
                                <strong id="interest">$0.00</strong>
                                <input type="hidden" id="interestvalue" name="interestvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                Total
                                <strong id="grandtotal">$0.00</strong>
                                <input type="hidden" id="grandtotalvalue" name="grandtotalvalue">
                            </li>
                        </ul>
                        <button type="submit" id="createSale" data-loading-text="Cargando..."
                            class="btn btn-success btn-block mt-2">Registrar factura</button>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>  

<!-- Search product modal form -->
@include('product-order.productModal')

@endsection

@section('custom_footer')
    <!-- For design -->
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <!-- CN module -->
    <script src="{{ asset('js/path.js') }}"></script>
    <!-- Essential functions -->
    <script src="{{ asset('js/scripts/product-orders/script.js') }}"></script>
    <!-- Modal script -->
    <script src="{{ asset('js/scripts/product-orders/modal.js') }}"></script>
    <!-- Owner -->
    <script src="{{ asset('js/scripts/sales/addSale.js') }}"></script>
    @routes
    <script>
        // Basic date
        $('.pickadate').pickadate({
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd',
            hiddenPrefix: 'prefix__',
            hiddenSuffix: '__suffix'
        });
        
    </script>
@endsection