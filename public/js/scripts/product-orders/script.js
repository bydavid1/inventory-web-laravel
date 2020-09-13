//set token to axios header
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

var vm = new Vue({
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
                'note' : '',
                'name' : '',
                'products' : []
            },
            discountControl : 0,
            addPaymentControl : 0,
        }
    },
    methods : {
        add (id) {
            if(document.getElementById('item' + id) == null){
                axios
                .get('/api/products/order/' + id + '/prices')
                .then(response => {
                    let data = response.data[0]
                    let item = {
                        'id' : data.id,
                        'code' : data.code,
                        'name' : data.name,
                        'prices' : data.prices,
                        'tax' : 0.00,
                        'price' : data.prices[0].price_incl_tax,
                        'quantity' : 1,
                        'total' : data.prices[0].price_incl_tax
                    }
                    
                    this.items.push(item) 
                })
            }
        },
        removeItem (index) {
            this.items.splice(index, 1)
        },
        calculate(calculateAll = true){
            if(calculateAll = true){
                this.data.quantityValue = 0
                this.data.subtotalValue = 0
                for(let item of this.items){
                    this.data.quantityValue += Number(item.quantity) 
                    this.data.subtotalValue += Number(item.total)
                }
            }

            this.data.totalValue = (this.data.subtotalValue - this.data.discountsValue + Number(this.data.additionalPayments))
        },
        addDiscount () {
            this.data.discountsValue = this.discountControl 
            this.calculate(false)
        },
        addPayment () {
            this.data.additionalPayments = this.addPaymentControl
            this.calculate(false)
        },
        saveSale() {
            //packing data
            let products = this.items
            for(let current of products){
                delete current.prices //delete prices beacuse server not needed
            }
            this.data.products = products
            axios.post(route('storeSale'), this.data)
                .then(response => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                    });
                    this.print(response.data.invoice.invoice) //!!!!!!!!!!!!!!!!fix this response
                    Object.assign(this.$data, this.initialState());
                })
                .catch(error => {
                    console.log(error.response.data)
                    Swal.fire({
                        icon: 'error',
                        html: error.response.data.message,
                        showConfirmButton: true,
                    });
                })
        },
        print(invoice) {
            let target = window.open('', 'PRINT', 'height=800,width=800');
            target.document.write(invoice);
            target.print();
            target.close();
        },
        initialState () {
            return {
                items : [],
                data : {
                    'quantityValue' : 0,
                    'subtotalValue' : 0.00,
                    'discountsValue' : 0.00,
                    'additionalPayments' : 0.00,
                    'taxValue' : 0.00,
                    'totalValue' : 0.00,
                    'note' : '',
                    'name' : '',
                    'products' : []
                },
                discountControl : 0,
                addPaymentControl : 0,
            }
        }
    },
    watch : {
        items : {
            handler : function () {
                this.calculate()
            },
            deep: true
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
    /*html*/`<div class="list-group-item p-0" :id="'item' + item.id">
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