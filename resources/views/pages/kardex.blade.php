@extends('layouts.app')

{{-- page title --}}
@section('title','Kardex')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="app-content content">
    <div class="content-header bg-white">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Kardex</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Kardex
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="content-body">
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
	        "ajax": "{{ url('api/products/kardex') }}",
	        "columns": [
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

<script>
$(document).on('click','#removeProductModalBtn',function(){
    var id=$(this).attr('data-id');
    $('#id_product').val(id); 
    $('#removeProductModal').modal('show'); 
});
</script>

@endsection