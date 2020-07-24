@extends('layouts.app')

@section('custom_header')
	<!-- Design -->
	<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="app-content content">
    <div class="content-header bg-white">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">CLientes</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Clientes
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="float-right">
                        <button class="btn btn-float btn-outline-success" data-toggle="modal" data-target="#addCostumer">
                            <i class="fa fa-plus-circle fa-2x"></i>
                            <span>Nuevo Cliente</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
	</div>
	@if ( session('mensaje') )
		<div class="alert alert-success col-lg-8 mx-auto">{{ session('mensaje') }}</div>
	@endif
    <div class="content-body">
        <div class="content-wrapper">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Lista de clientes</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
						<table class="table" id="items">
							<thead>
								<tr>					
									<th>Codigo</th>
									<th>Nombre</th>							
									<th>NIT</th>
									<th>Telefono</th>
									<th>Email</th>
									<th>Dirección</th>
									<th>Fecha de registro</th>
									<th style="width:15%;" class="text-right">Opciones</th>
								</tr>
							</thead>
						</table>
				</div>
				<!-- /.card-body -->
			</div>
        </div>
    </div>
</div>


<!-- Delete modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCostumer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-trash"></i> Eliminar cliente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="destroyform">
					@method('delete')
					@csrf
					<p id="message">¿Realmente deseas eliminar el cliente? Se movera a la palera</p>
					<input type="hidden" id="id-item">
				<div class="modal-footer removeProductFooter">
					<button type="button" class="btn btn-default" data-dismiss="modal"> <i
							class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
					<button type="submit" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i
							class="glyphicon glyphicon-ok-sign"></i> Eliminar</button>
				</div>
				</form>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Edit modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="addCostumer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-user"></i> Registrar nuevo cliente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
				<form id="createForm" method="POST" action="{{ route('makeCostumer') }}">
					@csrf
					<div class="alert alert-info alert-icon-left" role="alert">
						<strong>Tip:</strong> Click en <span class="fa fa-random"></span> para generar un codigo aleatorio
					</div>
					<div class="alert alert-danger alert-icon-left d-none" role="alert" id="posterror">
						Hay datos importantes que hacen falta
					</div>
					<hr>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="name" class="control-label">Codigo: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-key"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="Ej: C123" name="code" id="code"
								autocomplete="off">
								<div class="input-group-append">
									<button type="button" class="btn btn-outline-secondary"><i class="fa fa-random"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="name" class="control-label">Telefono: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-phone"></i></span>
								</div>
								<input type="tel" class="form-control" placeholder="Ej: 7548-5689" name="phone" id="phone"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">Nombre: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-user"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="Nombre" name="name" id="name"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">NIT: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-id-card"></i></span>
								</div>
								<input type="tel" class="form-control" placeholder="Ej: 45654-54555-555-5" name="nit" id="nit"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">Email: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-envelope"></i></span>
								</div>
								<input type="email" class="form-control" placeholder="Ej: 7548-5689" name="email" id="email"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">Direccion: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-building"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="Ej: Santa Monica" name="address" id="address"
								autocomplete="off">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
						autocomplete="off"> <i class="fa fa-save"></i> Guardar</button>
				</form>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Edit modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="editCostumer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-user"></i> Editar informacion del cliente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="editform" action="" method="POST">
					@method('PUT')
					@csrf
					<div class="alert alert-danger alert-icon-left d-none" role="alert" id="puterror">
						Al parecer el cliente ya no está disponible
					</div>
					<hr>
                    <div class="form-group">
                        <label for="name" class="control-label">Email: </label>
                        <div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-envelope"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Email" name="email" id="uemail"
                                autocomplete="off">
                        </div>
					</div>
					<div class="form-group">
                        <label for="name" class="control-label">Telefono: </label>
                        <div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-phone"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Telefono" name="phone" id="uphone"
                                autocomplete="off">
                        </div>
					</div>
					<div class="form-group">
                        <label for="name" class="control-label">Dirección: </label>
                        <div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-building"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Dirección" name="address" id="uaddress"
                                autocomplete="off">
                        </div>
                    </div>
					<button type="submit" class="btn btn-primary btn-block" id="editCostumer"> <i
							class="fa fa-edit"></i> Actualizar</button>
				</form>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('custom_footer')
<!-- Design -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- CN module -->
<script src="{{ asset('js/path.js') }}"></script>
<!-- Essential functions -->
<script src="{{ asset('js/scripts/customer/customer.js') }}"></script>

@endsection