<template>
    <table class="table">
        <thead>
            <tr>
                <th>Eliminar</th>
                <th>Item</th>
                <th>Precio de compra</th>
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <item v-for="(item, index) in items" :key="index" :item="item" v-on:remove="removeItem(index)" v-on:edit="$emit('edit', index)"></item>
        </tbody>
    </table>
</template>

<script>
let component = require('./Item.vue').default

export default {
    name: 'TableDetails',
    props : {
        items : {
            type : Array,
            required : true
        }
    },
    methods : {
        removeItem (index) {
            this.items.splice(index, 1)
        }
    },
    components: {
        'item': component
    }
}
</script>
