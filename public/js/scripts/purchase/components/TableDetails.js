import item from './Item.js'

export default {
    name : 'table_details'
}

Vue.component('table_details', {
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
    template :
/*html*/`<table class="table">
            <thead>
                <tr>
                    <th></th>
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
        </table>`

})
