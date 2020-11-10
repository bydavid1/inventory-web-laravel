//set token to axios header
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

import table_details from './components/TableDetails.js'
import result from './components/Result.js'

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
        searchControl : "",
        loader : false
    },
    methods : {
        addNewProduct () {
            //Falta validar si se ingresa dos veces el mismo codigo
            if (this.newProduct.name == "" || this.newProduct.code == "" || this.newProduct.category == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Datos incompletos',
                })
            }else{
                if (isNaN(parseFloat(this.newProduct.quantity)) || isNaN(parseFloat(this.newProduct.purchase)) || isNaN(parseFloat(this.newProduct.price))) {
                    Swal.fire({
                        icon: 'error',
                        title: 'La cantidad y los precios deben ser numericos',
                    })
                } else {
                    if (this.newProduct.price <= this.newProduct.purchase) {
                        Swal.fire({
                            icon: 'error',
                            title: 'El precio debe ser mayor que el precio de compra',
                        })
                    } else {
                        this.newProduct.total = this.newProduct.quantity * this.newProduct.purchase
                        let objectClone = {
                            ...this.newProduct //avoiding mutations
                        }
                        this.items.push(objectClone)
                        Object.assign(this.newProduct, this.newProductInitialState())
                    }
                }
            }
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
            fields[0] = ['id','code', 'name', 'stock']
            fields[1] = ['first_price', 'first_image']
            axios.get(`/api/products/search/${this.searchControl}/${JSON.stringify(fields)}`)
            .then(response => {
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

            const validation = this.isValidated()

            if (validation.response == true) {

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
            } else {

                let validatedErrors = "<ul>"
                validation.errors.forEach(value => {
                    validatedErrors += `<li>${value}</li>`
                })
                validatedErrors += "</ul>"

                Swal.fire({
                    icon: 'warning',
                    title: 'Se encontraron errores en los datos',
                    html : validatedErrors,
                });
            }
        },
        isValidated () {
            let errors = []
            if (this.data.supplierId == "") {
                errors.push(`No se ha especificado el proveedor o cliente`)
            }

            if (this.data.totalValue < 1) {
                errors.push(`El total no puede ser 0 ni negativo`)
            }

            for (const item of this.items) {
                if (item.name == "") {
                    errors.push(`El nombre no puede estar vacío, revise los datos`)
                    item.name = "Nombre indefinido"
                }

                if (item.purchase == "" || item.purchase == 0) {
                    errors.push(`El precio de compra de <strong>${item.name}</strong> no debe de estar vacio o debe ser mayor a 0`)
                }

                if (item.quantity == "" || item.quantity == 0) {
                    errors.push(`La cantidad de <strong>${item.name}</strong> no debe de estar vacio o debe ser mayor a 0`)
                }

                if (item.total == "" || item.total == 0) {
                    errors.push(`El precio total de <strong>${item.name}</strong> no debe de estar vacio o debe ser mayor a 0`)
                }

                if (item.isNewProduct == true) {
                    if (item.price < item.purchase) {
                        errors.push(`El precio venta ($${item.price}) de <strong>${item.name}</strong> no puede ser menor al precio de compra ($${item.purchase})`)
                    }

                    if (item.code == "") {
                        errors.push(`El codigo de <strong>${item.name}</strong> no puede estar vacío`)
                    }

                    if (item.category == "") {
                        errors.push(`La categoría de <strong>${item.name}</strong> es requerida`)
                    }

                }
            }

            if (errors.length > 0) {
                return {
                    response : false,
                    errors : errors
                }
            } else {
                return {
                    response : true,
                }
            }
        }
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
