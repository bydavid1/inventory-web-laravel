export default {
    name : 'Results'
}

Vue.component('Results', {
    props: {
        results : {
            type : Array,
            required : true
        }
    },
    template :
    /*html*/`
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Agregar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="result in results" :key="result.id" :item="result">
                        <td><img :src="'/' + result.first_image.src" width="70" height="70" class="object-fit: cover"/></td>
                        <td>{{ result.code }}</td>
                        <td>{{ result.name }}</td>
                        <td>{{ result.stock }}</td>
                        <td>{{ result.first_price.price }}</td>
                        <td>
                            <a role="button" v-on:click="$emit('choose', result)">
                                <i class="badge-circle badge-circle-info bx bx-plus font-medium-1 cursor-pointer"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>`,
})
