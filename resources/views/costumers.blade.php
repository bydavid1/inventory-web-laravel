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
				<h1 class="m-0 text-dark">Clientes</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Clientes</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@if ( session('mensaje') )
<div class="alert alert-success col-lg-8 mx-auto">{{ session('mensaje') }}</div>
@endif
<!-- /.col -->
<div class="col-md-12">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Lista de clientes</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="text-right" style="margin-bottom: 15px"> 
			<a type="button" class="btn btn-success" href="{{ route('addCostumers') }}"> <i class="fas fa-plus"></i> Agregar un nuevo cliente </a>
			</div>
			<table class="table" id="items">
					<thead>
						<tr>					
							<th>Codigo</th>
							<th>Nombre</th>							
							<th>NIT</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Fecha de registro</th>
							<th style="width:15%;" class="text-right">Opciones</th>
						</tr>
					</thead>
				</table>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>

<!-- Delete modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCostumer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Eliminar cliente</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="destroyform">
					@method('delete')
					@csrf
					<p id="message">¿Realmente deseas eliminar el cliente? Se movera a la palera</p>
					<input type="hidden" id="id-item">
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

<!-- Edit modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="editCostumer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Editar información del cliente</h4>
            </div>
            <div class="modal-body">
                <form id="editform" action="" method="POST">
					@method('PUT')
					@csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Email: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Email" name="email" id="email"
                                autocomplete="off" value="{{ old('email') }}">
                        </div>
					</div>
					<div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Telefono: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Telefono" name="phone" id="phone"
                                autocomplete="off" value="{{ old('phone') }}">
                        </div>
					</div>
					<div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Dirección: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Dirección" name="address" id="address"
                                autocomplete="off" value="{{ old('address') }}">
                        </div>
                    </div>
				    <div class="modal-footer removeProductFooter">
					<button type="button" class="btn btn-default" data-dismiss="modal"> <i
							class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
					<button type="submit" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i
							class="glyphicon glyphicon-ok-sign"></i> Editar</button>
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
	        "ajax": "{{ url('api/costumers') }}",
	        "columns": [
				{
	                data: 'code'
	            },
			    {
	                data: 'name'
	            },
                {
	                data: 'nit'
	            },
                {
	                data: 'phone'
	            },
	            {
	                data: 'email'
	            },
	            {
	                data: 'address'
	            },
                {
	                data: 'created_at'
	            },
                {
	                data: 'actions'
	            },
	        ]
	    })
	});
</script>

<script>
$(document).on('click','#editCostumerModalBtn',function(){

     //Get Id from data-id property
    var id = $(this).attr('data-id');
	var action = "{{ route('updateCostumer', ':id') }}";
	action = action.replace(":id", id);
	$("#editform").attr("action", action);

    var url = "{{ url('api/costumers', 'id') }}";
     url = url.replace("id", id);
	$.ajax({
		url: url,
		type: 'get',
		dataType: 'json',
		serverSide : true,
        success : function(response){
			var data = response.data;
		    	$('#email').val(data[0].email);
				$('#phone').val(data[0].phone);
				$('#address').val(data[0].address);
		}
	})
});

$(document).on('click', '#destroyCostumerModalBtn', function(){

   //Get Id from data-destroy-id property
    var id = $(this).attr('data-destroy-id');
	var action = "{{ route('deleteCostumer', ':id') }}";
	action = action.replace(":id", id);
	$("#destroyform").attr("action", action);
})
</script>

@endsection