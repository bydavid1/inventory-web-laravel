@extends('layouts.app')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
	  <style>
		.tab-pills {
			 border-top: 1px solid #dfdfdf;
			 border-bottom: 1px solid #dfdfdf;
		 }

		 .tab-pills .tab-link.active,
		 .show>.tab-pills .tab-link {
			 border-bottom: 3px solid #25b9d7;
			 border-bottom: .1875rem solid #25b9d7;
		 }

		 .tab-pills .tab-link.active,
		 .tab-pills .show>.tab-link {
			 color: #363a41;
			 background-color: #f4f9fb;
		 }

		 .page-head-tabs .tab {
			 position: relative;
		 }

		 .tab-link {
			 color: #6c868e;
		 }

		 .tab-link {
			 display: block;
			 padding: 15px 20px;
			 padding: .9375rem 1.25rem;
		 }

		 a {
			 color: #25b9d7;
			 text-decoration: none;
			 background-color: transparent;
			 -webkit-text-decoration-skip: objects;
		 }
   </style>
@endsection

@section('content')
<div class="content-header bg-white mb-4 pt-2 pb-0">
    <div class="container-fluid">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Compras</li>
            </ol>
        </nav>
        <div class="row h-100">
            <div class="col-sm-6 my-auto">
                <h1 class="text-dark">Ventas y facturas</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="float-right">
                    <button class="btn btn-app bg-lightblue" data-toggle="modal" data-target="#addProviderModal">
                        <i class="fas fa-plus-circle"></i>
                        Factura
					</button>
					<button class="btn btn-app bg-lightblue" data-toggle="modal" data-target="#addProviderModal">
                        <i class="fas fa-plus-circle"></i>
                        Factura de credito fiscal
                    </button>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="page-head-tabs" id="head_tabs">
            <ul class="nav tab-pills">
                <li class="tab-item">
                    <a href="{{ route('suppliers') }}" id="subtab-AdminManufacturers" class="tab-link tab active current" data-submenu="17">
                        Todas las facturas
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /.col -->
<div class="col-md-12">
	<div class="card card-info card-outline">
		<!-- /.card-header -->
		<div class="card-body">
			<div class="text-right" style="margin-bottom: 15px"> 
			<a type="button" class="btn btn-success" href="{{ route('addProduct') }}"> <i class="fas fa-plus"></i> Crear nueva venta </a>
			</div>
			<table class="table table-condensed table-hover" id="items">
					<thead>
						<tr>				
                            <th>Fecha de factura</th>
							<th>Cliente</th>							
							<th>Cantidad de productos</th>
							<th>Valor</th>
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
	<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
	<script>
		$(document).ready(function () {
			$('#items').DataTable({
				"serverSide": true,
				"ajax": "{{ url('api/sales') }}",
				"columns": [
					{
						data: 'created_at'
					},
					{
						data: 'costumer'
					},
					{
						data: 'quantity'
					},
					{
						data: 'total'
					},
					{
						data: 'actions'
					}
				]
			})
		})
	</script>
	@if (session('alert'))
	<script>
		Swal.fire({
			type: 'error',
			title: 'Oops...',
			text: '{{ session("alert") }}',
			footer: '<a href>¿Quiere regenerarla con los datos guardados?</a>',
		   });
	</script>
	@endif
@endsection
