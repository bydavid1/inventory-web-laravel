@extends('layouts.app')

{{-- title --}}
@section('title','Agregar producto')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fileinput/fileinput.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
@endsection

@section('content')

<div class="card">
    <div class="card-content">
        <div class="card-body">
            <div class="alert alert-danger alert-icon-left d-none mt-1" role="alert" id="posterror">

            </div>
            <section id="vertical-wizard">
                <form class="wizard-vertical" id="submitProductForm" action="{{ route('storeProduct') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- step 1 -->
                    <h3>
                        <span class="fonticon-wrap mr-1">
                            <i class="livicon-evo text-primary"
                                data-options="name:notebook.svg; size: 50px; style:lines;"></i>
                        </span>
                        <span class="icon-title">
                            <span class="d-block">Detalles</span>
                            <small class="text-muted">Ingresa la informacion general del producto.</small>
                        </span>
                    </h3>
                    <!-- step 1 end-->
                    <!-- step 1 content -->
                    <fieldset class="pt-0">
                        <h6 class="pb-50">Informacion del producto</h6>
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
                                        <select class="form-control select2" name="provider_id">
                                            @foreach ($providers as $item)
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
                                        <select class="form-control select2" name="manufacturer_id">
                                            @foreach ($manufacturers as $item)
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
                        <span class="fonticon-wrap mr-1">
                            <i class="livicon-evo text-primary"
                                data-options="name:us-dollar.svg; size: 50px; style:lines;"></i>
                        </span>
                        <span class="icon-title">
                            <span class="d-block">Inventario</span>
                            <small class="text-muted">Ingresa precios, cantidades y mas.</small>
                        </span>
                    </h3>
                    <!-- step 2 end-->
                    <!-- step 2 content -->
                    <fieldset class="pt-0">
                        <h6 class="py-50">Ingresa informacion de inventario</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group" id="message">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="purchase"
                                                    placeholder="Precio de compra" name="purchase"
                                                    autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="price1"
                                                    placeholder="Precio 1" disabled name="price1"
                                                    onkeyup="calculate('price1', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="price2"
                                                    placeholder="Precio 2" disabled name="price2"
                                                    onkeyup="calculate('price2', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="price3"
                                                    placeholder="Precio 3" disabled name="price3"
                                                    onkeyup="calculate('price3', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group" id="alert">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="price4"
                                                    placeholder="Precio 4" disabled name="price4"
                                                    onkeyup="calculate('price4', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                    </div>
                                    <!------- Right column------------>
                                    <div class="col-sm-6">
                                        <div class="col-sm-12 mb-1">
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
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="utility1"
                                                    placeholder="Utilidad 1" disabled name="utility1"
                                                    onkeyup="calculate('utility1', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="utility2"
                                                    placeholder="Utilidad 2" disabled name="utility2"
                                                    onkeyup="calculate('utility2', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="utility3"
                                                    placeholder="Utilidad 3" disabled name="utility3"
                                                    onkeyup="calculate('utility3', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                        <div class="col-sm-12 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                                </div>
                                                <input type="number" step=".01" min="0" class="form-control" id="utility4"
                                                    placeholder="Utilidad 4" disabled name="utility4"
                                                    onkeyup="calculate('utility4', 'add')" autocomplete="ggg-ss" />
                                            </div>
                                        </div>
                                        <!-- /form-group-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
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
                                    <label for="type" class="control-label">Tipo: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-package"></i></span>
                                        </div>
                                        <select class="form-control" id="type" name="type">
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
                                            <span class="input-group-text"><i class="bx bxs-component"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="quantity" placeholder="Stock"
                                            name="quantity" autocomplete="ggg-ss">
                                    </div>
                                </div>
                                <!-- /form-group-->
                            </div>
                        </div>
                    </fieldset>
                    <!-- step 2 content end-->
                    <!-- step 3 -->
                    <h3>
                        <span class="fonticon-wrap mr-1">
                            <i class="livicon-evo text-primary"
                                data-options="name:image.svg; size: 50px; style:lines;"></i>
                        </span>
                        <span class="icon-title">
                            <span class="d-block">Imagenes</span>
                            <small class="text-muted">Sube fotos de tu producto.</small>
                        </span>
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
<script src="{{asset('vendors/steps/jquery.steps.js')}}"></script>
<script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/fileinput/fileinput.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
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
        showUpload: false,
        showCancel: false,
        previewFileType: 'any',
        browseIcon: '<i class="bx bx-folder-open"></i>',
        removeIcon: '<i class="bx bx-trash"></i>',
        allowedFileExtensions: ["jpg", "png"]
    })
</script>
@endsection
