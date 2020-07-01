@extends('layouts.app')
@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Proveedores y Fabricantes</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Proveedores</li>
				</ol>
			</div><!-- /.col -->
        </div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header 
<div style='background-color: #fff'>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a  class="nav-link" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home">Proveedores</a>
        </li>
        <li class="nav-item">
            <a  class="nav-link" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home">Fabricantes</a>
        </li>
    </ul>
</div>
-->
<div class="container">
	@if ( session('mensaje') )
    <div class="alert alert-success">{{ session('mensaje') }}</div>
     @endif
</div>

<!-- /.col -->
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
            <h3 class="card-title my-auto">Proveedores</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProviderModal"> <i class="fas fa-plus"></i>Agregar nuevo proveedor</button>
            </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<table class="table table-bordered table-condensed" id="items">
					<thead>
						<tr>
							<!-- <th style="width:10%;">Imagen</th>	-->						
							<th>Codigo</th>
                            <th>Nombre</th>	
                            <th>NIT</th>		
                            <th>Telefono</th>
                            <th>Direccion</th>							
							<th style="width:15%;" class="text-right">Opciones</th>
						</tr>
					</thead>
				</table>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>

<!-- /.col -->
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
            <h3 class="card-title my-auto">Fabricantes o marcas</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addManufacturer"> <i class="fas fa-plus"></i>Agregar nuevo Fabricante</button>
            </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<table class="table table-bordered table-condensed" id="items2">
					<thead>
						<tr>
							<!-- <th style="width:10%;">Imagen</th>	-->						
							<th>Logo</th>
                            <th>Nombre</th>	
                            <th>Disponible</th>									
							<th style="width:15%;" class="text-right">Opciones</th>
						</tr>
					</thead>
				</table>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addProviderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Agregar un nuevo proveedor</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Codigo: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="code" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="name" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">NIT: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="nit" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Contacto: </label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" placeholder="Telefono" name="phone"
                                autocomplete="off"">
                        </div>
                    </div>
                    <div class=" form-group">
                            <label for="name" class="col-sm-3 control-label">Direccion: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Direccion" name="address"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..." autocomplete="off">
                            <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addManufacturer">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form2" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Agregar Fabricante o marca</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imagepath" name="imagepath" accept="image/png, image/jpeg, image/jpg" name="imagepath">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="name2"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off">
                        <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="editManufacturerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editform2" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Editar Fabricante o marca</h4>
                </div>
                <div class="modal-body">
                    <div class="spinner-grow text-primary d-none" id="edit2-loader" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="brandimage" name="brandimage" accept="image/png, image/jpeg, image/jpg" name="imagepath">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="brandname" id="brandname"
                                autocomplete="off" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off">
                        <i class="glyphicon glyphicon-ok-sign"></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom_footer')
    <!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
	$(document).ready(function () {
	    let table = $('#items').DataTable({
	        serverSide: true,
	        ajax: "{{ url('api/suppliers') }}",
	        columns: [{
	                data: 'id'
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
	                data: 'address'
	            },
	            {
	                data: 'actions'
	            }
	        ]
	    });

	    let table2 = $('#items2').DataTable({
	        serverSide: true,
	        ajax: "{{ url('api/manufacturers') }}",
	        columns: [{
	                data: 'image'
	            },
	            {
	                data: 'name'
	            },
	            {
	                data: 'available'
	            },
	            {
	                data: 'actions'
	            }
	        ]
	    });

	    $('#form').unbind('submit').bind('submit', function (stay) {
	        stay.preventDefault();
	        var formdata = $(this).serialize();
	        var url = "{{ route('makesupplier') }}";

	        saveData(url, formdata, $(this), table);

	    });

	    $('#form2').unbind('submit').bind('submit', function (stay) {
	        stay.preventDefault();
	        var formdata = $(this).serialize();
	        var url = "{{ route('makemanufacturer') }}";

	        saveData(url, formdata, $(this), table2);
	    });
	});

	function saveData(url, formdata, form, table) {
	    $.ajax({
	        type: 'POST',
	        url: url,
	        data: formdata,
	        beforeSend: function () {
	            Swal.fire({
	                title: 'Registrando',
	                html: 'Por favor espere...',
	                allowOutsideClick: false,
	                onBeforeOpen: () => {
	                    Swal.showLoading()
	                },
	            })
	        },
	        success: function (response) {
	            Swal.fire({
	                position: 'top-end',
	                type: 'success',
	                title: 'Guardado',
	                showConfirmButton: false,
	                timer: 1500
	            });
	            //Clear all fields
	            $(form).closest('form').find("input[type=text], input[type=number], textarea").val("");
	            table.ajax.reload();
	        },
	        error: function (xhr, textStatus, errorMessage) {
	            Swal.fire({
	                position: 'top',
	                type: 'error',
	                html: 'Error crítico: ' + xhr.responseText,
	                showConfirmButton: true,
	            });
	        }
	    });
	}

    function editManufacturer(id){
        $('#editManufacturerModal').modal('show')
        let url = "{{ url('api/manufacturers', 'id') }}"
        url = url.replace('id', id)
        let loader = document.getElementById('edit2-loader')
        let brandimage = document.getElementById('brandimage')
        let brandname = document.getElementById('brandname')
        $.ajax({
	        type: 'GET',
	        url: url,
	        beforeSend: function () {
                loader.classList.remove('d-none')
                brandname.setAttribute('disabled', '')
                brandname.value = ""
                brandimage.setAttribute('disabled', '')
	        },
	        success: function (response) {
                loader.classList.add('d-none')
                let data = response.data
                brandname.removeAttribute('disabled')
                brandimage.removeAttribute('disabled')
                brandname.value = data.name
	        },
	        error: function (xhr, textStatus, errorMessage) {

	        }
	    });
    }
</script>
@endsection