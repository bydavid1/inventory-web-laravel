//set token to axios header
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

import item from './components/Item.js'
import product from "./components/Product.js"
import pagination from "./components/Pagination.js"
import new_customer from "./components/NewCustomer.js"


var vm = new Vue({
    el : '#app',
    data () {
        return {
            items : [],
            data : {
                invoiceType : "1",
                quantityValue : 0,
                subtotalValue : 0.00,
                discountsValue : 0.00,
                additionalPayments : 0.00,
                taxValue : 0.00,
                totalValue : 0.00,
                note : '',
                customerName : '',
                customerId : '',
                paymentMethod : '1',
                products : []
            },
            customers : [],
            showAutocomplete : false,
            discountControl : 0,
            addPaymentControl : 0,
            searchControl : "",
            inventory : {},
            loader : false
        }
    },
    mounted () {
        this.getInventory()
    },
    methods : {
        getInventory(page = 1) {
            this.loader = true
            axios.get('/api/pagination/fetch?page=' + page)
            .then(response => {
                console.log(response);
                this.inventory = response.data;
                this.loader = false
            })
            .catch(error => {
                //make alert for error
                console.log(error.response)
                this.loader = false
            })

        },
        add (id) {
            if(document.getElementById('item' + id) == null){
                this.loader = true
                let fields = []
                fields[0] = ['id', 'code', 'name']
                fields[1] = ['prices']
                axios.get('/api/products/' + id + '/' + JSON.stringify(fields))
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
                    this.loader = false
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
                this.formatCurrency(this.data.subtotalValue)
            }

            this.data.totalValue = (this.data.subtotalValue - this.data.discountsValue + Number(this.data.additionalPayments))
            this.formatCurrency(this.data.totalValue)
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
            Swal.fire({
                title: 'Guardando',
                html: 'Por favor espere...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            })
            //packing data
            let products = this.items
            for(let current of products){
                delete current.prices //delete prices beacuse server not will need
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
                    this.getInventory()
                })
                .catch(error => {
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
                    invoiceType : "1",
                    quantityValue : 0,
                    subtotalValue : 0.00,
                    discountsValue : 0.00,
                    additionalPayments : 0.00,
                    taxValue : 0.00,
                    totalValue : 0.00,
                    note : '',
                    customerName : '',
                    customerId : '',
                    paymentMethod : '1',
                    products : []
                },
                customers : [],
                showAutocomplete : false,
                discountControl : 0,
                addPaymentControl : 0,
            }
        },
        searchTimer (fn) {
            this.loader = true
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                fn == 'searchProduct' ? this.searchProduct() : this.searchCustomer()
            }, 900);
        },
        searchProduct () {
            axios
            .get('/api/pagination/fetch/search/' + this.searchControl)
            .then(response => {
                this.inventory = response.data;
            })
            this.loader = false
        },
        searchCustomer () {
            this.closeAllLists();
            this.data.customerId = "";
            axios.get('/api/customers/search/' + this.data.customerName)
                .then(response => {
                    if (response.data.success == true) {
                        let data = response.data.data;
                        for (let i = 0; i < data.length; i++) {
                            this.customers.push({'name' : data[i].name, 'id' : data[i].id});
                        }

                        this.showAutocomplete = true
                    }else{
                        //container.innerHTML = `<div>No hay clientes que coincidan</div>`;
                    }
                })
                .catch(error => {
                    //container.innerHTML = `Ocurrió un problema en el servidor`;
                })

            this.loader = false
        },
        chooseCustomer (customer) {
            this.data.customerName = customer.name;
            this.data.customerId = customer.id;
            this.closeAllLists()
        },
        closeAllLists () {
            this.showAutocomplete = false
            this.customers = []
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
        appClick (){
            this.closeAllLists();
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


