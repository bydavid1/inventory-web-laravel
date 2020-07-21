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
                        <form action="{{ route('makeCostumer') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Codigo: </label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" placeholder="Nombre" name="code"
                                        autocomplete="off" value="{{ old('code') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Nombre: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Nombre" name="name"
                                        autocomplete="off" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">NIT: </label>
                                <div class="col-sm-12">
                                    <input type="tel" class="form-control" placeholder="Nombre" name="nit"
                                        autocomplete="off" value="{{ old('nit') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Telefono: </label>
                                <div class="col-sm-12">
                                    <input type="tel" class="form-control" placeholder="Nombre" name="phone"
                                        autocomplete="off" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Email: </label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" placeholder="Nombre" name="email"
                                        autocomplete="off" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Direccion: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Nombre" name="address"
                                        autocomplete="off" value="{{ old('address') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" data-loading-text="Loading..."
                            autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection