@extends('layouts.app')
@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Proveedores</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Proveedores</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">
	@if ( session('mensaje') )
    <div class="alert alert-success">{{ session('mensaje') }}</div>
     @endif
</div>

<!-- /.col -->
<div class="col-md-12">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Proveedores</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="text-right" style="margin-bottom: 15px"> 
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProviderModal"> <i class="fas fa-plus"></i> Agregar proveedores </button>
			</div>
			<table class="table" id="items">
					<thead>
						<tr>
							<!-- <th style="width:10%;">Imagen</th>	-->						
							<th>Codigo</th>
                            <th>Nombre</th>	
                            <th>NIT</th>		
                            <th>Telefono</th>
                            <th>Direccion</th>							
							<th style="width:15%;" class="text-right">Opciones</th>
						</tr>
					</thead>
				</table>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addProviderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar un nuevo proveedor</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('makeProvider') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Codigo: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="code"
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
                            <input type="text" class="form-control" placeholder="Nombre" name="nit"
                                autocomplete="off" value="{{ old('nit') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Contacto: </label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" placeholder="Telefono" name="phone"
                                autocomplete="off" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Direccion: </label>
                        <div class="col-sm-12">
                            <input type="tel" class="form-control" placeholder="Direccion" name="address"
                                autocomplete="off" value="{{ old('address') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" data-loading-text="Loading..."
                    autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
                </form>
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
<script>
	$(document).ready(function () {
	    $('#items').DataTable({
	        "serverSide": true,
	        "ajax": "{{ url('api/providers') }}",
	        "columns": [
			    {
	                data: 'id'
	            },
	            {
	                data: 'name'
	            },
	            {
	                data: 'nit'
	            },
                {
                    data: 'phone'
                },
                {
                    data: 'address'
                },
                {
                    data: 'actions'
                }
	        ]
	    })
	})
</script>
@endsection