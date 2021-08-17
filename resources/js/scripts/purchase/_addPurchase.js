import Vue from 'vue'
//set token to axios header
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

Vue.component('table_details', require('./components/TableDetails.vue').default)
Vue.component('result', require('./components/Result.vue').default)

var vm = new Vue({
    el : '#app',
    data : {
        items : [],
        results : [],
        data : {
            supplierId : '',
            quantityValue : 0.00,
            subtotalValue : 0.00,
            discountsValue : 0.00,
            additionalPayments : 0.00,
            taxValue : 0.00,
            totalValue : 0.00,
            comments : "",
            products : []
        },
        newProduct : {
            isNewProduct : true,
            name : "",
            code : "",
            category : "",
            quantity : 0.00,
            purchase : 0.00,
            price : 0.00,
            total : 0.00, //total of purchase
            discount : 0.00
        },
        editProduct : {
            isNewProduct : true,
            name : "",
            code : "",
            category : "",
            quantity : 0.00,
            purchase : 0.00,
            price : 0.00,
            total : 0.00, //total of purchase
            discount : 0.00
        },
        searchControl : "",
        loader : false
    },
    methods : {
        addNewProduct () {
            this.newProduct.total = this.newProduct.quantity * this.newProduct.purchase
            let objectClone = {
                ...this.newProduct //avoiding mutations
            }
            this.items.push(objectClone)
            Object.assign(this.newProduct, this.newProductInitialState())
        },
        editNewProduct (index) {
            Object.assign(this.editProduct, this.items[index])
        },
        confirmEditProduct () {
            this.editProduct.total = this.editProduct.quantity * this.editProduct.purchase
            let objectClone = {
                ...this.editProduct //avoiding mutations
            }
            this.items.push(objectClone)
            Object.assign(this.editProduct, this.newProductInitialState())
        },
        newProductInitialState () { //Initial state of new product object
            return {
                isNewProduct : true,
                name : "",
                code : "",
                category : "",
                quantity : 0.00,
                purchase : 0.00,
                price : 0.00,
                total : 0.00
            }
        },
        chooseProduct (result) {
            let product = {
                isNewProduct : false,
                id : result.id,
                name : result.name,
                purchase : 0.00,
                total : 0.00,
                quantity : 0,
                discount: 0
            }

            this.items.push(product)
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
            fields[0] = ['id','code','name']
            fields[1] = ['price:id,price_w_tax,product_id', 'stock', 'photo']
            axios.get(`/api/products/query/${this.searchControl}/${JSON.stringify(fields)}`)
            .then(response => {
                console.log(response)
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
                this.data.discountsValue = 0
                for(let item of this.items){
                    this.data.quantityValue += Number(item.quantity)
                    this.data.subtotalValue += Number(item.total)
                    this.data.discountsValue += Number(item.discount)
                }
                this.data.subtotalValue = (this.data.subtotalValue).toFixed(2);
            }

            this.data.totalValue = (this.data.subtotalValue - this.data.discountsValue + Number(this.data.additionalPayments))
            this.data.totalValue = (this.data.totalValue).toFixed(2);
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
                    });
                })
        },
        // isValidated () {

        //     let rules = [
        //         {field : "supplierId", validate : { type : "required", message : "No se ha especificado el proveedor o cliente"}},
        //         {field : "totalValue", validate : { type : "min", value: 0.01, message : "El total no puede ser 0 ni negativo"}},
        //         {field : "items", validate : { type : "array"}},
        //     ]

        //     let validate = new Validation(rules, this.data)

        //     let result = validate.validate()

        //     console.log(result)

        //     return {
        //         response : false,
        //     }

        //     // let errors = []
        //     // if (this.data.supplierId == "") {
        //     //     errors.push(`No se ha especificado el proveedor o cliente`)
        //     // }

        //     // if (this.data.totalValue < 1) {
        //     //     errors.push(`El total no puede ser 0 ni negativo`)
        //     // }

        //     // for (const item of this.items) {
        //     //     if (item.name == "") {
        //     //         errors.push(`El nombre no puede estar vacío, revise los datos`)
        //     //         item.name = "Nombre indefinido"
        //     //     }

        //     //     if (item.purchase == "" || item.purchase == 0) {
        //     //         errors.push(`El precio de compra de <strong>${item.name}</strong> no debe de estar vacio o debe ser mayor a 0`)
        //     //     }

        //     //     if (item.quantity == "" || item.quantity == 0) {
        //     //         errors.push(`La cantidad de <strong>${item.name}</strong> no debe de estar vacio o debe ser mayor a 0`)
        //     //     }

        //     //     if (item.total == "" || item.total == 0) {
        //     //         errors.push(`El precio total de <strong>${item.name}</strong> no debe de estar vacio o debe ser mayor a 0`)
        //     //     }

        //     //     if (item.isNewProduct == true) {
        //     //         if (item.price < item.purchase) {
        //     //             errors.push(`El precio venta ($${item.price}) de <strong>${item.name}</strong> no puede ser menor al precio de compra ($${item.purchase})`)
        //     //         }

        //     //         if (item.code == "") {
        //     //             errors.push(`El codigo de <strong>${item.name}</strong> no puede estar vacío`)
        //     //         }

        //     //         if (item.category == "") {
        //     //             errors.push(`La categoría de <strong>${item.name}</strong> es requerida`)
        //     //         }

        //     //     }
        //     // }

        //     // if (errors.length > 0) {
        //     //     return {
        //     //         response : false,
        //     //         errors : errors
        //     //     }
        //     // } else {
        //     //     return {
        //     //         response : true,
        //     //     }
        //     // }
        // }
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
