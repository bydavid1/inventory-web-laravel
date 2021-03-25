@extends('layouts.app')

{{-- title --}}
@section('title','Agregar compra')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/sweetalert/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/select2/select2.min.css')}}">

<style>
.invoice-item-title {
    color: #475F7B;
    font-weight: 500;
}

.pos-app {
        height: calc(100vh - 8.75rem);
        display: flex;
        flex-direction: column
}

.pos-header {
    width: 100%;
    display: flex;
    margin-bottom: 2rem;
}

.pos-content{
    height: 100%;
    display: flex;
    overflow: auto
}
</style>
@endsection

@section('content')
<div id="app" class="pos-app">
    <div class="pos-header">
        <div class="card mb-0 shadow-none w-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group my-auto">
                            <label class="control-label">Proveedor</label>
                            <select class="form-control" v-model="data.supplierId" placeholder="Enter..."
                                autocomplete="off">
                                <option value="" disabled selected>Selecciona un proveedor</option>
                                @foreach ($suppliers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group my-auto">
                            <label for="date" class="control-label">Fecha</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pos-content">
        <div class="col-md-8">
            <div class="card">
                <div class="card-content">
                    <div class="card-header border-bottom">
                        <h5 class="card-title">Detalles</h5>
                        <div class="heading-elements">
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#addNewProductModal">
                                <i class="bx bx-plus fa-2x"></i>
                                <span>Nuevo producto</span>
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#SearchProducts">
                                <i class="bx bx-search fa-2x"></i>
                                <span>Buscar producto</span>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table_details :items="items" v-on:edit="editNewProduct"></table_details>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3">Resumen</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Cantidad total
                            <strong v-html="data.quantityValue"></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sub total
                            <strong v-html="'$' + data.subtotalValue"></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Descuentos
                            <strong v-html="'$' + data.discountsValue"></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total
                            <strong v-html="'$' +  data.totalValue"></strong>
                        </li>
                    </ul>
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
                                        <textarea class="form-control" v-model="data.comments"
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
                            <button class="btn btn-light-primary btn-block">
                                <span class="text-nowrap">Guardar borrador</span>
                            </button>
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
                                                placeholder="0">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary invoice-apply-btn"
                                            data-dismiss="modal">
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
                    </div>
                    <div class="invoice-action-btn mb-1">
                        <button v-on:click="storePurchase()" class="btn btn-success btn-block mt-2">
                            <i class="bx bx-save"></i>
                            <span>Guardar compra</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ---------------------------------------------------------------------------------- -->
    <!-- --------------------Create new product modal-------------------- -->
    <!-- ---------------------------------------------------------------------------------- -->
    <div class="modal fade right" role="dialog" tabindex="-1" id="addNewProductModal">
        <div class="modal-dialog modal-full-height modal-right">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mx-auto">Crear un nuevo producto</h4>
                    <button class="close ml-2" data-dismiss="modal" arial-label="close"><span
                            aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bx bxs-component font-large-2"></i>
                        <p><i class="bx bx-info-circle text-primary mr-1"></i>El producto se guardará hasta que se
                            registre la compra</p>
                    </div>
                    <form role="form" id="newProductForm">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" v-model="newProduct.name" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label>Codigo</label>
                            <input type="text" class="form-control" v-model="newProduct.code" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label>Categoría</label>
                            <select class="form-control" v-model="newProduct.category">
                                @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control" v-model.number="newProduct.quantity" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="ppurchase"><i class="fas fa-dollar-sign"></i>Precio
                                de compra</label>
                            <input type="number" class="form-control" v-model.number="newProduct.purchase" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="price"><i class="fas fa-dollar-sign"></i>Precio
                                principal</label>
                            <input type="number" class="form-control" v-model.number="newProduct.price" placeholder="Enter ...">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" v-on:click="addNewProduct()" class="btn btn-primary btn-block">Agregar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ---------------------------------------------------------------------------------- -->
    <!-- --------------------Edit info modal-------------------- -->
    <!-- ---------------------------------------------------------------------------------- -->
    <div class="modal fade right" role="dialog" tabindex="-1" id="editNewProductModal">
        <div class="modal-dialog modal-full-height modal-right">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mx-auto">Editar informacion del producto</h4>
                    <button class="close ml-2" data-dismiss="modal" arial-label="close"><span
                            aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <form role="form" id="newProductForm">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" v-model="editProduct.name" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label>Codigo</label>
                            <input type="text" class="form-control" v-model="editProduct.code" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label>Categoría</label>
                            <select class="form-control" v-model="editProduct.category">
                                @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control" v-model.number="editProduct.quantity" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="ppurchase"><i class="fas fa-dollar-sign"></i>Precio
                                de compra</label>
                            <input type="number" class="form-control" v-model.number="editProduct.purchase" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="price"><i class="fas fa-dollar-sign"></i>Precio
                                principal</label>
                            <input type="number" class="form-control" v-model.number="editProduct.price" placeholder="Enter ...">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" v-on:click="confirmEditProduct()" class="btn btn-primary btn-block">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------------------------------------------------------------------------- -->
    <!-- --------------------Search product modal-------------------- -->
    <!-- ---------------------------------------------------------------------------------- -->
    <div class="modal fade" role="dialog" tabindex="-1" id="SearchProducts">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mx-auto">Busqueda en inventario</h4>
                    <button class="close ml-2" data-dismiss="modal" arial-label="close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <div class="input-group mt-1">
                            <input class="form-control form-control-lg" v-model="searchControl" v-on:keyup="searchTimer()" type="search" autofocus
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
                    <results :results="results" v-if="results.length > 0" class="mt-1" v-on:choose="chooseProduct"></results>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-scripts')
    <script src="{{asset('js/libs/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/libs/select2/select2.full.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
@endsection

@section('page-scripts')
    <script>
        $('#provider').select2()
    </script>
    @routes
    <script type="module" src="{{ asset('js/scripts/purchase/script.js') }}"></script>
@endsection
