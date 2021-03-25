@extends('layouts.app')

{{-- page title --}}
@section('title','Ventas')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/sweetalert/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/datatables/css/datatables.min.css')}}">
@endsection

@section('tools')
<a class="btn btn-info" href="{{ route('addSale') }}">
	<i class="bx bx-plus-circle fa-2x"></i>
	<span>Nueva venta</span>
</a>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<table class="table table-condensed table-hover table-bordered table-striped" id="items">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Cliente</th>
						<th>Tipo</th>
						<th>Cantidad</th>
						<th>Subtotal</th>
						<th>Total</th>
						<th>Opciones</th>
					</tr>
				</thead>
			</table>
	</div>
	<!-- /.card-body -->
</div>
<!-- /.card -->

@endsection

@section('vendor-scripts')
    <script src="{{asset('js/libs/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/vfs_fonts.js')}}"></script>
@endsection

@section('page-scripts')
	<script>
		$(document).ready(function () {
			$('#items').DataTable({
				"serverSide": true,
				"ajax": "{{ url('api/sales') }}",
				"columns": [
					{
						data: 'created_at'
					},
					{
						data: 'name'
					},
					{
						data: 'invoice_type'
					},
					{
						data: 'total_quantity'
					},
					{
						data: 'subtotal'
					},
					{
						data: 'total'
					},
					{
						data: 'actions'
					}
				]
			})
		})
    </script>

	<script>
        function showInvoice (id) {
            let url = "{{ route('invoiceExist', ':id') }}".replace(":id", id)
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function () {
                    Swal.fire({
                        title: 'Obteniendo factura',
                        html: 'Por favor espere...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    })
                },
                success: function (response) {
                    Swal.close()
                    window.open("{{ route('showInvoice', ':id') }}".replace(":id", id))
                },
                error: function (xhr, textStatus, errorMessage) {
                    if (xhr.status === 404) {
                        Swal.fire({
                            icon: 'question',
                            html: `<h4>${xhr.responseJSON.message}</h4><p>¿Desea regenerar la factura con los datos guardados?</p>`,
                            showCancelButton: true,
                            confirmButtonText: '<i class="bx bx-wrench"></i> Reparar!',
                            cancelButtonText: 'Cancelar',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //code
                            }
                        })
                    } else if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            html: `<h4>${xhr.responseJSON.message}</h4>`,
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            html: `<h4>${xhr.status}</h4><p>${xhr.responseJSON.message}</p>`,
                        })
                    }
                }
            })
        }
	</script>

@endsection
