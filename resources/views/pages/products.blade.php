@extends('layouts.app')

{{-- page title --}}
@section('title','Inventario')

@section('vendor-styles')
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/datatables/css/datatables.min.css')}}">
=======
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/toastr/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}"
>>>>>>> database
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
<<<<<<< HEAD
        <table class="table table-condensed table-hover table-bordered table-striped" id="items">
=======
        <table class="table table-hover table-bordered" id="items">
>>>>>>> database
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Codigo</th>
                    <th>Nombre del producto</th>
                    <th>Precios</th>
                    <th>Cantidad</th>
                    <th>Categoria</th>
<<<<<<< HEAD
                    <th>Fabricante</th>
                    <th>Estado</th>
=======
                    <th>Marca</th>
                    <th>Disponible</th>
>>>>>>> database
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<<<<<<< HEAD


<!-------------------------------------Remove Product ------------------------------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="bx bx-cube"></i> Eliminar producto</h4>
=======
<!------------------------------------- Update prices modal ------------------------------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="editPricesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title"><i class="bx bx-cube"></i> Editar precios</h4>
>>>>>>> database
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
<<<<<<< HEAD
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
=======
            <form id="pricesForm">
                <div class="modal-body" method="POST">
					@method('PUT')
                    <div id="pricesFormInputs">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
>>>>>>> database
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<<<<<<< HEAD
@endsection

@section('vendor-scripts')
    <script src="{{asset('js/libs/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/vfs_fonts.js')}}"></script>
=======

<!-- Delete form-->
<div class="d-none">
	<form id="destroyform" method="POST">
		@method('DELETE')
        @csrf
	</form>
</div>
@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('vendors/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
>>>>>>> database
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            $('#items').DataTable({
<<<<<<< HEAD
                "serverSide": true,
                "ajax": "{{ url('api/products') }}",
                "columns": [
                    {
                        data: 'photo'
=======
                serverSide: true,
                ajax: "{{ url('api/products') }}",
                processing: true,
                dom: "Bfrtip",
                buttons: [
                    { extend: "pdfHtml5", exportOptions: { columns: [0, ":visible"] } },
                    { extend: "print", exportOptions: { columns: [0, ":visible"] } },
                ],
                columns: [
                    {
                        data: 'photo',
                        searchable: false,
                        orderable: false
>>>>>>> database
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'name'
                    },
                    {
<<<<<<< HEAD
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
=======
                        data: 'prices',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'stock',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'category',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'brand',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'is_available',
                        searchable: false
                    },
                    {
                        data: 'actions',
                        searchable : false,
                        orderable: false
>>>>>>> database
                    },
                ]
            })
        });
    </script>

    <script>
<<<<<<< HEAD
        $(document).on('click','#removeProductModalBtn',function(){
            var id=$(this).attr('data-id');
            $('#identifier').val(id);
            $('#removeProductModal').modal('show');
        });
=======
        function getPrices(id) {
            let url = `{{ route('api:prices', ':id') }}`
            $.ajax({
                url: url.replace(':id', id),
                beforeSend: function () {
                    console.log('Obteniendo...')
                },
                success: function (response) {
                    let html = `<div class="row">`;

                    response.forEach((item, index) => {
                        html += `<div class="col-sm-4 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                </div>
                                <input type="number" step=".01" min="0" value="${item.price}"
                                    class="form-control" placeholder="Precio ${index}"
                                    id="price${item.id}" name="prices[${item.id}][price]"
                                    autocomplete="ggg-ss"/>
                            </div>
                        </div>`;

                        html += `<div class="col-sm-4 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bx bx-transfer"></i></span>
                                </div>
                                <input type="number" step=".01" min="0" value="${item.utility}"
                                    class="form-control" placeholder="Utilidad ${index}"
                                    id="utility${item.id}" name="prices[${item.id}][utility]"
                                    autocomplete="ggg-ss"/>
                            </div>
                        </div>`

                        html += `<div class="col-sm-4 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class='bx bxs-offer'></i></span>
                                </div>
                                <input type="number" step=".01" min="0" value="${item.price_w_tax}"
                                    class="form-control" placeholder="Precio con impuesto"
                                    autocomplete="ggg-ss" disabled/>
                            </div>
                        </div>`
                    });

                    html += `<input type="hidden" value="${id}" id="product_id" name="product_id"></div>`

                    $('#pricesFormInputs').html(html);
                },
                error: function (xhr, textStatus, errorMessage) {
                    console.log(xhr.responseJSON.message)
                }
            });

            $('#editPricesModal').modal('show');
        }

        document.getElementById('pricesForm').addEventListener('submit', function(e) {

            e.preventDefault();
            let formdata = $(this).serialize();
            let url = `{{ route('api:updatePrices', ':id') }}`;

            $.ajax({
                type: 'POST',
                url: url.replace(':id', document.getElementById('product_id').value),
                data: formdata,
                beforeSend: function () {
                    console.log('Actualizando')
                },
                success: function (response) {
                    toastr.success('Precios actualizados', 'Hecho!');
                    $('#editPricesModal').modal('hide');
                },
                error: function (xhr, textStatus, errorMessage) {
                    toastr.error(xhr.responseText, 'Error');
                }
            });
        })

    //----------------------------------------------------------------------
    //-------------------------Delete product ---------------------------------
    //----------------------------------------------------------------------


    function remove(id){
        let url = `{{ route('deleteProduct', ':id') }}`;

        Swal.fire({
            title: '¿Está seguro de eliminar este producto?',
            text: "Se moverá a la papelera",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Borrar'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url.replace(':id', id),
                    type: 'POST',
                    data: $('#destroyform').serialize(),
                    success: function (response) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Eliminado',
                            timer: 1500
                        });

                        table.ajax.reload();
                    },
                    error: function (xhr, textStatus, errorMessage) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            html: xhr.responseText,
                            showConfirmButton: true,
                        });
                    }
                })
            }
        })
    }

>>>>>>> database
    </script>
@endsection
