@extends('layouts.app')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="app-content content">
	<div class="content-header bg-white pb-0">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Crear nueva factura</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="index.html">Ventas</a>
                                </li>
                                <li class="breadcrumb-item active">Nueva venta simple
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="float-right">
						<button class="btn btn-float btn-outline-secondary" onclick="addRow()" id="addRowBtn">
							<i class="fa fa-plus-circle fa-2x"></i>
							<span>Añadir fila</span>
						</button>
						<button class="btn btn-float btn-outline-primary" data-toggle="modal" data-target="#SearchProducts">
							<i class="fa fa-search fa-2x"></i>
							<span>Buscar producto</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="content-wrapper">
            <form class="form-horizontal" id="createOrderForm">
                @csrf
                <div class="row">
                    <div class="col-sm-8">
                        <!--/Card-->
                        <div class="card card-primary ">
                            <!--/Header-->
                            <div class="card-header">
                                <h3 class="card-title">Informacion</h3>
                            </div>
                            <!--/Body-->
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                            <label for="clientName" class="control-label">Nombre del cliente</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Cliente"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="clientName" class="control-label">Fecha</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Fecha"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                 @include('product-order.table')
                                 <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name" class="control-label">Descuento</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" name="discount" id="discount" placeholder="Desc.." autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name" class="control-label">Cobros adcionales</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" name="mpayments" id="mpayments" placeholder="Adicional.." autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-sm-8 control-label">Terminos o comentarios</label>
                                            <textarea class="form-control" placeholder="Comentarios adicionales" name="comments"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--Num tr value-->
                                <input type="hidden" name="trCount" id="trCount" autocomplete="off" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <!-- card-->
                        <div class="card card-outline card-danger">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <h4 class="mb-3 card-title">Resumen</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Cantidad total
                                        <strong id="grandquantity">0</strong>
                                        <input type="hidden" id="grandquantityvalue" name="grandquantityvalue">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Sub total
                                        <strong id="subtotal">$0.00</strong>
                                        <input type="hidden" id="subtotalvalue" name="subtotalvalue">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Descuentos
                                        <strong id="discounts">$0.00</strong>
                                        <input type="hidden" id="discountsvalue" name="discountsvalue">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Impuestos
                                        <strong id="tax">$0.00</strong>
                                        <input type="hidden" id="taxvalue" name="taxesvalue">
                                    </li>
                                    <li class="list-group-item d-none justify-content-between align-items-center" id="grandinterest">
                                        Interés
                                        <strong id="interest">$0.00</strong>
                                        <input type="hidden" id="interestvalue" name="interestvalue">
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
    </div>
</div>  

<!-- Search product modal form -->
@include('product-order.modal')

@endsection

@section('custom_footer')
    <!-- SweetAlert -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Essential functions -->
    <script src="{{ asset('js/scripts/product/product-order.js') }}"></script>

    <!-- Modal script -->
    <script src="{{ asset('js/scripts/product/modal.js') }}"></script>

@endsection