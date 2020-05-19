@extends('layouts.app')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Clientes</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Ventas</a></li>
                    <li class="breadcrumb-item active">Agregar venta</li>
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
<!--/Card-->
<div class="card card-primary ">
    <!--/Header-->
    <div class="card-header">
        <i class='glyphicon glyphicon-circle-arrow-right'></i> Agregar venta
    </div>
    <!--/Body-->
    <div class="card-body">
        <form class="form-horizontal" id="createOrderForm">
           @csrf
            <div class="row">
                <!--/form-group-->
                <div class="form-group col-lg-6">
                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                    <label for="clientName" class="col-sm-4 control-label">Nombre del cliente</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" placeholder="Cliente"
                            autocomplete="off" />
                    </div>
                </div>
                <!--/form-group-->
            </div>

            @include('product-order.table')
        
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <label for="vat" class="col-sm-3 control-label">Cantidad total</label>
                    <div class="col-sm-5 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" id="grandquantity" name="grandquantity"
                            disabled="true" />
                            <input type="hidden" id="grandquantityvalue" name="grandquantityvalue">
                    </div>
                </div>
                <!--/form-group-->
                <div class="input-group mb-5">
                    <label for="grandTotal" class="col-sm-3 control-label">Total</label>
                    <div class="col-sm-5 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" id="grandtotal" name="grandtotal" disabled="true" />
                        <input type="hidden" id="grandtotalvalue" name="grandtotalvalue">
                    </div>
                </div>
                <!--/form-group-->
            </div>
        
            <input type="hidden" name="trCount" id="trCount" autocomplete="off" class="form-control" />
        
        
            <div class="form-group submitButtonFooter">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" id="createSale" data-loading-text="Cargando..." class="btn btn-success"><i
                            class="glyphicon glyphicon-ok-sign"></i>Crear</button>
        
                    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn"
                        data-loading-text="cargando..."> <i class="glyphicon glyphicon-plus-sign"></i> Añadir fila
                    </button>
        
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#addProductsModal"><span class="glyphicon glyphicon-search"></span> Agregar
                        productos</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

          @include('product-order.modal')

@endsection

@section('custom_footer')
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#items').DataTable({
                "serverSide": true,
                "ajax": "{{ url('api/products/order') }}",
                "columns": [{
                        data: 'photo'
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'custom_quantity'
                    },
                    {
                        "searchable": false,
                        data: 'name_prov'
                    },
                    {
                        "searchable": false,
                        data: 'name_categ'
                    },
                    {
                        data: 'actions'
                    },
                ]
            })
        });
    </script>
    
    @include('product-order.script')

    <script>
        $('#createOrderForm').unbind('submit').bind('submit', function (stay) {
            stay.preventDefault();
            var formdata = $(this).serialize();
            var url = "{{ route('save') }}";
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