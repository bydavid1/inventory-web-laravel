@extends('layouts.app')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
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
                                <li class="breadcrumb-item active">Categorías
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="float-right">
                        <button class="btn btn-float btn-outline-primary" data-toggle="modal"
                            data-target="#addCategoryModal">
                            <i class="fa fa-plus-circle fa-2x"></i>
                            <span>Agregar Categoría</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 mt-1">
                    <div class="page-head-tabs" id="head_tabs">
                        <ul class="nav tab-pills">
                            <li class="tab-item">
                                <a href="{{ route('suppliers') }}" id="subtab-AdminManufacturers" class="tab-link tab" data-submenu="17">
                                    Proveedores
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manufacturers') }}" id="subtab-AdminSuppliers" class="tab-link tab" data-submenu="18">
                                    Fabricantes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories') }}" id="subtab-AdminSuppliers" class="tab-link tab active current"
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
    <!-- /.content-header -->
    <div class="container">
        @if ( session('mensaje') )
        <div class="alert alert-success">{{ session('mensaje') }}</div>
        @endif
    </div>
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Categorias</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-condensed table-hover table-bordered table-striped" id="items">
                    <thead>
                        <tr>
                            <!-- <th style="width:10%;">Imagen</th>	-->
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Status</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="addCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-boxes"></i> Agregar nueva categoría</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="createForm" method="POST">
                    @csrf
                    <div class="alert alert-danger alert-icon-left d-none" role="alert" id="posterror">
						Hay datos importantes que hacen falta
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="name" class="control-label">Nombre de la categoría: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-file"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Nombre" id="name" name="name"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Descripcion: </label>
                        <div class="input-group">
                            <textarea name="description" class="form-control" placeholder="Ingrese una descripcion" cols="30" rows="10">
                            </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..." autocomplete="off"> <i
                            class="fa fa-save"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-edit"></i> Editar categoria</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="editform" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="alert alert-danger alert-icon-left d-none" role="alert" id="puterror">
						Hay datos importantes que faltan
                    </div>
                    <hr>
                    <input type="hidden" id="put_id">
                    <div class="form-group">
                        <label for="name" class="control-label">Nombre de la categoría: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-file"></i></span>
							</div>
                            <input type="text" class="form-control" id="uname" name="uname" placeholder="Nombre"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Descripcion: </label>
                        <div class="input-group">
                            <textarea name="udescription" id="udescription" class="form-control" placeholder="Ingrese una descripcion" cols="30" rows="10">
                            </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" id="editCategory" data-loading-text="Loading..." autocomplete="off"><i
                            class="fa fa-edit"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/path.js') }}"></script>
    @routes
    <script src="{{ asset('js/scripts/categories/categories.js') }}"></script>
@endsection
