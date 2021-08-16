@extends('layouts.app')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fileinput/fileinput.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/toastr/toastr.css')}}">
@endsection

@section('title', $product->name )

@section('tools')
<button type="button" class="btn btn-success" onclick="updateProduct()">
    <i class='bx bx-refresh'></i>
    Actualizar
</button>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form class="form-horizontal" id="submitProductForm" action="{{ route('updateProduct', $product->id) }}"
                enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="productImage" class="col-12 control-label">Imagen: </label>
                                <input type="file" class="form-control" id="image"
                                    placeholder="Imagen del producto" name="image" class="file-loading"
                                    style="width:auto;" />
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="codProduct" class="control-label">Codigo: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-key"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="code"
                                            placeholder="Codigo del producto" name="code"
                                            autocomplete="ggg-ss" value="{{ $product->code }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i
                                                    class="bx bx-shuffle"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label for="productName" class="control-label">Nombre: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-news"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nombre del producto" name="name"
                                            autocomplete="ggg-ss" value="{{ $product->name }}">
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label>Categoría:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                        </div>
                                        <select class="form-control select2" id="category_id" name="category_id">
                                            @foreach ($categories as $item)
                                            @if ($item->id == $product->category_id)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                (Seleccionado)</option>
                                            @endif
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="productStatus" class="control-label">Estado: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="bx bx-loader"></i></span>
                                        </div>
                                        <select class="form-control" id="is_available" name="is_available">
                                            @if ($product->is_available == 1)
                                                <option value="1" selected>Disponible (Seleccionado)</option>
                                            @endif
                                            @if ($product->is_available == 0)
                                                <option value="0" selected>No disponible (Seleccionado)</option>
                                            @endif
                                            <option value="1">Disponible</option>
                                            <option value="0">No disponible</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label>Fabricante:</label>
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="bx bxs-factory"></i></span>
                                        </div>
                                        <select class="form-control select2" id="manufacturer_id"
                                            name="manufacturer_id">
                                            @foreach ($brands as $item)
                                                @if ($item->id == $product->manufacturer_id)
                                                    <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                        (Seleccionado)</option>
                                                @endif
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bx bx-file"></i></span>
                                        </div>
                                        <textarea class="form-control" id="description" placeholder="Ingrese una descripción"
                                            name="description">
                                            {{ $product->description }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.form -->
    </div>
    <!-- /.card-body -->
</div>
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/fileinput/fileinput.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/toastr/toastr.min.js')}}"></script>
@endsection

@section('page-scripts')
@routes
<script src="{{ asset('js/scripts/product/editProduct.js') }}"></script>
<script>
    // Basic Select2 select
    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

    let previewImage = null;

    if (`{{ $product->photo != null }}`) {

        if (`{{ $product->photo->source == "photo_default.png" }}`) {
            previewImage = `{{ asset('assets/media/' . $product->photo->source)  }}`
        } else {
            previewImage = `{{ asset('storage/' . $product->photo->source) }}`
        }
    }

    console.log(previewImage)

    $("#image").fileinput({
        overwriteInitial: true,
        defaultPreviewContent: `<img src="${previewImage}" alt="placeholder" style="width:100%;">`,
        browseClass: "btn btn-success",
        allowedFileExtensions: ["jpg", "png"],
        showUpload: false,
        showCancel: false,
        browseIcon: '<i class="bx bx-folder-open"></i>',
        removeIcon: '<i class="bx bx-trash"></i>',
    })

</script>
@endsection

