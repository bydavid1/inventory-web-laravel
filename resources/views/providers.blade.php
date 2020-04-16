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

<!-- /.col -->
<div class="col-md-12">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Proveedores</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="text-right" style="margin-bottom: 15px"> 
			<a type="button" class="btn btn-success" href="{{ route('addProvider') }}"> <i class="fas fa-plus"></i> Agregar proveedores </a>
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