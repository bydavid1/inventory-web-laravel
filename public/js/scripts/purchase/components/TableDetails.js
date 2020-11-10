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
                <item :item="item" v-for="(item, index) in items" :key="index" v-on:remove="removeItem(index)"></item>
            </tbody>
        </table>`

})
