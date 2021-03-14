@extends('layouts.app')

{{-- page title --}}
@section('title','Inventario')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/datatables/css/datatables.min.css')}}">
@endsection

@section('tools')
<a class="btn app-btn-primary" href="{{ route('addProduct') }}">
    <span>Nuevo producto</span>
</a>
@endsection

@section('content')


@endsection

@section('vendor-scripts')
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
    <script>
        $(document).ready(function () {
            $('#items').DataTable({
                "serverSide": true,
                "ajax": "{{ url('api/products') }}",
                "columns": [
                    {
                        data: 'photo'
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'prices'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'name_category'
                    },
                    {
                        data: 'name_supplier'
                    },
                    {
                        data: 'is_available'
                    },
                    {
                        "searchable" : false,
                       data: 'actions'
                    },
                ]
            })
        });
    </script>

    <script>
        $(document).on('click','#removeProductModalBtn',function(){
            var id=$(this).attr('data-id');
            $('#identifier').val(id);
            $('#removeProductModal').modal('show');
        });
    </script>
@endsection
