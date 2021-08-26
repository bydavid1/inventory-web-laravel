<div class="media">
    <a href="javascript: void(0);">
        <img src="{{asset('assets/media/ebox.png')}}"
            class="rounded mr-75" alt="profile image" height="100" width="100">
    </a>
    <div class="media-body mt-25">
        <div
            class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                <label for="select-files" class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">
                  <span>Buscar logo</span>
                  <input id="select-files" type="file" hidden>
                </label>
            <button class="btn btn-sm btn-light-secondary ml-50">Reset</button>
        </div>
        <p class="text-muted ml-1 mt-50"><small>Formatos permitidos: JPG or PNG. Tamaño máximo: 800kB</small></p>
    </div>
</div>
<hr>
<form novalidate>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <label>Nombre</label>
                    <input name="name" type="text" class="form-control"
                        placeholder="Ingrese el nombre de la empresa/negocio" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <label>Descripcion</label>
                    <textarea name="description" class="form-control" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <label>Direccion</label>
                    <input name="name" type="text" class="form-control"
                        placeholder="Ingrese la direccion de la empresa/negocio">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <label>Email</label>
                    <input name="name" type="text" class="form-control"
                        placeholder="Ingrese el email de contacto de la empresa/negocio">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <div class="controls">
                    <label>Contacto</label>
                    <input name="name" type="text" class="form-control"
                        placeholder="Ingrese un numero de contacto de la empresa/negocio">
                </div>
            </div>
        </div>
        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
            <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                changes</button>
            <button type="reset" class="btn btn-light mb-1">Cancel</button>
        </div>
    </div>
</form>
