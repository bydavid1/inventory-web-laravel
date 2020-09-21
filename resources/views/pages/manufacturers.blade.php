@extends('layouts.app')

{{-- page title --}}
@section('title','Fabricantes')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('tools')
    <button class="btn btn-float btn-outline-primary" data-toggle="modal" data-target="#addManufacturer">
        <i class="fa fa-plus-circle fa-2x"></i>
        <span>Agregar Fabricante</span>
    </button>
@endsection

@section('content')

    <div class="container">
        @if ( session('mensaje') )
        <div class="alert alert-success">{{ session('mensaje') }}</div>
         @endif
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="home-tab-center" href="{{ route('suppliers') }}"
                        aria-controls="home-center" role="tab" aria-selected="true">
                        Proveedores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="service-tab-center" href="{{ route('categories') }}"
                        aria-controls="service-center" role="tab" aria-selected="false">
                        Categorías
                    </a>
                </li>
                <li class="nav-item current">
                    <a class="nav-link active" id="account-tab-center" href="{{ route('manufacturers') }}"
                        aria-controls="account-center" role="tab" aria-selected="false">
                        Fabricantes
                    </a>
                </li>
            </ul>
            <table class="table table-condensed table-hover table-bordered table-striped" id="items">
                <thead>
                    <tr>					
                        <th>Logo</th>
                        <th>Nombre</th>	
                        <th>Disponible</th>									
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
<div class="modal fade" tabindex="-1" role="dialog" id="addManufacturer">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createform" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"><i class="bx bx-plus"></i> Registrar fabricante o marca</h4>
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
                                <span class="input-group-text"><i class="bx bx-key"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre" name="name" id="name"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                        autocomplete="off">
                        <i class="bx bx-save"></i> Guardar</button>
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
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
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
                        <i class="bx bx-edit"></i> Actualizar</button>
                </div>
            </form>
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
    <script src="{{ asset('js/scripts/manufacturers/manufacturers.js') }}"></script>
@endsection