//set token to axios header
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

import item from './components/Item.js'
import result from './components/Result.js'

var vm = new Vue({
    el : '#app',
    data : {
        items : [],
        results : [],
        data : {
            'supplierId' : '',
            'quantityValue' : 0.00,
            'subtotalValue' : 0.00,
            'discountsValue' : 0.00,
            'additionalPayments' : 0.00,
            'taxValue' : 0.00,
            'totalValue' : 0.00,
            'comments' : "",
            'products' : []
        },
        newProduct : {
            isNewProduct : true,
            name : "",
            code : "",
            category : "",
            quantity : 0.00,
            purchase : 0.00,
            price : 0.00,
            total : 0.00 //total of purchase
        },
        searchControl : "",
        loader : false
    },
    methods : {
        addNewProduct () {
            if (this.newProduct.name != "" || this.newProduct.code != "" || this.isNumeric(this.newProduct.quantity) || this.isNumeric(this.newProduct.purchase) || this.isNumeric(this.newProduct.price)) {
                    this.newProduct.total = this.newProduct.quantity * this.newProduct.purchase
                    this.items.push(this.newProduct)
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Datos incompletos o erroneos',
                    showConfirmButton: true,
                });
            }
        },
        chooseProduct (result) {
            let product = {
                'isNewProduct' : false,
                'id' : result.id,
                'name' : result.name,
                'purchase' : 0.00,
                'total' : 0.00,
                'quantity' : 0
            }

            this.items.push(product)
        },
        isNumeric (value){
            return isNaN(parseFloat(value)) ? true : false
        },
        searchTimer () {
            this.loader = true
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.searchProduct()
            }, 900);
        },
        searchProduct (){
            let fields = [];
            fields[0] = ['id','code', 'name', 'stock']
            fields[1] = ['first_price', 'first_image']
            axios.get(`/api/products/search/${this.searchControl}/${JSON.stringify(fields)}`)
            .then(response => {
                console.log(response.data)
                this.results = response.data
            })
            .catch(error => {
                console.log(error.response.data.message)
            })
            this.loader = false
        },
        calculate(calculateAll = true){
            if(calculateAll = true){
                this.data.quantityValue = 0
                this.data.subtotalValue = 0
                for(let item of this.items){
                    this.data.quantityValue += Number(item.quantity)
                    this.data.subtotalValue += Number(item.total)
                }
                this.formatCurrency(this.data.subtotalValue)
            }

            this.data.totalValue = (this.data.subtotalValue - this.data.discountsValue + Number(this.data.additionalPayments))
            this.formatCurrency(this.data.totalValue)
        },
        formatCurrency (value){
            let ret = 0;

            try {

                ret = new Intl.NumberFormat('en-US',{ style: 'currency', currency: 'USD' }).format(value)

                return ret

            } catch (error) {
                console.error(`Ha fallado el formato a USD: ${error}`)
            }
        },
        storePurchase () {
            Swal.fire({
                title: 'Guardando',
                html: 'Por favor espere...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            })

            this.data.products = this.items;

            axios.post(route('storePurchase'), this.data)
            .then(response => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.data.message,
                    showConfirmButton: false,
                });
            })
            .catch(error => {
                let data = error.response.data
                let errorsLog = ""
                if (data.hasOwnProperty('errors')) {
                    let err = Object.values(data.errors);
                    err = err.flat()
                    err.forEach(value => {
                        errorsLog += `<p>${value}</p>`
                    });
                }else{
                    errorsLog = "<p>No errors registered</p>"
                }

                Swal.fire({
                    icon: 'error',
                    title: data.message,
                    html : errorsLog,
                    showConfirmButton: true,
                });
            })
        },
    },
    watch : {
        items : {
            handler : function () {
                this.calculate()
            },
            deep : true
        }
    }
})
