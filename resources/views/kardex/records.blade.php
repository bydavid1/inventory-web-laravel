@extends('layouts.app')

@section('custom_header')
<!-- DataTables -->
<link rel="stylesheet"
    href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
<div class="mx-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Registros y estadisticas</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Kardex</a></li>
                        <li class="breadcrumb-item active">Registros</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        <div class="row mt-5">
            <div class="col-lg-2">
                <img src="{{ asset($product->image) }}" alt="Product image"
                    style="max-width: 60%; max-height: 60%;">

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
                                <i class="far fa-calendar-alt"></i>
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
    <!-- /.content-header -->

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Registros</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="items">
                <caption>Registros</caption>
                <thead class=" table-info">
                    <tr>
                        <th>Fecha</th>
                        <th>Detalle</th>
                        <th>Simbol</th>
                        <th>Cantidad</th>
                        <th>Diferencia</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Estadisticas</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Online Store Overview</h3>
                      <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-tool">
                          <i class="fas fa-download"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-tool">
                          <i class="fas fa-bars"></i>
                        </a>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                        <p class="text-success text-xl">
                          <i class="ion ion-ios-refresh-empty"></i>
                        </p>
                        <p class="d-flex flex-column text-right">
                          <span class="font-weight-bold">
                            <i class="ion ion-android-arrow-up text-success"></i> 12%
                          </span>
                          <span class="text-muted">CONVERSION RATE</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                      <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                        <p class="text-warning text-xl">
                          <i class="ion ion-ios-cart-outline"></i>
                        </p>
                        <p class="d-flex flex-column text-right">
                          <span class="font-weight-bold">
                            <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                          </span>
                          <span class="text-muted">SALES RATE</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                      <div class="d-flex justify-content-between align-items-center mb-0">
                        <p class="text-danger text-xl">
                          <i class="ion ion-ios-people-outline"></i>
                        </p>
                        <p class="d-flex flex-column text-right">
                          <span class="font-weight-bold">
                            <i class="ion ion-android-arrow-down text-danger"></i> 1%
                          </span>
                          <span class="text-muted">REGISTRATION RATE</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
                    </div>
                  </div>
                </div>
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
<!-- Moment JS -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<!-- Input mask -->
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#items').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('get_records', $id) }}",
            "columns": [{
                    data: 'created_at'
                },
                {
                    data: 'tag'
                },
                {
                    data: 'tag_code'
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'value_diff'
                },
                {
                    data: 'unit_price'
                },
                {
                    data: 'total'
                },
            ]
        });
    });

    //Date range picker
    $('#range').daterangepicker()
</script>
@endsection