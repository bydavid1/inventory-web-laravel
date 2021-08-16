@extends('layouts.app')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .pos-app{
        height: calc(100vh - 8.75rem);
    }

    .inventory-list{
        height: 100% !important;
        padding-top: 5px;
        padding-right: 0px !important;
    }

    .inventory-results{
        height: 100%;
        overflow:auto;
        margin-top: 10px;
    }

    .invoice-details{
        height: 100% !important;
        padding: 0px !important;
        overflow: auto;
        border-left: 1px solid #707070
    }

    .item-list{
        overflow: auto;
        height: calc(100% - 384.5px - 83px);
    }

    .bottom-details{
        position: absolute;
        bottom: 0px;
        width: 100%
    }
</style>
@endsection

@section('content')
<div id="app" class="pos-app">
    <form id="createOrderForm" class="h-100" v-on:submit.prevent="saveSale()">
        <div class="row h-100">
            <div class="col-md-8 inventory-list">
                <div class="col-md-12 row">
                    <div class="col-md-10">
                        <fieldset>
                            <div class="input-group mt-1">
                                <input class="form-control form-control-lg" v-model="searchControl" v-on:keyup="searchTimer" type="search" autofocus
                                    autocomplete="off" placeholder="Buscar en el inventario">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div v-if="loader == true" class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <i v-else class="bx bx-search"></i>
                                    </span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center pt-2">
                        <pagination :data="inventory" v-on:change="getInventory($event)"></pagination>
                    </div>
                </div>
                <div class="inventory-results">
                    <div class="row py-2 px-1">
                        <product v-on:add="add(product.id)" :product="product" :key="product.id" v-for="product in inventory.data"></product>
                    </div>
                </div>
            </div>
            <div class="col-md-4 invoice-details">
                <div class="card mb-0 shadow-none p-2">
                    <div class="row">
                        <div class="col-md-3 h-100 my-auto">
                            <h4>Cliente</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                                </div>
                                <input type="hidden" id="costumerid" name="costumerid"/>
                                <input type="text" class="form-control" placeholder="Buscar" id="costumer"
                                    name="name" aria-label="Enter..." aria-describedby="button-add" autocomplete="off"/>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="button-add" data-toggle="modal"
                                    data-target="#addCostumer"><i
                                            class="bx bx-plus mr-1"></i>Nuevo cliente</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-list">
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
                        <div v-for="(item, index) in items" :key="item.id">
                            <item :item="item" v-on:remove="removeItem(index)"></item>
                        </div>
                    </ul>
                </div>
                <div class="bottom-details">
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
                            <div class="invoice-action-btn mb-1 mt-1">
                                <div class="dropup">
                                    <button class="btn btn-light-primary btn-block dropdown-toggle" id="additionalNote" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                        <span>Agregar nota</span>
                                      </button>
                                      <div class="dropdown-menu p-1" aria-labelledby="additionalNote">
                                          <div class="row">
                                              <div class="col-12 form-group">
                                                  <label>Nota</label>
                                                  <textarea class="form-control" v-model="data.note" placeholder="Nota descriptiva"></textarea>
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
                            </div>
                            <div class="invoice-action-btn mb-1 d-flex">
                                <div class="preview w-50 mr-50">
                                    <div class="dropup">
                                        <button class="btn btn-light-primary btn-block dropdown-toggle" id="additionalDiscount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                            <span class="text-nowrap">Agregar descuento</span>
                                        </button>
                                        <div class="dropdown-menu p-1" aria-labelledby="additionalDiscount">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label for="discount">Descuento</label>
                                                    <input type="number" class="form-control" v-model="discountControl" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-primary invoice-apply-btn"
                                                    data-dismiss="modal" v-on:click="addDiscount()">
                                                    <span>Apply</span>
                                                </button>
                                                <button type="button" class="btn btn-light-primary ml-1"
                                                    data-dismiss="modal">
                                                    <span>Cancel</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="save w-50">
                                    <div class="dropup">
                                        <button class="btn btn-light-primary btn-block dropdown-toggle" id="additionalPayment" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                            <span class="text-nowrap">Pago adicional</span>
                                        </button>
                                        <div class="dropdown-menu p-1" aria-labelledby="additionalPayment">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label for="discount">Pago adicional</label>
                                                    <input type="number" class="form-control" v-model="addPaymentControl" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-primary invoice-apply-btn"
                                                    data-dismiss="modal" v-on:click="addPayment()">
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
                            </div>
                            <div class="invoice-action-btn mb-1">
                                <button type="submit" class="btn btn-success btn-block">
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

<!-- ---------------------------------------------------------------------------------- -->
<!-- --------------------Modal-------------------- -->
<!-- ---------------------------------------------------------------------------------- -->

<div class="modal fade right" tabindex="-1" role="dialog" id="addCostumer">
    <div class="modal-dialog modal-full-height modal-right">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear Nuevo cliente</h4>
                <button class="close ml-2" data-dismiss="modal" arial-label="close"><span
                    aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="bx bx-user fa-4x text-primary mb-1"></i>
                </div>
                <form action="{{ route('makeCostumer') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Codigo: </label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" placeholder="Nombre" name="code"
                                autocomplete="off" value="{{ old('code') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="name"
                                autocomplete="off" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">NIT: </label>
                        <div class="col-sm-12">
                            <input type="tel" class="form-control" placeholder="Nombre" name="nit"
                                autocomplete="off" value="{{ old('nit') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Telefono: </label>
                        <div class="col-sm-12">
                            <input type="tel" class="form-control" placeholder="Nombre" name="phone"
                                autocomplete="off" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Email: </label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" placeholder="Nombre" name="email"
                                autocomplete="off" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Direccion: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="address"
                                autocomplete="off" value="{{ old('address') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off"> <i class="fas fa-check"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Search product modal form -->
@include('pages.product-order.productModal')

@endsection

@section('vendor-scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
@endsection

@section('page-scripts')
@routes
    <script type="module" src="{{ asset('js/scripts/product-orders/script.js') }}"></script>
    <script>
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });
    </script>
@endsection
