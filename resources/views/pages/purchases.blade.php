@extends('layouts.app')

{{-- page title --}}
@section('title','Compras')


@section('vendor-styles')
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/datatables/css/datatables.min.css')}}">
=======
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
>>>>>>> database
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
<<<<<<< HEAD
		<table class="table table-condensed table-hover table-bordered table-striped" id="items">
=======
		<table class="table table-hover table-bordered" id="items">
>>>>>>> database
				<thead>
					<tr>
						<th>Fecha de factura</th>
						<th>Proveedor</th>
						<th>Cantidad de productos</th>
						<th>Sub total</th>
						<th>Total</th>
<<<<<<< HEAD
						<th style="width:15%;">Opciones</th>
=======
						<th class="text-right">Opciones</th>
>>>>>>> database
					</tr>
				</thead>
			</table>
	</div>
	<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection

@section('vendor-scripts')
<<<<<<< HEAD
    <script src="{{asset('js/libs/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/vfs_fonts.js')}}"></script>
=======
    <script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/vfs_fonts.js')}}"></script>
>>>>>>> database
@endsection

@section('page-scripts')
	<script>
		$(document).ready(function () {
			$('#items').DataTable({
				serverSide: true,
				ajax: {
                    url : "{{ url('api/purchases') }}",
                },
				columns: [
					{
						data: 'created_at'
					},
					{
						data: 'name'
					},
					{
<<<<<<< HEAD
						data: 'total_quantity'
=======
						data: 'quantity'
>>>>>>> database
					},
					{
						data: 'subtotal'
					},
					{
						data: 'total'
					},
					{
						data: 'actions',
                        orderable: false,
                        searchable: false
					}
				]
			})
		})
	</script>
@endsection
