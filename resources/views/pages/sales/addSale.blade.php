@extends('layouts.app')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
@endsection

@section('content')
<div class="app-content content" style="height: 100%">
    <div class="content-header bg-white pb-0">
    </div>
    <div class="content-body h-100">
        <form class="h-100" id="createOrderForm">
            @csrf
            <div class="row h-100">
                <div class="col-md-8 h-100 overflow-auto">
                    <div class="col-md-12">
                        <input class="form-control form-control-lg mt-1" id="searchInput" type="search" autofocus
                            autocomplete="off" placeholder="Buscar en el inventario">
                    </div>
                    <div id="products">
                        @include('pages.sales.list_products')
                    </div>
                </div>
                <div style="border-left: 1px solid #707070" class="col-md-4 p-0  overflow-auto">
                    <div class="content-header bg-white p-2" style="">
                        <div class="row h-100">
                            <div class="col-md-4 h-100 my-auto">
                                <h4>Cliente</h4>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group my-auto">
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Nombre del cliente" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-auto" style="height: 40%">
                        <div class="row mt-1 w-100 pl-1">
                            <div class="col-md-1">
                                <h6 class="text-bold-600">Elim.</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="text-bold-600">Cant.</h6>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-bold-600">Producto</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="text-bold-600">Precio</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="text-bold-600">Total</h6>
                            </div>
                        </div>
                        <ul id="items" class="list-group py-1">

                        </ul>
                    </div>
                    <div class="position-absolute" style="bottom: 0">
                        <!-- card-->
                        <div class="card card-outline card-dangers mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="label-control">Descuentos</label>
                                        <input type="decimal" class="form-control" id="additionalDiscounts"
                                            name="additionalDiscounts" placeholder="Descuento adicional"
                                            onkeyup="calculate()">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="label-control">Pago adicional</label>
                                        <input type="decimal" class="form-control" id="additionalPayments"
                                            name="additionalPayments" placeholder="Pago adicional"
                                            onkeyup="calculate()">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="label-control">Notas de la venta</label>
                                        <textarea name="notes" id="notes" class="form-control"></textarea>
                                    </div>
                                </div>
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
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                        Pagos adicionales
                                        <strong id="additionalpayments">$0.00</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                        Impuestos
                                        <strong id="tax">$0.00</strong>
                                        <input type="hidden" id="taxvalue" name="taxesvalue">
                                    </li>
                                    <li class="list-group-item d-none justify-content-between align-items-center py-05"
                                        id="grandinterest">
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
                                <input type="hidden" id="itemsCount" name="itemsCount"><!-- itemsCount-->
                                <button type="submit" id="createSale" data-loading-text="Cargando..."
                                    class="btn btn-success btn-block mt-2">Registrar factura</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Search product modal form -->
@include('pages.sales.modalItem')

@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/path.js') }}"></script>
    <script src="{{ asset('js/scripts/product-orders/script.js') }}"></script>
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