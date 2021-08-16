export default {
    name : 'Result_item'
}

Vue.component('Result_item', {
    props: ['item'],
    template :
    /*html*/`
        <tr>
            <td><img :src="'/storage/' + item.photo.source" width="50" height="50" class="object-fit: cover"/></td>
            <td>{{ item.code }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.stock[0].pivot.stock }}</td>
            <td>{{ '$' + item.price?.price_w_tax }}</td>
            <td>
                <a role="button" v-on:click="$emit('choose', item)">
                    <i class="badge-circle badge-circle-info bx bx-plus font-medium-1 cursor-pointer"></i>
                </a>
            </td>
        </tr>`,
})
