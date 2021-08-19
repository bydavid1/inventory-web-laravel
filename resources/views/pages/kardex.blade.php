@extends('layouts.app')

{{-- page title --}}
@section('title','Kardex')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
@endsection

@section('content')
<div class="card">
    <div class="card-content">
        <div class="card-header">
            <h4 class="card-title">Seleccione un producto para ver sus registros</h4>
        </div>
        <div class="card-body">
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
    </div>
</div>
@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
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
