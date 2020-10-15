import item from './components/Item.js'
import result from './components/Result.js'

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
