@extends('layouts.app')

{{-- page title --}}
@section('title', $product->name)

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <img src="/{{ $product->first_image->src }}" alt="Product image"
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
        <div class="card-header">
            <h3 class="card-title">Registros</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="items">
                <thead class="table-success">
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
                      <th>Cantidad</th>
                      <th>Precio Unit.</th>
                      <th>Valor</th>
                      <th>Cantidad</th>
                      <th>Precio Unit.</th>
                      <th>Valor</th>
                      <th>Cantidad</th>
                      <th>Valor</th>
                  </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
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
            serverSide: true,
            ajax: {
                url : "/api/kardex/{{$id}}/records"
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
                    data: 'e_price'
                },
                {
                    data: 'e_value'
                },
                {
                    data: 's_quantity'
                },
                {
                    data: 's_price'
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
