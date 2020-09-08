@extends('layouts.app')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('content')
<div class="app-content content">
    <div class="content-header bg-white">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Compras</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Compras
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="float-right">
                        <a class="btn btn-float btn-primary" href="{{ route('addPurchase') }}">
                            <i class="fa fa-plus-circle fa-2x"></i>
                            <span>Nueva compra</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="content-body">
		<div class="content-wrapper">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Compras</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<table class="table table-condensed table-hover table-bordered table-striped" id="items">
							<thead>
								<tr>				
									<th>Fecha de factura</th>
									<th>Proveedor</th>							
									<th>Cantidad de productos</th>
									<th>Sub total</th>
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

@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
@endsection

@section('page-scripts')
	<script>
		$(document).ready(function () {
			$('#items').DataTable({
				"serverSide": true,
				"ajax": "{{ url('api/purchases') }}",
				"columns": [
					{
						data: 'created_at'
					},
					{
						data: 'name'
					},
					{
						data: 'quantity'
					},
					{
						data: 'sub_total'
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
