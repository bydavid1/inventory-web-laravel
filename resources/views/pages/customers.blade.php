@extends('layouts.app')

{{-- page title --}}
@section('title','Clientes')

@section('vendor-styles')
	<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
@endsection

@section('tools')
	<button class="btn btn-success" data-toggle="modal" data-target="#addCostumer">
		<i class="bx bx-plus-circle fa-2x"></i>
		<span>Nuevo Cliente</span>
	</button>
@endsection

@section('content')
	<div class="card">
		<div class="card-body">
			<table class="table table-hover table-bordered" id="items">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Nombre</th>
						<th>NIT</th>
						<th>Telefono</th>
						<th>Email</th>
						<th>Dirección</th>
						<th>Fecha de registro</th>
						<th class="text-right">Opciones</th>
					</tr>
				</thead>
			</table>
		</div>
		<!-- /.card-body -->
	</div>



	<!-- Delete form-->
	<div class="d-none">
		<form id="destroyform" method="POST">
			@method('PUT')
		</form>
	</div>

<!-- Create modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="addCostumer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="bx bx-user"></i> Registrar nuevo cliente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
				<form id="createForm" method="POST">
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bx bxs-bulb"></i>
                            <span>
                                <strong>Tip:</strong> Click en <span class="bx bx-shuffle"></span> para generar un codigo aleatorio
                            </span>
                        </div>
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
									<span class="input-group-text"><i class="bx bx-key"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="Ej: C123" name="code" id="code"
								autocomplete="off">
								<div class="input-group-append">
									<button type="button" class="btn btn-light-secondary"><i class="bx bx-shuffle"></i></button>
								</div>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="name" class="control-label">Telefono: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="bx bx-phone"></i></span>
								</div>
								<input type="tel" class="form-control" placeholder="Ej: 7548-5689" name="phone" id="phone"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">Nombre: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="bx bx-user"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="Nombre" name="name" id="name"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">NIT: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="bx bx-id-card"></i></span>
								</div>
								<input type="tel" class="form-control" placeholder="Ej: 45654-54555-555-5" name="nit" id="nit"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">Email: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="bx bx-envelope"></i></span>
								</div>
								<input type="email" class="form-control" placeholder="Ej: user@domain.com" name="email" id="email"
								autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="name" class="control-label">Direccion: </label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="bx bx-building"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="Ej: Santa Monica" name="address" id="address"
								autocomplete="off">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
						autocomplete="off"> <i class="bx bx-save"></i> Guardar</button>
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
				<h4 class="modal-title"><i class="bx bx-user"></i> Editar informacion del cliente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="editform" method="POST">
					@method('PUT')
					<div class="alert alert-danger alert-icon-left d-none" role="alert" id="puterror">
						Hay datos importantes que faltan
					</div>
					<hr>
					<input type="hidden" id="put_id">
                    <div class="form-group">
                        <label for="name" class="control-label">Email: </label>
                        <div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="bx bx-envelope"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Email" name="uemail" id="uemail"
                                autocomplete="off">
                        </div>
					</div>
					<div class="form-group">
                        <label for="name" class="control-label">Telefono: </label>
                        <div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="bx bx-phone"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Telefono" name="uphone" id="uphone"
                                autocomplete="off">
                        </div>
					</div>
					<div class="form-group">
                        <label for="name" class="control-label">Dirección: </label>
                        <div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="bx bx-building"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Dirección" name="uaddress" id="uaddress"
                                autocomplete="off">
                        </div>
                    </div>
					<button type="submit" class="btn btn-primary btn-block" id="editCostumer"> <i
							class="bx bx-edit"></i> Actualizar</button>
				</form>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('vendor-scripts')
	<script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
	<script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/vfs_fonts.js')}}"></script>
@endsection

@section('page-scripts')
    @routes
	<script src="{{ asset('js/scripts/customers/customers.js') }}"></script>
@endsection
