import item from './components/Item.js'

var vm = new Vue({
    el : '#app',
    data : {
        items : [],
        results : [],
        data : {
            grandQuantity : 0.00,
            subtotal : 0.00,
            grandTotal : 0.00,
            comments : ""
        },
        newProduct : {
            name : "",
            code : "",
            supplier : "",
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
        addNewProduct() {
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
        isNumeric(value){
            return isNaN(parseFloat(value)) ? true : false
        }
    },
    watch : {
        items : {
            handler : function () {

            },
            deep : true
        }
    }
})
