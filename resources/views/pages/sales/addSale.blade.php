@extends('layouts.app')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
@endsection

@section('content')
<div class="app-content content" id="app" style="height: 100%">
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
                    <div class="overflow-auto" style="height: 50%">
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
                            <div v-for="item in items" :key="item.id">
                                <item :item="item" v-on:datachange="calcTotals()"></item>
                            </div>
                        </ul>
                    </div>
                    <div class="position-absolute w-100">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                                Cantidad total
                                                <strong>@{{ data.quantityValue }}</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                                Sub total
                                                <strong>@{{ '$ ' + data.subtotalValue }}</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                                Descuentos
                                                <strong>@{{ '$ ' + data.discountsValue }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                                Pagos adicionales
                                                <strong>@{{ '$ ' + data.additionalPayments }}</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                                Impuestos
                                                <strong>@{{ '$ ' + data.taxValue }}</strong>
                                            </li>
                                            <li class="list-group-item d-none justify-content-between align-items-center py-05"
                                                id="grandinterest">
                                                Interés
                                                <strong>$0.00</strong>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-05">
                                                Total
                                                <strong>@{{ '$ ' + data.totalValue }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-action-btn mb-1 mt-1 dropup">
                                    <button class="btn btn-light-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                      <span>Agregar nota</span>
                                    </button>
                                    <div class="dropdown-menu p-1">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>Nota</label>
                                                <textarea class="form-control" v-model="data.note" placeholder="Type note"></textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-primary invoice-apply-btn"
                                                data-dismiss="modal">
                                                <span>Apply</span>
                                            </button>
                                            <button type="button" class="btn btn-light-primary ml-1"
                                                data-dismiss="modal" v-on:click="data.note=''">
                                                <span>Cancel</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-action-btn mb-1 d-flex">
                                    <div class="preview w-50 mr-50 dropup">
                                        <button class="btn btn-light-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                            <span class="text-nowrap">Agregar descuento</span>
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label for="discount">Descuento</label>
                                                    <input type="number" class="form-control" v-model="discountControl" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-primary invoice-apply-btn"
                                                    data-dismiss="modal" onclick="calculate()">
                                                    <span>Apply</span>
                                                </button>
                                                <button type="button" class="btn btn-light-primary ml-1"
                                                    data-dismiss="modal" v-on:click="discountControl=''">
                                                    <span>Cancel</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="save w-50 dropup">
                                        <button class="btn btn-light-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                            <span class="text-nowrap">Pago adicional</span>
                                        </button>
                                        <div class="dropdown-menu p-1">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label for="discount">Pago adicional</label>
                                                    <input type="number" class="form-control" v-model="addPaymentControl" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-primary invoice-apply-btn"
                                                    data-dismiss="modal" onclick="calculate()">
                                                    <span>Apply</span>
                                                </button>
                                                <button type="button" class="btn btn-light-primary ml-1"
                                                    data-dismiss="modal" v-on:click="addPaymentControl=''">
                                                    <span>Cancel</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-action-btn mb-1">
                                    <button type="submit" id="createSale" class="btn btn-success btn-block">
                                        <i class="bx bx-save"></i>
                                        <span>Guardar factura</span>
                                    </button>
                                  </div>
                                <input type="hidden" id="itemsCount" name="itemsCount"><!-- itemsCount-->
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
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"><script>
    <script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/scripts/product-orders/script.js') }}"></script>
    <script src="{{ asset('js/scripts/sales/addSale.js') }}"></script>
    <script>
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });
    </script>
@endsection