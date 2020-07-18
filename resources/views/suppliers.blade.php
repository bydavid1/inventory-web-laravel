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
<div class="app-content content">
    <div class="content-header bg-white mb-3 pb-0">
        <div class=" content-wrapper pb-0">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Propiedades del inventario</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Poveedores
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="float-right">
                        <button class="btn btn-float btn-outline-primary" data-toggle="modal"
                            data-target="#addProviderModal">
                            <i class="fa fa-plus-circle fa-2x"></i>
                            <span>Agregar Proveedor</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 mt-1">
                    <div class="page-head-tabs" id="head_tabs">
                        <ul class="nav tab-pills">
                            <li class="tab-item">
                                <a href="{{ route('suppliers') }}" id="subtab-AdminManufacturers" class="tab-link tab active current" data-submenu="17">
                                    Proveedores
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manufacturers') }}" id="subtab-AdminSuppliers" class="tab-link tab" data-submenu="18">
                                    Fabricantes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories') }}" id="subtab-AdminSuppliers" class="tab-link tab"
                                    data-submenu="18">
                                    Categorias
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-lightblue">
            <div class="card-header">
                <h3 class="card-title my-auto">Proveedores</h3>
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
	                data: 'address'
	            },
	            {
	                data: 'actions'
	            }
	        ]
	    });

        $('#form').unbind('submit').bind('submit', function (stay) {
            stay.preventDefault();
            var formdata = $(this).serialize();
            var url = "{{ route('storeSupplier') }}";

            sendData(url, formdata, $(this), table);

        })
    }) //Ready Document

    function sendData(url, formdata, form, table) {
        $.ajax({
            type: 'POST',
            url: url,
            data: formdata,
            beforeSend: function () {
                Swal.fire({
                    title: 'Guardando',
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
</script>
@endsection