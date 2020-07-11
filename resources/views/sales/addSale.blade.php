@extends('layouts.app')

@section('custom_header')
	  <!-- DataTables -->
	  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')

<div class=" mx-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear nueva factura</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Ventas</a></li>
                        <li class="breadcrumb-item active">Agregar venta</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if ( session('mensaje') )
    <div class="alert alert-success col-lg-8 mx-auto">{{ session('mensaje') }}</div>
    @endif
    <form class="form-horizontal" id="createOrderForm">
        @csrf
        <div class="row">
            <div class="col-sm-8">
                <!--/Card-->
                <div class="card card-primary ">
                    <!--/Header-->
                    <div class="card-header">
                        <i class='glyphicon glyphicon-circle-arrow-right'></i> Agregar venta
                    </div>
                    <!--/Body-->
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                    <label for="clientName" class="control-label">Nombre del cliente</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Cliente"
                                            autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="clientName" class="control-label">Fecha</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Fecha"
                                            autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>

                         @include('product-order.table')
                         <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Descuento</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="discount" id="discount" placeholder="Desc.." autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Cobros adcionales</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="mpayments" id="mpayments" placeholder="Adicional.." autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-sm-8 control-label">Terminos o comentarios</label>
                                    <textarea class="form-control" placeholder="Comentarios adicionales" name="comments"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--Num tr value-->
                        <input type="hidden" name="trCount" id="trCount" autocomplete="off" class="form-control" />

                        <div class="form-group row mt-5">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn"
                                data-loading-text="cargando..."> <i class="fa fa-plus-circle"></i> Añadir fila
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#SearchProducts"><i class="fa fa-search"></i>Agregar
                                    existentes</button>
                            </div>
                            <div class="col-sm-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- card-->
                <div class="card card-outline card-danger">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h4 class="mb-3">Resumen</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Cantidad total
                                <strong id="grandquantity">0</strong>
                                <input type="hidden" id="grandquantityvalue" name="grandquantityvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Sub total
                                <strong id="subtotal">$0.00</strong>
                                <input type="hidden" id="subtotalvalue" name="subtotalvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Descuentos
                                <strong id="discounts">$0.00</strong>
                                <input type="hidden" id="discountsvalue" name="discountsvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Impuestos
                                <strong id="tax">$0.00</strong>
                                <input type="hidden" id="taxvalue" name="taxesvalue">
                            </li>
                            <li class="list-group-item d-none justify-content-between align-items-center" id="grandinterest">
                                Interés
                                <strong id="interest">$0.00</strong>
                                <input type="hidden" id="interestvalue" name="interestvalue">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total
                                <strong id="grandtotal">$0.00</strong>
                                <input type="hidden" id="grandtotalvalue" name="grandtotalvalue">
                            </li>
                        </ul>
                        <button type="submit" id="createSale" data-loading-text="Cargando..."
                            class="btn btn-success btn-block mt-2">Registrar factura</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </form>
</div>

@include('product-order.modal')

@endsection

@section('custom_footer')
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    
    @include('product-order.script')

    <script>
        $('#createOrderForm').unbind('submit').bind('submit', function (stay) {
            stay.preventDefault();
            if(validate() == 0){
                var formdata = $(this).serialize();
                var url = "{{ route('save') }}";
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formdata,
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Registrando',
                            html: 'Por favor espere...',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        //Clear all fields
                        $('#createOrderForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
                        print(response.data);
                    },
                    error: function (xhr, textStatus, errorMessage) {
                        Swal.fire({
                            position: 'top',
                            type: 'error',
                            html: 'Error crítico: ' + xhr.responseText,
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });

        function validate(){
            let handler = 0
            //reset all fields messages

            const fields = document.getElementsByClassName('invoice-control-invalid')
            const invalidfields = document.getElementsByClassName('is-invalid')
            const messages = document.getElementsByClassName('error')
            const fieldslength = fields.length
            const messageslength = messages.length
            if (fieldslength > 0) {
                for (let x = 0; x < fieldslength; x++) {
                    fields[0].classList.remove('invoice-control-invalid') 
                }
            }

            if (messageslength > 0) {
                for (let x = 0; x < messageslength; x++) {
                    messages[0].parentNode.removeChild(messages[x]);
                    invalidfields[0].classList.remove('is-invalid')  
                }
            }

            //error message
            const spanerror = document.createElement('span')
            spanerror.classList.add('error', 'invalid-feedback')
            spanerror.textContent = 'No puede quedar vacío'

            const nameInput = document.getElementById('name') //input name

            if(!nameInput.value){
                nameInput.after(spanerror)
                nameInput.classList.add('is-invalid')
                handler++
            }

            //table fields
            const tableLenght = document.getElementById('trCount').value

            for (let i = 0; i < tableLenght; i++) {
                

                if (document.getElementById('pnamevalue' + i).value != '') {

                    let quantity = document.getElementById('quantity' + i)
                    let code = document.getElementById('pcode' + i)
                    let price = document.getElementById('price' + i)
                    
                    if (!document.getElementById('quantityvalue' + i).value) {
                        quantity.parentNode.classList.add('invoice-control-invalid')
                        handler++
                    }

                    if (!document.getElementById('pcodevalue' + i).value) {
                        code.parentNode.classList.add('invoice-control-invalid')
                        handler++
                    }


                    if (!document.getElementById('pricevalue' + i).value) {
                        price.parentNode.classList.add('invoice-control-invalid')
                        handler++
                    }
                }
            }

            return handler;
        }


        function print(data) {
            var invoice = data.invoice;
            var target = window.open('', 'PRINT', 'height=800,width=800');
            target.document.write(invoice);
            target.print();
            target.close();
        }
    </script>

@endsection