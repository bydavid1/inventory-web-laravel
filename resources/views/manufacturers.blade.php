@extends('layouts.app')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
      <style>
            .tab-pills {
                border-top: 1px solid #dfdfdf;
                border-bottom: 1px solid #dfdfdf;
            }

            .tab-pills .tab-link.active,
            .show>.tab-pills .tab-link {
                border-bottom: 3px solid #25b9d7;
                border-bottom: .1875rem solid #25b9d7;
            }

            .tab-pills .tab-link.active,
            .tab-pills .show>.tab-link {
                color: #363a41;
                background-color: #f4f9fb;
            }

            .page-head-tabs .tab {
                position: relative;
            }

            .tab-link {
                color: #6c868e;
            }

            .tab-link {
                display: block;
                padding: 15px 20px;
                padding: .9375rem 1.25rem;
            }

            a {
                color: #25b9d7;
                text-decoration: none;
                background-color: transparent;
                -webkit-text-decoration-skip: objects;
            }
      </style>
@endsection

@section('content')
<div class="content-header bg-white mb-4 pt-2 pb-0">
    <div class="container-fluid">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Fabricantes</li>
            </ol>
        </nav>
        <div class="row h-100">
            <div class="col-sm-6 my-auto">
                <h1 class="text-dark">Proveedores y Fabricantes</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="float-right">
                    <button class="btn btn-app bg-lightblue" data-toggle="modal" data-target="#addManufacturer">
                        <i class="fas fa-plus-circle"></i>
                        Agregar nuevo fabricante
                    </button>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="page-head-tabs" id="head_tabs">
            <ul class="nav tab-pills">
                <li class="tab-item">
                    <a href="{{ route('suppliers') }}" id="subtab-AdminManufacturers" class="tab-link tab " data-submenu="17">
                        Proveedores
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manufacturers') }}" id="subtab-AdminSuppliers" class="tab-link tab active current" data-submenu="18">
                        Fabricantes
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
	@if ( session('mensaje') )
    <div class="alert alert-success">{{ session('mensaje') }}</div>
     @endif
</div>

<!-- /.col -->
<div class="col-md-12">
	<div class="card">
		<div class="card-header bg-lightblue">
            <h3 class="card-title my-auto">Fabricantes o marcas</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<table class="table table-bordered table-condensed" id="items">
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

<div class="modal fade" tabindex="-1" role="dialog" id="addManufacturer">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" placeholder="Nombre" name="name"
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
            <form id="editform" enctype="multipart/form-data">
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Editar Fabricante o marca</h4>
                </div>
                <div class="modal-body">
                    <div class="spinner-grow text-primary d-none" id="edit2-loader" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="brandlogo">Escoger logo</label>
                        <input type="file" class="form-control" id="brandlogo" name="brandlogo" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nombre: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Nombre" name="brandname" id="brandname"
                                autocomplete="off" disabled required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="brandid" id="brandid">
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
    let brandid = document.querySelector('#brandid')

	$(document).ready(function () {
	    let table = $('#items').DataTable({
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
	    })

        $('#form').unbind('submit').bind('submit', function (stay) {
            stay.preventDefault()
            var formData = new FormData(this)
            var url = "{{ route('storeManufacturer') }}"

            sendData(url, formData, $(this), table)
        })

        $('#editform').unbind('submit').bind('submit', function (stay) {
            stay.preventDefault();
            var formData = new FormData(this)
            var url = "{{ route('editManufacturer', 'id') }}".replace('id', brandid.value)

            sendData(url, formData, $(this), table)

        })
    }) //Ready Document

    function sendData(url, formdata, form, table) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            type: 'POST',
            url: url,
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
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

    function editManufacturer(id) {
        $('#editManufacturerModal').modal('show')
        let url = "{{ url('api/manufacturers', 'id') }}"
        url = url.replace('id', id)
        let loader = document.querySelector('#edit2-loader')
        let brandname = document.querySelector('#brandname')

        $.ajax({
            type: 'GET',
            url: url,
            beforeSend: function () {
                loader.classList.remove('d-none')
                brandname.setAttribute('disabled', '')
                brandname.value = ""
            },
            success: function (response) {
                loader.classList.add('d-none')
                let data = response.data
                brandname.removeAttribute('disabled')
                brandname.value = data.name
                brandid.value = data.id
            },
            error: function (xhr, textStatus, errorMessage) {

            }
        });
    }
</script>
@endsection