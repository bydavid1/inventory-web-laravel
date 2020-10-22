@extends('layouts.app')

{{-- page title --}}
@section('title','Kardex')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
    <h4 class="mb-3">Seleccione un producto para ver sus registros</h4>
    <table class="table" id="items">
        <thead>
            <tr>
                <th style="width:10%;">Imagen</th>
                <th>Codigo</th>
                <th>Nombre del producto</th>
                <th style="width:15%;" class="text-right">Opciones</th>
            </tr>
        </thead>
    </table>
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
	        serverSide: true,
	        ajax: "/api/kardex/products",
	        columns: [
				{
	                data: 'photo'
	            },
			    {
	                data: 'code'
	            },
	            {
	                data: 'name'
	            },
	            {
					"searchable" : false,
	               data: 'actions'
	            },
	        ]
	    })
	});
</script>
@endsection
