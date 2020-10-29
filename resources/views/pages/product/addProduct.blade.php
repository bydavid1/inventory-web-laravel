@extends('layouts.app')

{{-- title --}}
@section('title','Agregar producto')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/fileinput.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form class="form-horizontal" id="submitProductForm" action="{{ route('storeProduct') }}" enctype="multipart/form-data">
            @csrf
            <div id="add-product-messages"></div>

            <div class="col-12 col-md-10 container">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="productImage" class="col-12 control-label">Imagen: </label>
                            <div class="col-12">
                                <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
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
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bxs-truck"></i></span>
                                        </div>
                                        <select class="form-control" id="provider_id" name="provider_id">
                                            @foreach ($providers as $item)
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
                                            <span class="input-group-text"><i class="bx bxs-tag"></i></span>
                                        </div>
                                        <select class="form-control" id="category_id" name="category_id">
                                            @foreach ($categories as $item)
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
                                        <input type="number" class="form-control" id="quantity"
                                            placeholder="Stock" name="quantity" autocomplete="ggg-ss">
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label>Fabricante:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bxs-factory"></i></span>
                                        </div>
                                        <select class="form-control" id="manufacturer_id" name="manufacturer_id">
                                            @foreach ($manufacturers as $item)
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
                <div class="row">
                    <div class="col-sm-6">
                        <br>
                        <!-- /form-group-->
                        <div class="row">
                            <!-- Left Bottom group-->
                            <div class="col-sm-6">
                                <div class="col-sm-12 mb-1">
                                    <div class="input-group" id="message">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                        </div>
                                        <input type="decimal" class="form-control" id="purchase"
                                            placeholder="Precio de compra" name="purchase" autocomplete="ggg-ss" />
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-1">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                        </div>
                                        <input type="decimal" class="form-control" id="price1"
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
                                        <input type="decimal" class="form-control" id="price2"
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
                                        <input type="decimal" class="form-control" id="price3"
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
                                        <input type="decimal" class="form-control" id="price4"
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
                                        <select data-placeholder="Seleciona una categoría"
                                            class="custom-select" id="tax_id" name="tax_id">
                                            <option value="1">13%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-1">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                        </div>
                                        <input type="decimal" class="form-control" id="utility1"
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
                                        <input type="decimal" class="form-control" id="utility2"
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
                                        <input type="decimal" class="form-control" id="utility3"
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
                                        <input type="decimal" class="form-control" id="utility4"
                                            placeholder="Utilidad 4" disabled name="utility4"
                                            onkeyup="calculate('utility4', 'add')" autocomplete="ggg-ss" />
                                    </div>
                                </div>
                                <!-- /form-group-->
                            </div>
                        </div>
                    </div>
                    <!-- /left bottom group-->
                    <!-- Right bottom group-->
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="bx bx-file"></i></span>
                            </div>
                            <textarea class="form-control" id="description"
                                placeholder="Ingrese una descripción" name="description"></textarea>
                        </div>
                        <div class="alert alert-danger alert-icon-left d-none mt-1" role="alert" id="posterror">
                            Hay datos importantes que hacen falta
                        </div>
                    </div>
                    <!--/ Right bottom group-->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                        class="glyphicon glyphicon-remove-sign"></i> Cerrar</button>

                <button type="submit" class="btn btn-success" id="createAndClose" data-loading-text="Loading..."
                    autocomplete="ggg-ss"> <i class="bx bx-ok-sign"></i> Guardar y salir</button>
            </div>
            <!-- /modal-footer -->
        </form>
        <!-- /.form -->
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->


@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('vendors/js/extensions/fileinput.min.js')}}"></script>
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

@section('page-scripts')
@routes
<script src="{{ asset('js/scripts/product/addProduct.js') }}"></script>
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
        browseIcon: '<i class="bx bx-folder-open"></i>',
        removeIcon: '<i class="bx bx-x"></i>',
        removeTitle: 'Reiniciar',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="{{ asset("assets/media/placeholder.png") }}" alt="Profile Image" style="width:100%;">',
        layoutTemplates: {
            main2: '{preview} {remove} {browse}'
        },
        allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
    })

</script>
@endsection
