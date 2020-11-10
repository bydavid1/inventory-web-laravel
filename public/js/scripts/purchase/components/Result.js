import result_item from './ResultItem.js'

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
        <div class="table-responsive table-condensed">
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
                    <result_item v-for="result in results" :key="result.id" v-on:choose="$emit('choose', $event)" :item="result"></result_item>
                </tbody>
            </table>
        </div>`,
})
