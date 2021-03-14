<template>
  <fragment>
    <div class="card">
      <!-- /.card-header -->
      <div class="card-body">
        <ul class="nav nav-tabs justify-content-center" role="tablist">
          <li class="nav-item current">
            <a class="nav-link active" id="home-tab-center" href="#" aria-controls="home-center"
              role="tab" aria-selected="true">
              Proveedores
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="service-tab-center" href="#" aria-controls="service-center"
              role="tab" aria-selected="false">
              Categorías
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="account-tab-center" href="#"
              aria-controls="account-center" role="tab" aria-selected="false">
              Fabricantes
            </a>
          </li>
        </ul>
        <table class="table table-condensed table-hover table-bordered table-striped">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Nombre</th>
              <th>NIT</th>
              <th>Telefono</th>
              <th>Direccion</th>
              <th style="width:15%;" class="text-right">Opciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!-- /.card -->

    <!--Create Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addProviderModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="createForm">
            <div class="modal-header">
              <h4 class="modal-title"><i class="bx bx-plus"></i> Registrar nuevo proveedor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger alert-icon-left d-none" role="alert" id="posterror">
                Hay datos importantes que hacen falta
              </div>
              <hr>
              <div class="row">
                <div class="form-group col-6">
                  <label for="name" class="control-label">Codigo: </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bx bx-key"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Codigo" name="code" id="code"
                      autocomplete="off">
                  </div>
                </div>
                <div class="form-group col-6">
                  <label for="name" class="control-label">Contacto: </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bx bxs-contact"></i></span>
                    </div>
                    <input type="number" class="form-control" placeholder="Telefono" name="phone" id="phone"
                      autocomplete="off">
                            </div>
                        </div>
                        <div class=" form-group col-12">
                    <label for="name" class="control-label">Nombre: </label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Nombre" name="name" id="name"
                        autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group col-12">
                    <label for="name" class="control-label">NIT (Identificación tributaria): </label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="NIT" name="nit" id="nit" autocomplete="off">
                    </div>
                  </div>
                  <div class=" form-group col-12">
                    <label for="name" class="control-label">Direccion: </label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Direccion" name="address" id="address"
                        autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                  autocomplete="off">
                  <i class="bx bx-save"></i> Guardar</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <!--Edit Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editSupplierModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="editform">
            <div class="modal-header">
              <h4 class="modal-title"><i class="bx bx-edit"></i> Editar proveedor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger alert-icon-left d-none" role="alert" id="puterror">
                Hay datos importantes que faltan
              </div>
              <hr>
              <input type="hidden" id="put_id">
              <div class="form-group col-12">
                <label for="name" class="control-label">Contacto: </label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bx bxs-contact"></i></span>
                  </div>
                  <input type="number" class="form-control" placeholder="Telefono" name="uphone" id="uphone"
                    autocomplete="off">
                        </div>
                    </div>
                    <div class=" form-group col-12">
                  <label for="name" class="control-label">Nombre: </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nombre" name="uname" id="uname"
                      autocomplete="off">
                  </div>
                </div>
                <div class="form-group col-12">
                  <label for="name" class="control-label">NIT: </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nombre" name="unit" id="unit"
                      autocomplete="off">
                  </div>
                </div>
                <div class=" form-group col-12">
                  <label for="name" class="control-label">Direccion: </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Direccion" name="uaddress" id="uaddress"
                      autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" id="editSupplier" class="btn btn-primary btn-block" data-loading-text="Loading..."
                  autocomplete="off">
                  <i class="bx bx-save"></i> Actualizar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </fragment>
</template>

<script>
export default {
    name: 'Suppliers',
}
</script>
