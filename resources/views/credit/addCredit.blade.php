@extends('layouts.app')

@section('custom_header')
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

<div class="app-content content">
	<div class="content-header bg-white pb-0">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Factura credito fiscal</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="index.html">Ventas</a>
                                </li>
                                <li class="breadcrumb-item active">Nueva venta de credito fical
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
            <form class="form-horizontal" id="createForm" autocomplete="off"> 
                @csrf
                <div class="row">
                    <div class="col-sm-8">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Información</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <label for="costumer" class="control-label">Vendido a:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                                            </div>
                                            <input type="hidden" id="costumerid" name="costumerid"/>
                                            <input type="text" class="form-control" placeholder="Buscar" id="costumer"
                                                 name="costumer" aria-label="Enter..." aria-describedby="button-add" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" id="button-add" data-toggle="modal"
                                                data-target="#addCostumer"><i
                                                        class="fa fa-plus mr-1"></i>Nuevo cliente</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="payment" class="control-label">Estado de pago</label>
                                        <div> 
                                            <select class="form-control" placeholder="Fecha" id="payment" name="payment" onchange="moptions()">
                                                <option value="1">Completo</option>
                                                <option value="2">Crédito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="date" class="control-label">Fecha de factura</label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" class="form-control datefield" placeholder="Fecha"
                                                autocomplete="off" id="date" name="date"  />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                 @include('product-order.table')
        
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="form-group col-md-12">
                                            <label for="delivery" class="control-label">Estado de entrega</label>
                                            <div class="col-md-12">
                                                <select class="form-control" placeholder="Fecha" id="delivery" name="delivery">
                                                    <option value="1">Completo</option>
                                                    <option value="2">Parcial</option>
                                                    <option value="0">Pendiente</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="control-label">Descuento</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" name="discount" id="discount" placeholder="Desc.." autocomplete="off" />
                                        </div>
                                        <label for="name" class="mt-2 control-label">Cobros adcionales</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" name="mpayments" id="mpayments" placeholder="Adicional.." autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="col-sm-8 control-label">Terminos o comentarios</label>
                                        <textarea class="form-control" placeholder="Comentarios adicionales" name="comments"></textarea>
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
                                        Impuestos
                                        <strong id="tax">$0.00</strong>
                                        <input type="hidden" id="taxvalue" name="taxesvalue">
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
                        <!-- card-->
                        <div class="card card-outline card-danger d-none" id="creditinfo">
                            <div class="card-body">
                                <h5 class="mb-3">Información del crédito</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="delivery" class="control-label">Numero de cuotas</label>
                                            <input type="number" name="numfees" id="numfees" class="form-control"/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="delivery" class="control-label">Fecha de inicio</label>
                                            <input type="text" name="startdate" class="form-control datefield"/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="delivery" class="control-label">Rango entre cuotas</label>
                                            <select name="rangefees" id="rangefees" class="form-control">
                                                <option value="1D">1 día</option>
                                                <option value="1D">10 día</option>
                                                <option value="15D" selected>15 días</option>
                                                <option value="1M">1 mes</option>
                                                <option value="2M">2 mes</option>
                                                <option value="6M">6M</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="delivery" class="control-label">Porcentaje de interés</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            </div>
                                            <input type="decimal" name="interestper" id="interestper" class="form-control" max="100" min="0" value="3.0"/>
                                        </div>
                                    </div>
                                </div>
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

<!-- ---------------------------------------------------------------------------------- -->
<!-- --------------------Modal-------------------- -->
<!-- ---------------------------------------------------------------------------------- -->

<div class="modal fade right" tabindex="-1" role="dialog" id="addCostumer">
    <div class="modal-dialog modal-full-height modal-right">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear Nuevo cliente</h4>
                <button class="close ml-2" data-dismiss="modal" arial-label="close"><span
                    aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fa fa-user fa-4x text-primary fa-rotate-right mb-1"></i>
                </div>
                <form action="{{ route('makeCostumer') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Codigo: </label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" placeholder="Nombre" name="code"
                                autocomplete="off" value="{{ old('code') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="name"
                                autocomplete="off" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">NIT: </label>
                        <div class="col-sm-12">
                            <input type="tel" class="form-control" placeholder="Nombre" name="nit"
                                autocomplete="off" value="{{ old('nit') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Telefono: </label>
                        <div class="col-sm-12">
                            <input type="tel" class="form-control" placeholder="Nombre" name="phone"
                                autocomplete="off" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Email: </label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" placeholder="Nombre" name="email"
                                autocomplete="off" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Direccion: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="address"
                                autocomplete="off" value="{{ old('address') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off"> <i class="fas fa-check-circle"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Search product modal form -->
@include('product-order.modal')


@endsection

@section('custom_footer')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    
    <!-- Essential functions -->
    <script src="{{ asset('js/scripts/product/product-order.js') }}"></script>

    <!-- Modal script -->
    <script src="{{ asset('js/scripts/product/modal.js') }}"></script>

@endsection