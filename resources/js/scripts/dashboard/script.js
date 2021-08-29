Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

var vm = new Vue({
    el: "#app",
    data: function () {
        return {
            products: 0,
            customers: 0,
            options: {
                xaxis: {
                    type : 'date',
                    categories: []
                },
            },
            series: [{
                name: 'Ventas',
                data: []
            },
            {
                name: 'Compras',
                data: []
            }],
            items: {

            }
        }
    },
    mounted () {
        this.getTilesData()
        this.getCharData()
        this.getLastItems()
    },
    methods : {
        getTilesData () {
            axios.get('/api/dashboard/tiles')
            .then(response => {
                this.products = response.data.products;
                this.customers = response.data.customers;
            })
            .catch(error => {
                console.error(error.response)
            })
        },
        getCharData () {
            axios.get('/api/dashboard/chart')
            .then(response => {
                let data = response.data
                this.series = [{
                    data : data.sales
                },
                {
                    data : data.purchases
                }]
                this.options = {
                    xaxis: {
                        type : 'datetime',
                        categories: data.labels
                    },
                }

            })
            .catch(error => {
                console.error(error)
            })
        },
        getLastItems () {
            axios.get('/api/dashboard/items')
            .then(response => {
                console.info(response)
                this.items = response.data.items;
            })
            .catch(error => {
                console.error(error)
            })
        },
    }
})
