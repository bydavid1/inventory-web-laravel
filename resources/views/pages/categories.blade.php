@extends('layouts.app')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
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
                    <a class="nav-link" id="account-tab-center" href="{{ route('manufacturers') }}"
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
		@method('PUT')
		@csrf
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
                    @csrf
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
                        <label for="name" class="control-label">Descripcion: </label>
                        <div class="input-group">
                            <textarea name="description" class="form-control" placeholder="Ingrese una descripcion" cols="30" rows="10">
                            </textarea>
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
    <script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/path.js') }}"></script>
    @routes
    <script src="{{ asset('js/scripts/categories/categories.js') }}"></script>
@endsection
