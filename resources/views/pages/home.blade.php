@extends('layouts.app')

{{-- page title --}}
@section('title','Inicio')

@section('content')
<div id="app">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="row">
                    <!-- Order Summary Starts -->
                    <div class="col-md-8 col-12 order-summary border-right pr-md-0">
                        <div class="card mb-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Ultimos 7 dias</h4>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-sm btn-primary glow mr-1">Semanal</button>
                                    <button type="button" disabled class="btn btn-sm btn-light-primary">Mensual</button>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body p-0">
                                    <apexchart width="100%" type="area" :options="options" :series="series"></apexchart>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sales History Starts -->
                    <div class="col-md-4 col-12 pl-md-0">
                        <div class="card mb-0">
                            <div class="card-header pb-50">
                                <h4 class="card-title">Sales History</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="sales-item-name">
                                            <p class="mb-0">Airpods</p>
                                            <small class="text-muted">30 min ago</small>
                                        </div>
                                        <div class="sales-item-amount">
                                            <h6 class="mb-0"><span class="text-success">+</span> $50</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="sales-item-name">
                                            <p class="mb-0">iPhone</p>
                                            <small class="text-muted">2 hour ago</small>
                                        </div>
                                        <div class="sales-item-amount">
                                            <h6 class="mb-0"><span class="text-danger">-</span> $59</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="sales-item-name">
                                            <p class="mb-0">Macbook</p>
                                            <small class="text-muted">1 day ago</small>
                                        </div>
                                        <div class="sales-item-amount">
                                            <h6 class="mb-0"><span class="text-success">+</span> $12</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top pb-0">
                                    <h5>Total Sales</h5>
                                    <span class="text-primary text-bold-500">$82,950.96</span>
                                    <div class="progress progress-bar-primary progress-sm my-50">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="78" style="width:78%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row  ">
                <!-- Statistics Cards Starts -->
                    <div class="col-sm-6 col-12 dashboard-users-success">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body py-1">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                        <i class="bx bx-briefcase-alt font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">Productos</div>
                                    <h3 class="mb-0" v-html="products"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 dashboard-users-danger">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body py-1">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                        <i class="bx bx-user font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">Clientes</div>
                                    <h3 class="mb-0" v-html="customers"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Revenue Growth Chart Starts -->
              </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
@endsection

@section('page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-apexcharts"></script>
    <script type="module" src="{{ asset('js/scripts/dashboard/script.js') }}"></script>
@endsection
