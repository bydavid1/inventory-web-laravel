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
				<h1 class="m-0 text-dark">Kardex</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Kardex</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">
<!-- /.col -->
<div class="col-md-12">
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