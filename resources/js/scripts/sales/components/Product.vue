<template>
    <div class="col-xl-3 col-md-4">
        <div class="card cursor-pointer" v-on:click="$emit('add')" style="height: 200px">
            <div class="card-content h-100">
                <div v-bind:style="{'background-image': 'url(/' + product.photo.source + ')','background-repeat' : 'no-repeat',
                    'background-size' : 'cover', 'background-size' : 'cover', 'height' : '60%'}">
                    <div class="heading-elements">
                        <div class="float-right badge badge-primary">{{ 'Stock:' + product.stock[0].stock }}</div>
                    </div>
                </div>
                <div class="p-1" style="height: 40%">
                    <h6 class="card-title mb-0">{{ product.name }}</h6>
                    <h6 class="text-primary">{{ '$ ' + product.price.price_w_tax }}</h6>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'product',
    props: ['product']
}
</script>
