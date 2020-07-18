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
<div class="app-content content">
	<div class="content-header bg-white pb-0">
        <div class=" content-wrapper pb-0">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Ventas y facturas</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Ventas
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="float-right">
						<a class="btn btn-float btn-outline-primary" href="{{ route('addSale') }}">
							<i class="fa fa-plus-circle fa-2x"></i>
							<span>Factura</span>
						</a>
						<a class="btn btn-float btn-outline-primary" href="{{ route('addCredit') }}">
							<i class="fa fa-plus-circle fa-2x"></i>
							<span>Factura de credito fiscal</span>
						</a>
                    </div>
                </div>
                <div class="col-12 mt-1">
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
        </div>
	</div>  
	<div class="content-body">
		<div class="content-wrapper">
			<div class="card card-info card-outline">
				<!-- /.card-header -->
				<div class="card-body">
					<table class="table table-condensed table-hover" id="items">
							<thead>
								<tr>				
									<th>Fecha</th>
									<th>Cliente</th>	
									<th>Tipo</th>						
									<th>Cantidad</th>
									<th>Subtotal</th>
									<th>Total</th>
									<th style="width:15%;" class="text-right">Opciones</th>
								</tr>
							</thead>
						</table>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
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
						data: 'name'
					},
					{
						data: 'invoice_type'
					},
					{
						data: 'total_quantity'
					},
					{
						data: 'subtotal'
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
