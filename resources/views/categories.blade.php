@extends('layouts.app')
@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Categorias</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Categorias</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
    @if ( session('mensaje') )
    <div class="alert alert-success">{{ session('mensaje') }}</div>
    @endif

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