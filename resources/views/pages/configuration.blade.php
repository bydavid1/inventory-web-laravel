@extends('layouts.app')

{{-- page title --}}
@section('title','Configuración')

@section('vendor-styles')
	<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
@endsection


@section('content')
<div class="container">
    <!-- account setting page start -->
    <section id="page-account-settings">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <!-- left menu section -->
                    <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center active" id="account-pill-general"
                                    data-toggle="pill" href="#account-vertical-company" aria-expanded="true">
                                    <i class='bx bxs-business'></i>
                                    <span>Perfil compañía</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" id="account-pill-password"
                                    data-toggle="pill" href="#account-vertical-design" aria-expanded="false">
                                    <i class='bx bxs-palette'></i>
                                    <span>Interfaz</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- right content section -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="account-vertical-company"
                                            aria-labelledby="account-pill-company" aria-expanded="true">
                                            @include('pages.configuration.company')
                                        </div>
                                        <div class="tab-pane fade " id="account-vertical-design" role="tabpanel"
                                            aria-labelledby="account-pill-design" aria-expanded="false">
                                            @include('pages.configuration.interface')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('vendor-scripts')
	<script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
@endsection

@section('page-scripts')
    @routes
@endsection
