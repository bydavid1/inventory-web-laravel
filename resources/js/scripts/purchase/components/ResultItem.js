export default {
    name : 'Result_item'
}

Vue.component('Result_item', {
    props: ['item'],
    template :
    /*html*/`
        <tr>
            <td><img :src="'/storage/' + item.first_image.src" width="70" height="70" class="object-fit: cover"/></td>
            <td>{{ item.code }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.stock }}</td>
            <td>{{ '$' + item.first_price.price }}</td>
            <td>
                <a role="button" v-on:click="$emit('choose', item)">
                    <i class="badge-circle badge-circle-info bx bx-plus font-medium-1 cursor-pointer"></i>
                </a>
            </td>
        </tr>`,
})
