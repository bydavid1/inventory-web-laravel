@extends('layouts.app')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
@endsection

@section('tools')
    <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
        <i class="fa fa-plus-circle fa-2x"></i>
        <span>Agregar Categoría</span>
    </button>
@endsection

@section('content')
    <div class="container">
        @if ( session('mensaje') )
        <div class="alert alert-success">{{ session('mensaje') }}</div>
        @endif
    </div>

    <div class="card card-info mt-2">
        <!-- /.card-header -->
        <div class="card-body">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="home-tab-center" href="{{ route('suppliers') }}"
                        aria-controls="home-center" role="tab" aria-selected="true">
                        Proveedores
                    </a>
                </li>
                <li class="nav-item current">
                    <a class="nav-link active" id="service-tab-center" href="{{ route('categories') }}"
                        aria-controls="service-center" role="tab" aria-selected="false">
                        Categorías
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="account-tab-center" href="{{ route('brands') }}"
                        aria-controls="account-center" role="tab" aria-selected="false">
                        Fabricantes
                    </a>
                </li>
            </ul>
            <table class="table table-condensed table-hover table-bordered table-striped" id="items">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th style="width:15%;" class="text-right">Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.card -->


<!-- Delete form-->
<div class="d-none">
	<form id="destroyform" method="POST">
		@method('DELETE')
	</form>
</div>

<!-- Create Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="bx bx-boxes"></i> Agregar nueva categoría</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="createForm" method="POST">
                    <div class="alert alert-danger alert-icon-left d-none" role="alert" id="posterror">
						Hay datos importantes que hacen falta
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="name" class="control-label">Nombre de la categoría: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
								<span class="input-group-text"><i class="bx bx-file"></i></span>
							</div>
                            <input type="text" class="form-control" placeholder="Nombre" id="name" name="name"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Descripcion: </label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Ingrese una descripcion"></textarea>
                    </div>
                    <div class="alert bg-rgba-primary alert-dismissible mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-info-circle"></i>
                            <span>
                                La descripcion es opcional, ideal si tiene conectado su propio sitio web para mostrarle al cliente mas informacion.
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..." autocomplete="off"> <i
                            class="bx bx-save"></i> Guardar</button>
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
				<h4 class="modal-title"><i class="bx bx-edit"></i> Editar categoria</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="editform" method="POST">
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
								<span class="input-group-text"><i class="bx bx-file"></i></span>
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
                            class="bx bx-edit"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
@endsection

@section('page-scripts')
    @routes
    <script src="{{ asset('js/scripts/categories/categories.js') }}"></script>
@endsection
