@extends('layouts.app')
@section('custom_header')
	<!-- Design -->
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
                                <a href="{{ route('suppliers') }}" id="subtab-AdminManufacturers"
                                    class="tab-link tab active current" data-submenu="17">
                                    Proveedores
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manufacturers') }}" id="subtab-AdminSuppliers" class="tab-link tab"
                                    data-submenu="18">
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

<!-- Delete form-->
<div class="d-none">
	<form id="destroyform" method="POST">
		@method('PUT')
		@csrf
	</form>
</div>


<!--Create Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addProviderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createForm">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Registrar nuevo proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-icon-left d-none" role="alert" id="posterror">
						Hay datos importantes que hacen falta
					</div>
					<hr>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="name" class="control-label">Codigo: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nombre" name="code" id="code" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="name" class="control-label">Contacto: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-address-book"></i></span>
                                </div>
                                <input type="number" class="form-control" placeholder="Telefono" name="phone" id="phone"
                                    autocomplete="off"">
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="name" class="control-label">Nombre: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-truck"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nombre" name="name" id="name" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="name" class="control-label">NIT: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nombre" name="nit" id="nit" autocomplete="off">
                            </div>
                        </div>
                        <div class=" form-group col-12">
                            <label for="name" class="control-label">Direccion: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-building"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Direccion" name="address" id="address"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off">
                        <i class="fa fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Edit Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editSupplierModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editform">
                @method('PUT')
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Registrar nuevo proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-icon-left d-none" role="alert" id="puterror">
						Hay datos importantes que faltan
                    </div>
                    <hr>
					<input type="hidden" id="put_id">
                    <div class="form-group col-12">
                        <label for="name" class="control-label">Contacto: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-address-book"></i></span>
                            </div>
                            <input type="number" class="form-control" placeholder="Telefono" name="uphone" id="uphone"
                                autocomplete="off"">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="name" class="control-label">Nombre: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-truck"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="uname" id="uname" autocomplete="off">
                        </div> 
                    </div>
                    <div class="form-group col-12">
                        <label for="name" class="control-label">NIT: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="unit" id="unit" autocomplete="off">
                        </div>
                    </div>
                    <div class=" form-group col-12">
                        <label for="name" class="control-label">Direccion: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Direccion" name="uaddress" id="uaddress"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editSupplier" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off">
                        <i class="fa fa-save"></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom_footer')
<!-- Design -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- CN module -->
<script src="{{ asset('js/path.js') }}"></script>
<!-- Essential functions -->
@routes
<script src="{{ asset('js/scripts/supplier/suppliers.js') }}"></script>
@endsection