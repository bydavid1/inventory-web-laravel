@extends('layouts.app')

{{-- title --}}
@section('title','Agregar producto')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/wizard/wizard.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/sweetalert/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/fileinput/fileinput.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/libs/select2/select2.css')}}">

@endsection

@section('content')

<div class="card">
    <div class="card-content">
        <div class="card-header">
            <h3 class="d-none">Crear producto</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-danger alert-dismissible d-none mt-1" role="alert" id="posterror">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error"></i>
                    <span id="posterrortitle">

                    </span>
                </div>
            </div>
            <section id="wizard">
                <form class="product-wizard" id="submitProductForm" action="{{ route('storeProduct') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- step 1 -->
                    <h3>
                        <i class="step-icon"></i>
                        <span class="fonticon-wrap">
                            <i class='bx bxs-package bx-md' ></i>
                        </span>
                        <span>Presentacion</span>
                    </h3>
                    <!-- step 1 end-->
                    <!-- step 1 content -->
                    <fieldset class="pt-0">
                        <hr class="my-2"/>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="codProduct" class="control-label">Codigo: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-key"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="code"
                                            placeholder="Codigo del producto" name="code" autocomplete="ggg-ss">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="bx bx-shuffle"></i></span>
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
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nombre del producto" name="name" autocomplete="ggg-ss">
                                    </div>
                                </div>
                                <!-- /form-group-->

                                <div class="form-group">
                                    <label>Proveedor:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bxs-truck"></i></span>
                                        </div>
                                        <select class="form-control select2" name="supplier_id">
                                            @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Categoría:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bxs-tag"></i></span>
                                        </div>
                                        <select class="form-control select2" name="category_id">
                                            @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->

                                <div class="form-group">
                                    <label>Fabricante:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bxs-factory"></i></span>
                                        </div>
                                        <select class="form-control select2" name="brand_id">
                                            @foreach ($brands as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->

                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-file"></i></span>
                                        </div>
                                        <textarea class="form-control" id="description"
                                            placeholder="Ingrese una descripción" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- step 1 content end-->

                    <!-- step 2 -->
                    <h3>
                        <i class="step-icon"></i>
                        <span class="fonticon-wrap">
                            <i class='bx bxs-barcode bx-md'></i>
                        </span>
                        <span>Inventario</span>
                    </h3>
                    <!-- step 2 end-->
                    <!-- step 2 content -->
                    <fieldset class="pt-0">
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                    <input type="checkbox" class="custom-control-input" name="is_service" id="is_service" onchange="serviceToogle()">
                                    <label class="custom-control-label mr-1" for="is_service"></label>
                                    <span>Guardar como servicio</span>
                                </div>
                                <div class="form-group">
                                    <label for="productStatus" class="control-label">Estado: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-loader"></i></span>
                                        </div>
                                        <select class="form-control" id="is_available" name="is_available">
                                            <option value="1">Disponible</option>
                                            <option value="0">No disponible</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label for="stock" class="control-label">Stock: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bxs-component"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="stock" placeholder="Stock"
                                            name="stock" autocomplete="ggg-ss">
                                    </div>
                                </div>
                                <!-- /form-group-->
                            </div>

                            {{-- prices table --}}

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Precio de compra</label>
                                            <div class="input-group" id="message">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" placeholder="Precio de compra" id="purchase" name="purchase"
                                                   onkeyup="calculate(this)" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Impuesto</label>
                                            <div class="input-group" id="message">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <select data-placeholder="Seleciona una categoría" class="custom-select"
                                                    id="tax_id" name="tax_id">
                                                    <option value="1">13%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6 class="col-sm-12">Tabla de precios</h6>
                                    <div class="col-sm-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                            </div>
                                            <input type="number" step=".01" min="0" class="form-control" placeholder="Precio 1" id="price1" name="prices[0][price]"
                                                onkeyup="calculate(this)" autocomplete="ggg-ss" disabled/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                            </div>
                                            <input type="number" step=".01" min="0" class="form-control" placeholder="Utilidad 1" id="utility1"  name="prices[0][utility]"
                                                onkeyup="calculate(this)" autocomplete="ggg-ss" disabled/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                            </div>
                                            <input type="number" step=".01" min="0" class="form-control" placeholder="Precio 2" id="price2" name="prices[1][price]"
                                                onkeyup="calculate(this)" autocomplete="ggg-ss" disabled/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                            </div>
                                            <input type="number" step=".01" min="0" class="form-control" placeholder="Utilidad 2" id="utility2" name="prices[1][utility]"
                                                onkeyup="calculate(this)" autocomplete="ggg-ss" disabled/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                            </div>
                                            <input type="number" step=".01" min="0" class="form-control" placeholder="Precio 3" id="price3"  name="prices[2][price]"
                                                onkeyup="calculate(this)" autocomplete="ggg-ss" disabled/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                            </div>
                                            <input type="number" step=".01" min="0" class="form-control" placeholder="Utilidad 3" id="utility3" name="prices[2][utility]"
                                                onkeyup="calculate(this)" autocomplete="ggg-ss" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- step 2 content end-->

                    <!-- step 3 -->
                    <h3>
                        <i class="step-icon"></i>
                        <span class="fonticon-wrap">
                            <i class='bx bxs-image-add bx-md'></i>
                        </span>
                        <span>Imagenes</span>
                    </h3>
                    <!-- step 3 end-->
                    <!-- step 3 content -->
                    <fieldset class="pt-0">
                        <h6 class="py-50">Enter your photos</h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Imagen: </label>
                                    <input type="file" class="form-control" id="image" data-msg-placeholder="Buscar"
                                        name="image" class="file-loading" />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- step 3 content end-->
                </form>
            </section>
        </div>
    </div>
</div>
<!-- /.card -->


@endsection

@section('vendor-scripts')
<script src="{{asset('js/libs/steps/jquery.steps.js')}}"></script>
<script src="{{asset('js/libs/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/libs/fileinput/fileinput.min.js')}}"></script>
<script src="{{asset('js/libs/select2/select2.full.js')}}"></script>
<script src="{{asset('js/libs/forms/validation/form-validation.js')}}"></script>
@endsection

@section('page-scripts')
@routes
<script src="{{ asset('js/scripts/product/addProduct.js') }}"></script>
<script>

    // Basic Select2 select
    $(".select2").select2({
        // the following code is used to disable x-scrollbar when click in select input and
        // take 100% width in responsive also
        dropdownAutoWidth: true,
        width: '100%'
    });


    $("#image").fileinput({
        browseClass: "btn btn-success",
        allowedFileExtensions: ["jpg", "png"],
        showUpload: false,
        showCancel: false,
        previewFileType: 'any',
        browseIcon: '<i class="bx bx-folder-open"></i>',
        removeIcon: '<i class="bx bx-trash"></i>',
        allowedFileExtensions: ["jpg", "png"]
    })
</script>
@endsection
