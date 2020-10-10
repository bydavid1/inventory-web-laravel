export default {
    name : 'new_customer'
}

Vue.component('new_customer', {
    data () {
        return {
            code : "",
            name : "",
            nit : "",
            phone : "",
            email : "",
            address : "",
        }
    },
    template :
/*html*/`<div class="modal fade" tabindex="-1" role="dialog" id="addCostumer">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crear Nuevo cliente</h4>
                        <button class="close ml-2" data-dismiss="modal" arial-label="close"><span
                            aria-hidden="true">x</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="bx bx-user fa-4x mb-1"></i>
                        </div>
                        <form v-on:submit.prevent="storeCustomer">
                            <div class="form-group">
                                <label>Codigo: </label>
                                    <input type="number" class="form-control" v-model="code" placeholder="Codigo identificador" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Nombre: </label>
                                    <input type="text" class="form-control" v-model="name" placeholder="Ej. José Perez" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>NIT: </label>
                                    <input type="tel" class="form-control" v-model="nit" placeholder="NIT" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Telefono: </label>
                                    <input type="tel" class="form-control" v-model="phone" placeholder="Telefono de contacto" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                    <input type="email" class="form-control" v-model="email" placeholder="Ej. nombre@gmail.com" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Direccion: </label>
                                    <input type="text" class="form-control" v-model="address" placeholder="Direccion" autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block" data-loading-text="Loading..."
                            autocomplete="off"> <i class="fas fa-check"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>`,
    methods : {
        storeCustomer : function () {
            console.info('sending data')
        }
    }
})
