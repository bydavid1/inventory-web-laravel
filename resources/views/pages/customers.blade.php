@extends('layouts.app')

{{-- page title --}}
@section('title','Clientes')

@section('vendor-styles')
	<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
@endsection

@section('tools')
	<button class="btn app-btn-primary" data-toggle="modal" data-target="#addCostumer">
		<span>Nuevo Cliente</span>
	</button>
@endsection

@section('content')


@endsection

@section('vendor-scripts')
	<script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
	<script src="{{asset('vendors/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/datatables/js/vfs_fonts.js')}}"></script>
@endsection

@section('page-scripts')
    @routes
	<script src="{{ asset('js/scripts/customers/customers.js') }}"></script>
@endsection
