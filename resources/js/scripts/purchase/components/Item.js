export default {
    name : 'Item'
}

Vue.component('Item', {
    computed : {
        calculateTotal() {
            return this.item.quantity * this.item.purchase
        }
    },
    watch : {
        calculateTotal(value){
            this.item.total = value.toFixed(2)
        }
    },
    props : {
        item : {
            type : Object,
            required : true
        },
    },
    template :
/*html*/`<tr>
            <td class="d-flex">
                <button type="button" class="btn bg-transparent" v-on:click="$emit('remove')"><i class="bx bx-trash bx-sm text-danger"></i></button>
                <button type="button" v-if="item.isNewProduct" class="btn bg-transparent" data-toggle="modal" data-target="#editNewProductModal" v-on:click="$emit('edit')">
                    <i class="bx bx-edit bx-sm text-info"></i>
                </button>
            </td>
            <td><input type="text" disabled class="form-control" v-model="item.name" placeholder="0"></td>
            <td><input type="number" step=".01" min="0" class="form-control" v-model.number="item.purchase" placeholder="0"></td>
            <td><input type="number" class="form-control" v-model.number="item.quantity" placeholder="0"></td>
            <td><input type="number" step=".01" min="0" class="form-control" v-model.number="item.discount" placeholder="0"></td>
            <td><strong class="text-primary">{{ '$' + item.total }}</strong></td>
        </tr>`

})
