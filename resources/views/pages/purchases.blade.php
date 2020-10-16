@extends('layouts.app')

{{-- page title --}}
@section('title','Compras')


@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('tools')
<a class="btn btn-float btn-primary" href="{{ route('addPurchase') }}">
	<i class="bx bx-plus-circle fa-2x"></i>
	<span>Nueva compra</span>
</a>
@endsection

@section('content')

<div class="card">
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
