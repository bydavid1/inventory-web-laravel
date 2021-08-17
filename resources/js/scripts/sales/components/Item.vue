<template>
    <div class="list-group-item p-0" :id="'item' + item.id">
        <div class="row h-100">
            <input type="hidden" id="productId" name="productId" v-model="item.id"/>
            <input type="hidden" id="amountValue" name="amountValue" value="0.00"/>
            <div class="col-md-1 py-0 h-100 my-auto">
                <button type="button" class="btn bg-transparent" v-on:click="$emit('remove')">
                    <i class="bx bx-trash fa-2x text-danger"></i>
                </button>
            </div>
            <div class="col-md-2 py-0 h-100 my-auto">
                <div class="form-group my-auto">
                    <input type="number" class="form-control" style="padding: 0.50rem 0.5rem" id="quantity" v-model="item.quantity"/>
                </div>
            </div>
            <div class="col-md-4 py-0 h-100 my-auto">
                <h6>{{ item.name }}</h6>
            </div>
            <div class="col-md-2 py-0 h-100 my-auto ">
                <h6 class="cursor-pointer text-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" role="button">{{ '$' + item.price }}</h6>
                <div class="dropdown-menu p-1">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="prices">Precios registrados</label>
                            <select class="form-control" v-model="item.price">
                                <option v-for="price in item.prices" :value="price.price_w_tax" :key="price.id">{{ '$' + price.price_w_tax }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 py-0 h-100 my-auto">
                <h6 id="total">{{ '$' + calculateTotal }}</h6>
                <input type="hidden" v-model="calculateTotal" id="totalValue" name="totalValue"/>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'item',
    props: ['item'],
    computed: {
        calculateTotal : function () {
            this.item.total = (this.item.quantity * this.item.price).toFixed(2)
            this.$emit('datachange')
            return this.item.total
        }
    }
}
</script>
