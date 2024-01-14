<div class="btn-group dropdown">
    <a role="button" href="{{ route("editProduct", $id) }}" class="btn btn-info btn-sm">Editar</a>
    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split"
        id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        data-reference="parent">
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
        <button class="dropdown-item" onclick="getPrices({{ $id }})">Editar precios</button>
        <button class="dropdown-item" onclick="remove({{ $id }})">Eliminar</button>
        <a class="dropdown-item" href="{{ route("showProduct", "$id") }}">Ver producto</a>
    </div>
</div>
