@extends('layouts.app')

@section('custom_header')

@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Agregar cliente</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Clientes</li>
                    <li class="breadcrumb-item active">Agregar cliente</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="col-md-12">
    @if ( session('mensaje') )
    <div class="alert alert-success">{{ session('mensaje') }}</div>
     @endif
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
@endsection