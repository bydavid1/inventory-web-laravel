@extends('layouts.app')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
@endsection

@section('tools')
    <button class="btn app-btn-primary" data-toggle="modal" data-target="#addCategoryModal">
        <span>Agregar Categoría</span>
    </button>
@endsection

@section('content')
    <div class="container">
        @if ( session('mensaje') )
        <div class="alert alert-success">{{ session('mensaje') }}</div>
        @endif
    </div>


@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
@endsection

@section('page-scripts')
    @routes
    <script src="{{ asset('js/scripts/categories/categories.js') }}"></script>
@endsection
