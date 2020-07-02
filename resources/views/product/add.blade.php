@extends('layouts.app')

@section('custom_header')
    <!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Fileinput -->
<link rel="stylesheet" href="{{ asset('plugins/fileinput/css/fileinput.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Agregar producto</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Productos</li>
                    <li class="breadcrumb-item active">Agregar producto</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- /.col -->
<div class="col-md-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Agregar Producto</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if ( session('mensaje') )
                <div class="alert alert-success">{{ session('mensaje') }}</div>
            @endif
            @if($errors->has(['code', 'name', 'purchase', 'quantity', 'price1']))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Faltan datos importantes
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
            </div>
            @endif
            <form class="form-horizontal" id="submitProductForm" enctype="multipart/form-data">
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
                                        <label for="codProduct" class="col-sm-3 control-label">Codigo: </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="code"
                                                placeholder="Codigo del producto" name="code" autocomplete="off" value="{{ old('code') }}">
                                        </div>
                                    </div>
                                    <!-- /form-group-->

                                    <div class="form-group">
                                        <label for="productName" class="col-sm-3 control-label">Nombre: </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Nombre del producto" name="name" autocomplete="off" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <!-- /form-group-->

                                    <div class="form-group col-sm-12">
                                        <label>Proveedor:</label>
                                        <select data-placeholder="Seleciona un proveedor" style="width: 100%;" class="select2bs4" id="provider_id" name="provider_id">
                                            @foreach ($providers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /form-group-->

                                    <div class="form-group col-sm-12">
                                        <label>Categoría:</label>
                                        <select data-placeholder="Seleciona una categoría" style="width: 100%;" class="select2bs4" id="category_id" name="category_id">
                                            @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /form-group-->
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="productStatus" class="col-sm-3 control-label">Estado: </label>
                                        <div class="col-sm-12">
                                            <select class="form-control" id="is_available" name="is_available">
                                                <option value="1">Disponible</option>
                                                <option value="0">No disponible</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="form-group">
                                        <label for="type" class="col-sm-3 control-label">Tipo: </label>
                                        <div class="col-sm-12">
                                            <select class="form-control" id="type" name="type">
                                                <option value="1">Fisico</option>
                                                <option value="2">Servicio</option>
                                                <option value="3">No especificado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /form-group-->

                                    <div class="form-group">
                                        <label for="quantity" class="col-sm-3 control-label">Stock: </label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="quantity" placeholder="Stock"
                                                name="quantity" autocomplete="off" value="{{ old('quantity') }}">
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="form-group col-sm-12">
                                        <label>Fabricante:</label>
                                        <select data-placeholder="Seleciona una categoría" style="width: 100%;" class="select2bs4" id="manufacturer_id" name="manufacturer_id">
                                            @foreach ($manufacturers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /form-group-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bottom content-->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <div class="input-group" id="message">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="purchase"
                                        placeholder="Precio de compra" name="purchase" autocomplete="off" value="{{ old('purchase') }}"/>
                                </div>
                            </div>
                            <br>
                            <!-- /form-group-->
                            <div class="row">
                                <!-- Left Bottom group-->
                                <div class="col-sm-6">
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="price1" placeholder="Precio 1"
                                                name="price1" onkeyup="calculate('price1', 'add')" autocomplete="off" value="{{ old('price1') }}"/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="price2" placeholder="Precio 2"
                                                name="price2" onkeyup="calculate('price2', 'add')" autocomplete="off" value="{{ old('price2') }}"/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="price3" placeholder="Precio 3"
                                                name="price3" onkeyup="calculate('price3', 'add')" autocomplete="off" value="{{ old('price3') }}"/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group" id="alert">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="price4" placeholder="Precio 4"
                                                name="price4" onkeyup="calculate('price4', 'add')" autocomplete="off" value="{{ old('price4') }}"/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
        
                                </div>
                                <div class="col-sm-6">
        
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="utility1" placeholder="Utilidad 1"
                                                name="utility1" onkeyup="calculate('utility1', 'add')" autocomplete="off" value="{{ old('utility1') }}"/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="utility2" placeholder="Utilidad 2"
                                                name="utility2" onkeyup="calculate('utility2', 'add')" autocomplete="off" value="{{ old('utility2') }}"/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="utility3" placeholder="Utilidad 3"
                                                name="utility3" onkeyup="calculate('utility3', 'add')" autocomplete="off" value="{{ old('utility3') }}"/>
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                    <div class="col-sm-12 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                            </div>
                                            <input type="decimal" class="form-control" id="utility4" placeholder="Utilidad 4"
                                                name="utility4" onkeyup="calculate('utility4', 'add')" autocomplete="off" value="{{ old('utility4') }}"/>
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
                                    <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                </div>
                                <textarea class="form-control" id="description" placeholder="Ingrese una descripción"
                                    name="description"></textarea>
                            </div>
                        </div>
                         <!--/ Right bottom group-->
                    </div>
                </div>
    <!-- /modal-body -->

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                class="glyphicon glyphicon-remove-sign"></i> Cerrar</button>

        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..."
            autocomplete="off"> <i class="fas fa-ok-sign"></i> Guardar</button>

      <button type="submit" class="btn btn-success" id="createAndClose" data-loading-text="Loading..."
            autocomplete="off"> <i class="fas fa-ok-sign"></i> Guardar y salir</button>
    </div>
    <!-- /modal-footer -->
    </form>
    <!-- /.form -->
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>

@endsection

@section('custom_footer')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Fileinput -->
<script src="{{ asset('plugins/fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
   $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

     })

     $("#image").fileinput({
        overwriteInitial: true,
        maxFileSize: 2500,
        showClose: false,
        showCaption: true,
        browseLabel: 'Buscar en el equipo',
        removeLabel: 'Quitar',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="{{ asset("media/placeholder.png") }}" alt="Profile Image" style="width:100%;">',
        layoutTemplates: {
            main2: '{preview} {remove} {browse}'
        },
        allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
    })

</script>
<script>
    $('#submitProductForm').unbind('submit').bind('submit', function (stay) {
        stay.preventDefault();
        var formdata = $(this).serialize();
        var url = "{{ route('makeProduct') }}";
        $.ajax({
            type: 'POST',
            url: url,
            data: formdata,
            beforeSend: function () {
                Swal.fire({
                    title: 'Guardando',
                    html: 'Por favor espere...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                })
            },
            success: function (response) {
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                //Clear all fields
                $('#submitProductForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
            },
            error: function (xhr, textStatus, errorMessage) {
                Swal.fire({
                    position: 'top',
                    type: 'error',
                    html: 'Error crítico: ' + xhr.responseText,
                    showConfirmButton: true,
                });
            }
        });
    });
</script>
@endsection