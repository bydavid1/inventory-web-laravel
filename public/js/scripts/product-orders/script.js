//vue integration
var vum = new Vue({
    el : '#app',
    data () {
        return {
            items : [],
            data : {
                'quantityValue' : 0,
                'subtotalValue' : 0.00,
                'discountsValue' : 0.00,
                'additionalPayments' : 0.00,
                'taxValue' : 0.00,
                'totalValue' : 0.00,
                'note' : ''
            },
            discountControl : 0,
            addPaymentControl : 0
        }
    },
    methods : {
        add (id) {
            axios
            .get('/api/products/order/' + id + '/prices')
            .then(response => {
                let data = response.data[0]
                let item = {
                    'id' : data.id,
                    'name' : data.name,
                    'prices' : data.prices,
                    'price' : data.prices[0].price_incl_tax,
                    'quantity' : 1,
                    'total' : data.prices[0].price_incl_tax
                }
                
                this.items.push(item) 
            })
        },
        calcTotals () {
            for(item of this.items){
                console.log(item) //error
            }
        }
    },
})

/**************************************************************************************************************/
/*********************************************** Components  **************************************************/
/**************************************************************************************************************/

Vue.component('item', {
    data () {
        return {

        }
    },
    props : ['item'],
    template :
        /*html*/`<div class="list-group-item p-0" :id="item.id">
                    <div class="row h-100">
                        <input type="hidden" id="productId" name="productId" v-model="item.id"/>
                        <input type="hidden" id="amountValue" name="amountValue" value="0.00"/> 
                        <div class="col-md-1 py-0 h-100 my-auto">
                            <button type="button" class="btn bg-transparent" onclick="removeItem()">
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
                                            <option v-for="price in item.prices" :value="price.price_incl_tax">{{ '$' + price.price_incl_tax }}</option>
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
                </div>`,
    
        computed : {
            calculateTotal : function () {
                this.item.total = this.item.quantity * this.item.price
                this.$emit('datachange')
                return this.item.total
            }
        },
    })

