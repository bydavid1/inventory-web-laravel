export default {
    name : 'Product'
}

Vue.component('Product', {
    props : ['product'],
    template :
/*html*/`<div class="col-xl-2 col-lg-3 col-md-4">
            <div class="card cursor-pointer" v-on:click="$emit('add')" style="height: 200px">
                <div class="card-content h-100">
                    <div v-bind:style="{'background-image': 'url(' + getPath() + ')',
                        'background-repeat' : 'no-repeat',
                        'background-size' : 'cover', 'background-size' : 'cover', 'height' : '60%'}">
                        <div class="heading-elements">
                            <div class="float-right badge badge-primary">{{ 'Stock:' + product.stock }}</div>
                        </div>
                    </div>
                    <div class="p-1" style="height: 40%">
                        <h6 class="card-title mb-0">{{ product.name }}</h6>
                        <h6 class="text-primary">{{ '$ ' + (product.first_price.price).toFixed(2) }}</h6>
                    </div>
                </div>
            </div>
        </div>`,
    methods: {
        getPath() {
            return this.product.first_image.src == "default" ? "/assets/media/photo_default.png" : "/storage/" + this.product.first_image.src;
        }
    }
})
