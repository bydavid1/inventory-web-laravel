@extends('layouts.app')

@section('custom_header')
    <!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Fileinput -->
<link rel="stylesheet" href="{{ asset('plugins/fileinput/css/fileinput.min.css') }}">
@endsection

@section('content')
<div class="app-content content">
    <div class="content-header bg-white">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Agregar producto</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Inventario</a>
                                </li>
                                <li class="breadcrumb-item active">Agregar
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="content-wrapper">
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Editar Producto</h3>
                </div>
                <!-- /.card-header -->
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
                                        <div class="col-12">
                                            <div id="kv-avatar-errors-1" class="center-block" style="display:none;">
                                            </div>
                                            <div class="kv-avatar center-block">
                                                <input type="file" class="form-control" id="image"
                                                    placeholder="Imagen del producto" name="image" class="file-loading"
                                                    style="width:auto;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="codProduct" class="control-label">Codigo: </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                                        placeholder="Codigo del producto" name="code"
                                                        autocomplete="ggg-ss" value="{{ $product[0]->code }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-random"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /form-group-->
                                            <div class="form-group">
                                                <label for="productName" class="control-label">Nombre: </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="ft-box"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                                        placeholder="Nombre del producto" name="name"
                                                        autocomplete="ggg-ss" value="{{ $product[0]->name }}">
                                                </div>
                                            </div>
                                            <!-- /form-group-->
                                            <div class="form-group">
                                                <label>Proveedor:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-truck"></i></span>
                                                    </div>
                                                    <select class="form-control" id="provider_id" name="provider_id">
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
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                                    </div>
                                                    <select class="form-control" id="category_id" name="category_id">
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
                                                                class="fa fa-spinner"></i></span>
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
                                                                class="fa fa-asterisk"></i></span>
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
                                                <label for="quantity" class="control-label">Stock: </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-cubes"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="quantity"
                                                        placeholder="Stock" name="stock" autocomplete="ggg-ss"
                                                        value="{{ $product[0]->stock }}">
                                                </div>
                                            </div>
                                            <!-- /form-group-->
                                            <div class="form-group">
                                                <label>Fabricante:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-industry"></i></span>
                                                    </div>
                                                    <select class="form-control" id="manufacturer_id"
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
                                                            class="fa fa-dollar"></i></span>
                                                </div>
                                                <input type="decimal" class="form-control" id="purchase"
                                                    placeholder="Precio de compra" name="purchase"
                                                    autocomplete="ggg-ss" value="{{ number_format($product[0]->purchase_prices[0]->value, 2) }}" />
                                            </div>
                                            @for ($i = 1; $i < 5; $i++) 
                                                <div class="input-group mt-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-dollar"></i></span>
                                                    </div>
                                                    <input type="decimal" class="form-control" id="price{{ $i }}"
                                                        placeholder="Precio {{ $i }}" name="price{{ $product[0]->prices[$i - 1]->id }}"
                                                        onkeyup="calculate('price{{ $i }}', 'add')"
                                                        autocomplete="ggg-ss"
                                                        value="{{ number_format($product[0]->prices[$i - 1]->price, 2) }}" />
                                                </div>
                                            @endfor
                                        </div>
                                        <!------- Right column------------>
                                        <div class="col-sm-6">
                                            <div class="input-group" id="message">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-percent"></i></span>
                                                </div>
                                                <select data-placeholder="Seleciona una categoría" class="custom-select"
                                                    id="tax_id" name="tax_id">
                                                    <option value="1">13%</option>
                                                </select>
                                            </div>
                                            @for ($i = 1; $i < 5; $i++) 
                                                <div class="input-group mt-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-exchange"></i></span>
                                                    </div>
                                                    <input type="decimal" class="form-control" id="utility{{ $i }}"
                                                        placeholder="Utilidad {{ $i }}" name="utility{{ $product[0]->prices[$i - 1]->id }}"
                                                        onkeyup="calculate('utility{{ $i }}', 'add')" autocomplete="ggg-ss"
                                                        value="{{ number_format($product[0]->prices[$i - 1]->utility, 2) }}" />
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <!-- /left bottom group-->
                                <!-- Right bottom group-->
                                <div class="col-sm-6">
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ft-clipboard"></i></span>
                                        </div>
                                        <textarea class="form-control" id="description" placeholder="Ingrese una descripción"
                                            name="description">
                                        {{ $product[0]->description }}
                                    </textarea>
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
                                autocomplete="ggg-ss"> <i class="fa fa-ok-sign"></i> Guardar</button>
                        </div>
                        <!-- /modal-footer -->
                    </form>
                    <!-- /.form -->
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom_footer')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Fileinput -->
<script src="{{ asset('plugins/fileinput/js/fileinput.min.js') }}"></script>
<!-- Owner -->
<script src="{{ asset('js/scripts/product/editProduct.js') }}"></script>
<script>
    //Initialize Select2 Elements
    $('#provider_id').select2()
    $('#category_id').select2()
    $('#manufacturer_id').select2()


    $("#image").fileinput({
        overwriteInitial: true,
        maxFileSize: 2500,
        showClose: false,
        showCaption: true,
        browseLabel: 'Buscar en el equipo',
        removeLabel: 'Quitar',
        browseIcon: '<i class="fa fa-folder-open"></i>',
        removeIcon: '<i class="fa fa-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="{{ asset($product[0]->images[0]->src) }}" alt="Profile Image" style="width:100%;">',
        layoutTemplates: {
            main2: '{preview} {remove} {browse}'
        },
        allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
    });
</script>
@endsection