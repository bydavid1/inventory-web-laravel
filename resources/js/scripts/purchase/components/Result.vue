<template>
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
                <result-item v-for="result in results" :key="result.id" v-on:choose="$emit('choose', $event)" :item="result"></result-item >
            </tbody>
        </table>
    </div>
</template>

<script>
let component = require('./ResultItem.vue').default

export default {
    name: 'Result',
    props: {
        results : {
            type : Array,
            required : true
        }
    },
    components: {
        'result-item': component
    }
}
</script>
