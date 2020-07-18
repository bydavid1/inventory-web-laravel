@extends('layouts.app')
@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
                <div class="text-right" style="margin-bottom: 15px">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCategoryModal">
                        <i class="fas fa-plus"></i> Agregar categoria </button>
                </div>
                <table class="table" id="items">
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

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar una nueva categoría</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('makeCategory') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nombre de la categoría: </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" placeholder="Nombre" name="name"
                                autocomplete="off" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Descripcion: </label>
                        <div class="col-sm-12">
                            <textarea name="description" class="form-control" placeholder="Ingrese una descripcion" value="{{ old('description') }}" cols="30" rows="10">
                            </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off"> <i
                            class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
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
	        "ajax": "{{ url('api/categories') }}",
	        "columns": [
			    {
	                data: 'id'
	            },
	            {
	                data: 'name'
	            },
	            {
	                data: 'is_available'
	            },
                {
                    data: 'actions'
                }
	        ]
	    })
	})
</script>
@endsection