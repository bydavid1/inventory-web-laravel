@extends('layouts.app')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/sweetalert/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/fileinput/fileinput.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/select2/select2.min.css')}}">
@endsection

@section('content')

<div class="container">
    @if ( session('mensaje') )
    <div class="alert alert-success alert-icon-left alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {{ session('mensaje') }}
    </div>
    @endif
    @if ( session('error') )
    <div class="alert alert-danger alert-icon-left alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {{ session('error') }}
    </div>
    @endif
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Producto</h3>
    </div>
    <div class="card-body">
        <form class="form-horizontal" id="submitProductForm" action="{{ route('updateProduct', $product[0]->id) }}" method="POST"
                enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-12 col-md-10 container">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="productImage" class="col-12 control-label">Imagen: </label>
                                <input type="file" class="form-control" id="image"
                                    placeholder="Imagen del producto" name="image" class="file-loading"
                                    style="width:auto;" />
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="codProduct" class="control-label">Codigo: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-key"></i></span>
                                        </div>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                            placeholder="Codigo del producto" name="code"
                                            autocomplete="ggg-ss" value="{{ $product[0]->code }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i
                                                    class="bx bx-shuffle"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label for="productName" class="control-label">Nombre: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-news"></i></span>
                                        </div>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="Nombre del producto" name="name"
                                            autocomplete="ggg-ss" value="{{ $product[0]->name }}">
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label>Proveedor:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="bx bxs-truck"></i></span>
                                        </div>
                                        <select class="form-control select2" id="provider_id" name="provider_id">
                                            @foreach ($suppliers as $item)
                                            @if ($item->id == $product[0]->supplier_id)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                (Seleccionado)</option>
                                            @endif
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label>Categoría:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                        </div>
                                        <select class="form-control select2" id="category_id" name="category_id">
                                            @foreach ($categories as $item)
                                            @if ($item->id == $product[0]->category_id)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                (Seleccionado)</option>
                                            @endif
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="productStatus" class="control-label">Estado: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="bx bx-loader"></i></span>
                                        </div>
                                        <select class="form-control" id="is_available" name="is_available">
                                            @if ($product[0]->is_available == 1)
                                            <option value="1" selected>Disponible (Seleccionado)</option>
                                            @endif
                                            @if ($product[0]->is_available == 0)
                                            <option value="0" selected>No disponible (Seleccionado)</option>
                                            @endif
                                            <option value="1">Disponible</option>
                                            <option value="0">No disponible</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label for="type" class="control-label">Tipo: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="bx bx-package"></i></span>
                                        </div>
                                        <select class="form-control" id="type" name="type">
                                            @if ($product[0]->type == 1)
                                            <option value="1" selected>Fisico (Seleccionado)</option>
                                            @endif
                                            @if ($product[0]->type == 2)
                                            <option value="2" selected>Servicio (Seleccionado)</option>
                                            @endif
                                            @if ($product[0]->type == 3)
                                            <option value="3" selected>No especificado (Seleccionado)
                                            </option>
                                            @endif
                                            <option value="1">Fisico</option>
                                            <option value="2">Servicio</option>
                                            <option value="3">No especificado</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label>Fabricante:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="bx bxs-factory"></i></span>
                                        </div>
                                        <select class="form-control select2" id="manufacturer_id"
                                            name="manufacturer_id">
                                            @foreach ($manufacturers as $item)
                                                @if ($item->id == $product[0]->manufacturer_id)
                                                <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                    (Seleccionado)</option>
                                                @endif
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bottom content-->
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <br>
                        <div class="row">
                            <!-- Left Bottom group-->
                            <div class="col-sm-6">
                                <div class="input-group" id="message">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                class="bx bx-dollar"></i></span>
                                    </div>
                                    <input type="number" step=".01" min="0" class="form-control" id="purchase"
                                        placeholder="Precio de compra" name="purchase"
                                        autocomplete="ggg-ss" value="{{ number_format($product[0]->purchase_prices[0]->value, 2) }}" />
                                </div>
                                @foreach ($product[0]->prices as $item)
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="bx bx-dollar"></i></span>
                                        </div>
                                        <input type="number" step=".01" min="0" class="form-control" id="price"
                                            placeholder="Precio" name="price"
                                            onkeyup="calculate('price', 'add')"
                                            autocomplete="ggg-ss"
                                            value="{{ number_format($item['price'], 2) }}" />
                                    </div>
                                @endforeach
                            </div>
                            <!------- Right column------------>
                            <div class="col-sm-6">
                                <div class="input-group" id="message">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <select data-placeholder="Seleciona una categoría" class="custom-select"
                                        id="tax_id" name="tax_id">
                                        <option value="1">13%</option>
                                    </select>
                                </div>
                                @foreach ($product[0]->prices as $item)
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                        </div>
                                        <input type="number" step=".01" min="0" class="form-control" id="utility"
                                            placeholder="Utilidad" name="utility"
                                            onkeyup="calculate('utility', 'add')" autocomplete="ggg-ss"
                                            value="{{ number_format($item['utility'], 2) }}" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- /left bottom group-->
                    <!-- Right bottom group-->
                    <div class="col-sm-6">
                        <br>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                                </div>
                                <textarea class="form-control" id="description" placeholder="Ingrese una descripción"
                                    name="description">
                                    {{ $product[0]->description }}
                                </textarea>
                            </div>
                        </div>
                        <div class="alert alert-danger alert-icon-left d-none mt-1" role="alert" id="posterror">
                            Hay datos importantes que hacen falta
                        </div>
                    </div>
                    <!--/ Right bottom group-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="createAndClose" data-loading-text="Loading..."
                    autocomplete="ggg-ss"> <i class="bx bx-ok-sign"></i> Guardar</button>
            </div>
            <!-- /modal-footer -->
        </form>
        <!-- /.form -->
    </div>
    <!-- /.card-body -->
</div>
@endsection

@section('vendor-scripts')
<script src="{{asset('js/libs/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/libs/fileinput/fileinput.min.js')}}"></script>
<script src="{{asset('js/libs/select2/select2.full.min.js')}}"></script>
@endsection

@section('page-scripts')
@routes
<script src="{{ asset('js/scripts/product/editProduct.js') }}"></script>
<script>
    // Basic Select2 select
    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });


    $("#image").fileinput({
        showUpload: false,
        showCancel: false,
        previewFileType: 'any',
        browseIcon: '<i class="bx bx-folder-open"></i>',
        removeIcon: '<i class="bx bx-trash"></i>',
        allowedFileExtensions: ["jpg", "png"]
    })
</script>
@endsection

