@extends('layouts.app')

@section('custom_header')
    <!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Fileinput -->
<link rel="stylesheet" href="{{ asset('plugins/fileinput/css/fileinput.min.css') }}">
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
            <form class="form-horizontal" id="submitProductForm" action="../processes/php/createProduct.php" method="POST"
                enctype="multipart/form-data">
                <div id="add-product-messages"></div>

                <div class="col-12 col-md-10 container">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="productImage" class="col-12 control-label">Imagen: </label>
                                <div class="col-12">
                                    <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
                                    <div class="kv-avatar center-block">
                                        <input type="file" class="form-control" id="productImage"
                                            placeholder="Imagen del producto" name="productImage" class="file-loading"
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
                                            <input type="text" class="form-control" id="codProduct"
                                                placeholder="Codigo del producto" name="codProduct" autocomplete="off">
                                        </div>
                                    </div>
                                    <!-- /form-group-->

                                    <div class="form-group">
                                        <label for="productName" class="col-sm-3 control-label">Nombre: </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="productName"
                                                placeholder="Nombre del producto" name="productName" autocomplete="off">
                                        </div>
                                    </div>
                                    <!-- /form-group-->

                                    <div class="form-group col-sm-12">
                                        <label>Fabricante:</label>
                                        <select data-placeholder="Seleciona un fabricante" style="width: 100%;" class="select2bs4" id="provName" name="provName">
                                           //loop
                                        </select>
                                    </div>
                                    <!-- /form-group-->

                                    <div class="form-group col-sm-12">
                                        <label>Categoría:</label>
                                        <select data-placeholder="Seleciona una categoría" style="width: 100%;" class="select2bs4" id="categoryName" name="categoryName">
                                            //loop
                                        </select>
                                    </div>
                                    <!-- /form-group-->
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="productStatus" class="col-sm-3 control-label">Estado: </label>
                                        <div class="col-sm-12">
                                            <select class="form-control" id="productStatus" name="productStatus">
                                                <option value="1">Disponible</option>
                                                <option value="2">No disponible</option>
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
                                                name="quantity" autocomplete="off">
                                        </div>
                                    </div>
                                    <!-- /form-group-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-8">
                        <div class="input-group" id="message">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="decimal" class="form-control" id="purchase_price"
                                placeholder="Precio de compra" name="purchase_price" autocomplete="off" />
                        </div>
                    </div>
                    <!-- /form-group-->

                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="price1" placeholder="Precio 1"
                                        name="price1" onkeyup="calculate('price1', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->
                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="price2" placeholder="Precio 2"
                                        name="price2" onkeyup="calculate('price2', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->
                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="price3" placeholder="Precio 3"
                                        name="price3" onkeyup="calculate('price3', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->
                            <div class="col-sm-12 mb-3">
                                <div class="input-group" id="alert">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="price4" placeholder="Precio 4"
                                        name="price4" onkeyup="calculate('price4', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->

                        </div>
                        <div class="col-sm-4">

                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="utility1" placeholder="Utilidad 1"
                                        name="utility1" onkeyup="calculate('utility1', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->
                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="utility2" placeholder="Utilidad 2"
                                        name="utility2" onkeyup="calculate('utility2', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->
                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="utility3" placeholder="Utilidad 3"
                                        name="utility3" onkeyup="calculate('utility3', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->
                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-funnel-dollar"></i></span>
                                    </div>
                                    <input type="decimal" class="form-control" id="utility4" placeholder="Utilidad 4"
                                        name="utility4" onkeyup="calculate('utility4', 'add')" autocomplete="off" />
                                </div>
                            </div>
                            <!-- /form-group-->

                        </div>
                    </div>
                </div>
    <!-- /modal-body -->

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                class="glyphicon glyphicon-remove-sign"></i> Cerrar</button>

        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..."
            autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>

      <button type="submit" class="btn btn-success" id="createAndClose" data-loading-text="Loading..."
            autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar y salir</button>
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
<script>
   $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
     });

     $("#productImage").fileinput({
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
        defaultPreviewContent: '<img src="../assets/images/photo_default.png" alt="Profile Image" style="width:100%;">',
        layoutTemplates: {
            main2: '{preview} {remove} {browse}'
        },
        allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
    });
</script>
@endsection