@extends('layouts.app')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')

<div class=" mx-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear nueva factura</h1>
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
    <form class="form-horizontal" id="createOrderForm">
        @csrf
        <div class="row">
            <div class="col-sm-8">
                <!--/Card-->
                <div class="card card-primary ">
                    <!--/Header-->
                    <div class="card-header">
                        <i class='glyphicon glyphicon-circle-arrow-right'></i> Agregar venta
                    </div>
                    <!--/Body-->
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                    <label for="clientName" class="col-sm-4 control-label">Nombre del cliente</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" placeholder="Cliente"
                                            autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="clientName" class="col-sm-4 control-label">Fecha</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Fecha"
                                            autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>

                         @include('product-order.table')

                        <div class="row mt-2">
                            <div class="col-sm-6"></div>
                            <div class="col-md-6">
                                <textarea class="form-control" placeholder="Comentarios adicionales"></textarea>
                            </div>
                        </div>
                        <!--Num tr value-->
                        <input type="hidden" name="trCount" id="trCount" autocomplete="off" class="form-control" />

                        <div class="form-group row mt-5">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn"
                                data-loading-text="cargando..."> <i class="fa fa-plus-circle"></i> Añadir fila
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#SearchProducts"><i class="fa fa-search"></i>Agregar
                                    existentes</button>
                            </div>
                            <div class="col-sm-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- card-->
                <div class="card card-outline card-danger">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h4 class="mb-3">Resumen</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Cantidad total
                                <strong id="grandquantity">0</strong>
                                <input type="hidden" id="grandquantityvalue" name="grandquantityvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Sub total
                                <strong id="">$0.00</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total
                                <strong id="grandtotal">$0.00</strong>
                                <input type="hidden" id="grandtotalvalue" name="grandtotalvalue">
                            </li>
                        </ul>
                        <button type="submit" id="createSale" data-loading-text="Cargando..."
                            class="btn btn-success btn-block mt-2">Registrar factura</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </form>
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
                    //Clear all fields
                    $('#createOrderForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
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
            var target = window.open('', 'PRINT', 'height=800,width=800');
            target.document.write(invoice);
            target.print();
            target.close();
        }
    </script>

@endsection