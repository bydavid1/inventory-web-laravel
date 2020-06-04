@extends('layouts.app')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
	  <!-- Select2 -->
	  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Agregar compra</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Compras</a></li>
                    <li class="breadcrumb-item active">Agregar compra</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@if ( session('mensaje') )
<div class="alert alert-success col-lg-8 mx-auto">{{ session('mensaje') }}</div>
@endif

<div class="mx-5">
    <div class="row">
        <div class="col-lg-6">
            <!--/Card-->
            <div class="card card-primary ">
                <!--/Header-->
                <div class="card-header">
                    <i class='glyphicon glyphicon-circle-arrow-right'></i>Agregar productos existentes
                </div>
                <!--/Body-->
                <div class="card-body">
                    <table class="table table-bordered table-condensed" id="items">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Producto</th>
                                <th>Disponible</th>
                                <th>Precio</th>
                                <th>Compra</th>
                                <th style="width: 15%">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- right column -->
        <div class="col-md-6">
            <!-- card -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Agregar producto nuevo</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="newProductForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" id="pname" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input type="text" class="form-control" id="pcode" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Proveedor</label>
                                    <select class="form-control" id="pprovider">
                                        @foreach ($providers as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Categoría</label>
                                    <select class="form-control" id="category">
                                        @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control" placeholder="Enter ..." id="pquantity">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="ppurchase"><i
                                            class="fas fa-dollar-sign"></i>Precio de compra</label>
                                    <input type="text" class="form-control" id="ppurchase" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="price"><i
                                            class="fas fa-dollar-sign"></i>Precio principal</label>
                                    <input type="text" class="form-control" id="price" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" onclick="addNewProduct()" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

    <!-- card-->
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">Información de la compra</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="createPurchaseForm">
                @csrf
                <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="provider" class="col-sm-2 control-label">Proveedor</label>
                                <div class="col-sm-8">
                                    <select data-placeholder="Seleciona un proveedor" class="select2bs4 col-sm-10" name="provider" placeholder="Enter..." autocomplete="off">
                                        @foreach ($providers as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            
                        </div>
                    </div>
                </div>
                <table class="table table-condensed" id="productTable">
                    <thead>
                        <tr class="info">
                            <th style="width:10%;">Codigo</th>
                            <th style="width:20%;">Producto</th>
                            <th style="width:10%;">Condición</th>
                            <th style="width:10%;">Precio</th>
                            <th style="width:10%;">Cantidad</th>
                            <th style="width:10%;">Total</th>
                            <th style="width:10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
    
                    </tbody>
                </table>
                <div class="row mt-2">
                    <div class="col-sm-6"></div>
                    <div class="col-md-6">
                        <div>
                            <label class="control-label">Cantidad total</label>
                            <p id="grandquantity"></p>
                            <input type="hidden" id="grandquantityvalue" name="grandquantityvalue">
                        </div>
                        <div>
                            <label class="control-label">Total</label>
                            <p id="grandtotal"></p>
                            <input type="hidden" id="grandtotalvalue" name="grandtotalvalue">
                        </div>
                    </div>
                </div>
                <!--Num tr value-->
                <input type="hidden" name="trCount" id="trCount" autocomplete="off" class="form-control" />
    
                <div class="form-group submitButtonFooter">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" id="createSale" data-loading-text="Cargando..." class="btn btn-success"><i
                                class="glyphicon glyphicon-ok-sign"></i>Registrar compra</button>   
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

    <!-- ---------------------------------------------------------------------------------- -->
        <!-- --------------------Modal-------------------- -->
            <!-- ---------------------------------------------------------------------------------- -->

            <div class="modal fade" tabindex="-1" role="dialog" id="setInfo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Actualizar información</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="quantity" class="col-sm-4 control-label">Cantidad comprada</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="quantity" placeholder="Enter..." autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="purchase" class="col-sm-4 control-label">Precio de compra</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="purchase" placeholder="Enter..." autocomplete="off" />
                                </div>
                            </div>
                            <button type="button" id="AddProduct" class="btn btn-primary"><i class="fa fa-save"></i>Agregar</button>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('custom_footer')
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    @include('purchases.script')
    <script>
        $(document).ready(function () {          
            $('#items').DataTable({
                "serverSide": true,
                "ajax": "{{ route('getList') }}",
                "columns": [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'quantity'
                    },
                    {
                        data: 'price1'
                    },
                    {
                        data: 'purchase'
                    },
                    {
                        data: 'action'
                    },
                ]
            });

                    //Initialize Select2 Elements
        $('.select2').select2()
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        });
    </script>
 <script>
    $('#createPurchaseForm').unbind('submit').bind('submit', function (stay) {
        stay.preventDefault();
        var formdata = $(this).serialize();
        var url = "{{ route('createPurchase') }}";
        $.ajax({
            type: 'POST',
            url: url,
            data: formdata,
            beforeSend: function () {
                //Loader
            },
            success: function (response) {
                console.log(response);
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                print(response.data);
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

    function print(data) {
        var invoice = data.invoice;
        var target = window.open('', 'PRINT', 'height=1000,width=1000');
        target.document.write(invoice);
        target.document.close();
        target.focus();
        target.onload = function () {
            target.print();
            target.close();
            //Clear all fields
            $('#createOrderForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
        };
    }
</script>
@endsection