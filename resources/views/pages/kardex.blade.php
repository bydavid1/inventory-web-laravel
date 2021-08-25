@extends('layouts.app')

{{-- page title --}}
@section('title','Kardex')

@section('vendor-styles')
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/datatables/css/datatables.min.css')}}">
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
=======
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
@endsection

@section('content')
<div class="card">
    <div class="card-content">
        <div class="card-header">
            <h4 class="card-title">Seleccione un producto para ver sus registros</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="items">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Codigo</th>
                        <th>Nombre del producto</th>
                        <th class="text-right">Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
>>>>>>> database
</div>
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
>>>>>>> database
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
