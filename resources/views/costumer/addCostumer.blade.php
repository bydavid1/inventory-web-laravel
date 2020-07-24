@extends('layouts.app')

@section('custom_header')

@endsection

@section('content')
<div class="app-content content">
    <div class="content-header bg-white">
        <div class="container py-2">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 h-100 my-auto">
                    <h3 class="content-header-title mb-0">Agregar cliente</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item">Clientes
                                </li>
                                <li class="breadcrumb-item active">Agregar cliente
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        @if ( session('mensaje') )
            <div class="alert alert-success">{{ session('mensaje') }}</div>
        @endif
        <div class="container mt-3">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Agregar </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-sm-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection