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
                                <li class="breadcrumb-item active">Fabricantes
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="float-right">
                        <button class="btn btn-float btn-outline-primary" data-toggle="modal"
                            data-target="#addManufacturer">
                            <i class="fa fa-plus-circle fa-2x"></i>
                            <span>Agregar Fabricante</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 mt-1">
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
                <table class="table table-condensed table-hover table-bordered table-striped" id="items">
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
</div>

<!-- Delete form-->
<div class="d-none">
	<form id="destroyform" method="POST">
		@method('PUT')
		@csrf
	</form>
</div>

<!-- Create Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addManufacturer">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createform" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Registrar fabricante o marca</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-icon-left d-none" role="alert" id="posterror">
                        <!-- Custom Message -->
                    </div>
                    <hr>
                    <div class="form-group">
                        <label >Escojer un logo</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/png, image/jpeg, image/jpg" name="imagepath">
                            <label class="custom-file-label">Buscar</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nombre: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="name" id="name"
                                autocomplete="off">
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

<!-- Modal Edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="editManufacturerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editform" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Editar Fabricante o marca</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-icon-left d-none" role="alert" id="puterror">
						<!-- Custom Message -->
                    </div>
                    <hr>
                    <input type="hidden" id="put_id">
                    <div class="row">
                        <div class="form-group col-6">
                            <label >Escojer un logo nuevo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" disabled id="ulogo" name="ulogo" accept="image/png, image/jpeg, image/jpg">
                                <label class="custom-file-label">Escoger logo</label>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <img class="img-border height-100" alt="Card image" id="previewlogo">
                        </div>
                        <div class="form-group col-12">
                            <label for="name" class="control-label">Nombre: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nombre" name="uname" id="uname"
                                    autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="brandid" id="brandid">
                <div class="modal-footer">
                    <button type="submit" id="editManufacturer" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off" disabled>
                        <i class="fa fa-edit"></i> Actualizar</button>
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
<script src="{{ asset('js/scripts/manufacturers/manufacturers.js') }}"></script>
@endsection