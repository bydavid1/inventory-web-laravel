@extends('layouts.app')

{{-- page title --}}
@section('title','Inventario')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('tools')
<a class="btn btn-success" href="{{ route('addProduct') }}">
    <i class="bx bx-plus-circle fa-2x"></i>
    <span>Nuevo producto</span>
</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-condensed table-hover table-bordered table-striped" id="items">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Codigo</th>
                    <th>Nombre del producto</th>
                    <th>Precios</th>
                    <th>Cantidad</th>
                    <th>Categoria</th>
                    <th>Fabricante</th>
                    <th>Estado</th>
                    <th style="width:15%;" class="text-right">Opciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->



<!-------------------------------------Remove Product ------------------------------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="bx bx-cube"></i> Eliminar producto</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body">

                <form action="{{ route('deleteProduct') }}" method="POST">
					@method('PUT')
					@csrf
					<p id="message">¿Realmente deseas eliminar el producto? Se movera a la palera</p>
					<input type="hidden" name="identifier" id="identifier">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                                class="bx bx-times"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i
                                class="bx bx-trash"></i> Eliminar</button>
                    </div>
				</form>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            $('#items').DataTable({
                "serverSide": true,
                "ajax": "{{ url('api/products') }}",
                "columns": [
                    {
                        data: 'photo'
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'prices'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'name_category'
                    },
                    {
                        data: 'name_supplier'
                    },
                    {
                        data: 'is_available'
                    },
                    {
                        "searchable" : false,
                       data: 'actions'
                    },
                ]
            })
        });
    </script>
    
    <script>
        $(document).on('click','#removeProductModalBtn',function(){
            var id=$(this).attr('data-id');
            $('#identifier').val(id); 
            $('#removeProductModal').modal('show'); 
        });
    </script>
@endsection