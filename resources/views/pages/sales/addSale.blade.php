@extends('layouts.app')

@section('vendor-styles')
<<<<<<< HEAD
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/sweetalert/sweetalert2.min.css')}}">
=======
<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
>>>>>>> database
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .pos-app {
        height: calc(100vh - 8.75rem);
        display: flex;
        flex-direction: column
    }

    .pos-header {
        width: 100%;
        display: flex;
    }

    .pos-content{
        height: 100%;
        display: flex;
        overflow: auto
    }

    .pos-details {
        display: flex;
        flex-direction: column;
        height: 100% !important;
        padding: 0px !important;
    }

    .items-list {
        overflow: auto;
        height: 100%;
    }

    .bottom-details {
        position: relative;
        bottom: 0px;
        width: 100%
    }

    .config-header {
        border-bottom: 1px solid #94a4b6
    }

    .inventory-list {
        display: flex;
        flex-direction: column;
        height: 100% !important;
        border-left: 1px solid #94a4b6
    }

    .inventory-search{
        display: flex;
    }

    .inventory-results {
        height: 100%;
        overflow: auto;
        padding-top: 10px;
    }

    .invoice-subtotal-title {
        color: #727E8C;
    }

    .invoice-subtotal-value {
        color: #304156;
    }

</style>
@endsection

@section('content')
<div id="app" class="pos-app" v-on:click="appClick()">
    <div class="pos-header">
        <div class="col-md-4 p-0">
            <div class="card mb-0 shadow-none w-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="form-group my-auto">
                                <label>Cliente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                                    </div>
                                    <input type="hidden" v-model="data.customerId" />
                                    <input type="text" class="form-control" v-model="data.customerName" id="customerId"
                                        placeholder="Nombre del cliente" v-on:keyup="searchTimer('searchCostumer')"
                                        autocomplete="off" />
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="button-add"
                                            data-toggle="modal" data-target="#addCostumer">
                                            <i class="bx bx-user-plus"></i>
                                        </button>
                                    </div>
                                    <div class="autocomplete-items" v-if="showAutocomplete">
                                        <div v-for="customer in customers" :key="customer.id"
                                            v-on:click="chooseCustomer(customer)">
                                            @{{ customer.name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 p-0 config-header">
            <div class="card mb-0 shadow-none w-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group my-auto">
                                <label>Tipo de pago</label>
                                <select class="form-control" v-model="data.paymentMethod">
                                    <option value="1">En efectivo</option>
                                    <option value="2">Tarjeta de debito</option>
                                    <option value="3">Tarjeta de credito</option>
                                    <option value="4">Cupon</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group my-auto">
                                <label>Tipo de factura</label>
                                <select class="form-control" v-model="data.invoiceType">
                                    <option value="1">Consumidor final</option>
                                    <option value="2">Credito fiscal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="invoice-terms">
                                <div class="d-flex justify-content-around pt-0 pb-50">
                                    <span class="invoice-terms-title">Auto impresión</span>
                                    <div class="custom-control custom-switch custom-switch-glow">
                                        <input type="checkbox" class="custom-control-input" checked="" disabled>
                                        <label class="custom-control-label" for="paymentTerm">
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around pb-0 pt-50">
                                    <span class="invoice-terms-title">Permitir notas</span>
                                    <div class="custom-control custom-switch custom-switch-glow">
                                        <input type="checkbox" class="custom-control-input" checked="" disabled>
                                        <label class="custom-control-label" for="clientNote">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pos-content">
        <div class="pos-details col-md-4">
            <div class="items-list">
                <div class="d-flex mt-1 w-100 pl-1">
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
                    <div class="card-body pb-0">
                        <div class="row pb-1">
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                        <span class="invoice-subtotal-title">Cantidad total</span>
                                        <h6 class="invoice-value mb-0">@{{ data.quantityValue }}</h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                        <span class="invoice-subtotal-title">Sub total</span>
                                        <h6 class="invoice-value mb-0">@{{ '$ ' + data.subtotalValue }}
                                        </h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                        <span class="invoice-subtotal-title">Descuentos</span>
                                        <h6 class="invoice-value mb-0">@{{ '$ ' + data.discountsValue }}
                                        </h6>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                        <span class="invoice-subtotal-title">Pagos adicionales</span>
                                        <h6 class="invoice-subtotal-value mb-0">@{{ '$ ' + data.additionalPayments }}</h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                        <span class="invoice-subtotal-title">Impuestos</span>
                                        <h6 class="invoice-subtotal-value mb-0">@{{ '$ ' + data.taxValue }}</h6>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                        <span class="invoice-subtotal-title">Total a pagar</span>
                                        <h6 class="invoice-subtotal-value mb-0">@{{ '$ ' + data.totalValue }}</h6>
                                    </li>
                                    <li class="list-group-item justify-content-between border-0 pb-0 d-none">
                                        <span class="invoice-subtotal-title">Interés</span>
                                        <h6 class="invoice-subtotal-value mb-0 text-primary">@{{ '$ ' + data.totalValue }}</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="invoice-action-btn mb-1 mt-1">
                            <div class="dropup">
                                <button class="btn btn-light-primary btn-block dropdown-toggle" id="additionalNote"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                    <span>Agregar nota</span>
                                </button>
                                <div class="dropdown-menu p-1" aria-labelledby="additionalNote">
                                    <div class="row">
                                        <div class="col-12 form-group">
                                            <label>Nota</label>
                                            <textarea class="form-control" v-model="data.note"
                                                placeholder="Nota descriptiva"></textarea>
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
                        <div class="mb-1 d-flex">
                            <div class="preview w-50 mr-50">
                                <div class="dropup">
                                    <button class="btn btn-light-primary btn-block dropdown-toggle"
                                        id="additionalDiscount" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" role="button">
                                        <span class="text-nowrap">Agregar descuento</span>
                                    </button>
                                    <div class="dropdown-menu p-1" aria-labelledby="additionalDiscount">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label for="discount">Descuento</label>
                                                <input type="number" class="form-control" v-model="discountControl"
                                                    placeholder="0">
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
                                    <button class="btn btn-light-primary btn-block dropdown-toggle"
                                        id="additionalPayment" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" role="button">
                                        <span class="text-nowrap">Pago adicional</span>
                                    </button>
                                    <div class="dropdown-menu p-1" aria-labelledby="additionalPayment">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label for="discount">Pago adicional</label>
                                                <input type="number" class="form-control"
                                                    v-model="addPaymentControl" placeholder="0">
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
                            <button type="button" v-on:click="saveSale()" class="btn btn-success btn-block">
                                <i class="bx bx-save"></i>
                                <span>Guardar factura</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="inventory-list col-md-8">
            <div class="inventory-search">
                <div class="col-md-10">
                    <fieldset>
                        <div class="input-group mt-1">
                            <input class="form-control form-control-lg" v-model="searchControl"
                                v-on:keyup="searchTimer('searchProduct')" type="search" autofocus autocomplete="off"
                                placeholder="Buscar en el inventario">
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
                <div class="row py-2 mx-0 px-1">
                    <product v-on:add="add(product.id)" :product="product" :key="product.id"
                        v-for="product in inventory.data"></product>
                </div>
            </div>
        </div>
    </div>
    <new_customer></new_customer>
</div>
@endsection

@section('vendor-scripts')
<<<<<<< HEAD
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
<script src="{{asset('js/libs/sweetalert/sweetalert2.all.min.js')}}"></script>
=======
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
<script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
>>>>>>> database
@endsection

@section('page-scripts')
@routes
<<<<<<< HEAD
<script type="module" src="{{ asset('js/scripts/sales/script.js') }}"></script>
=======
<script src="{{ asset('js/scripts/sales/addSale.js') }}"></script>
>>>>>>> database
<script>
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
</script>
@endsection
