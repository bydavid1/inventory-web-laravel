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
				<h1 class="m-0 text-dark">Productos</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Productos</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- /.col -->
<div class="col-md-12">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Inventario</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="text-right" style="margin-bottom: 15px"> 
			<a type="button" class="btn btn-success" href="{{ route('addProduct') }}"> <i class="fas fa-plus"></i> Agregar producto </a>
			</div>
			<table class="table" id="items">
					<thead>
						<tr>
							<th style="width:10%;">Imagen</th>						
							<th>Codigo</th>
							<th>Nombre del producto</th>							
							<th>Precio principal</th>
							<th>Cantidad</th>
							<th>Estado</th>
							<th>Tipo</th>
							<th>Proveedor</th>
							<th>Categoria</th>
							<th style="width:15%;" class="text-right">Opciones</th>
						</tr>
					</thead>
				</table>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>

<!-------------------------------------Remove Product ------------------------------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Eliminar producto</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('deleteProduct')}}" method="POST">
					@method('delete')
					@csrf
					<p id="message">¿Realmente deseas eliminar el producto? Se movera a la palera</p>
					<input type="hidden" id="id_product">
				<div class="modal-footer removeProductFooter">
					<button type="button" class="btn btn-default" data-dismiss="modal"> <i
							class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
					<button type="submit" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i
							class="glyphicon glyphicon-ok-sign"></i> Eliminar</button>
				</div>
				</form>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
	        "ajax": "{{ url('api/products') }}",
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
	                data: 'price1'
	            },
	            {
	                data: 'quantity'
	            },
	            {
	                data: 'is_available'
	            },
	            {
	                data: 'type'
	            },
	            {
					"searchable" : false,
	                data: 'name_prov'
	            },
	            {
					"searchable" : false,
	                data: 'name_categ'
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