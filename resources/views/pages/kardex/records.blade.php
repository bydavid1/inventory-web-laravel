@extends('layouts.app')

{{-- page title --}}
@section('title', $product->name)

@section('vendor-styles')
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="{{asset('js/libs/datatables/css/datatables.min.css')}}">
=======
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
>>>>>>> database
@endsection

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
<<<<<<< HEAD
                <img src="/{{ $product->first_image->src }}" alt="Product image"
=======
                <img src="/{{ $product->photo->source }}" alt="Product image"
>>>>>>> database
                    style="max-width: 80%; max-height: 80%;">
            </div>
            <div class="col-lg-4">
                <h5>Producto: {{ $product->name }}</h5>
                <h6>Codigo: {{ $product->code }} </h6>
            </div>
            <div class="col-lg-6">
                <!-- Date range -->
                <div class="form-group">
                    <label>Buscar registros entre:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="bx bx-calendar"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="range">
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group -->
            </div>
        </div>
    </div>

    <div class="card">
<<<<<<< HEAD
        <div class="card-header">
            <h3 class="card-title">Registros</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="items">
                <thead class="table-success">
=======
        <div class="card-body">
            <table class="table table-hover table-bordered" style="width: 100%" id="items">
                <thead>
>>>>>>> database
                  <tr>
                      <th colspan="3">Descripcion</th>
                      <th colspan="3">Entradas</th>
                      <th colspan="3">Salidas</th>
                      <th colspan="2">Existencias</th>
                  </tr>
                  <tr>
                      <th>Fecha</th>
                      <th>Detalle</th>
                      <th>Valor Uni.</th>
<<<<<<< HEAD
                      <th>Cantidad</th>
                      <th>Precio Unit.</th>
                      <th>Valor</th>
                      <th>Cantidad</th>
                      <th>Precio Unit.</th>
                      <th>Valor</th>
                      <th>Cantidad</th>
=======
                      <th>Cant.</th>
                      <th>Precio Unit.</th>
                      <th>Valor</th>
                      <th>Cant.</th>
                      <th>Precio Unit.</th>
                      <th>Valor</th>
                      <th>Cant.</th>
>>>>>>> database
                      <th>Valor</th>
                  </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection


@section('vendor-scripts')
<<<<<<< HEAD
    <script src="{{asset('js/libs/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/libs/datatables/js/vfs_fonts.js')}}"></script>
=======
    <script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/vfs_fonts.js')}}"></script>
>>>>>>> database
@endsection

@section('page-scripts')
<script>
    $(document).ready(function () {
        $('#items').DataTable({
            serverSide: true,
            ajax: {
<<<<<<< HEAD
                url : "/api/kardex/{{$id}}/records"
=======
                url : "{{route('getProductReport', $id)}}"
>>>>>>> database
            },
            columns: [
                {
                    data: 'created_at'
                },
                {
                    data: 'tag'
                },
                {
                    data: 'final_unit_value'
                },
                {
                    data: 'e_quantity'
                },
                {
<<<<<<< HEAD
                    data: 'e_price'
=======
                    data: 'e_unit_value'
>>>>>>> database
                },
                {
                    data: 'e_value'
                },
                {
                    data: 's_quantity'
                },
                {
<<<<<<< HEAD
                    data: 's_price'
=======
                    data: 's_unit_value'
>>>>>>> database
                },
                {
                    data: 's_value'
                },
                {
                    data: 'final_stock'
                },
                {
                    data: 'final_value'
                },
            ]
        });
    });

    //Date range picker
    $('#range').daterangepicker()
</script>
@endsection
