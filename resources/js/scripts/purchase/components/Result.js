export default {
    name : 'Result'
}

Vue.component('Result', {
    props: {
        item : {
            type : Object,
            required : true
        }
    },
    template :
    /*html*/`<tr>
        <td>{{ item.first_image }}</td>
        <td>{{ item.code }}</td>
        <td>{{ item.name }}</td>
        <td>{{ item.quantity }}</td>
        <td>{{ item.first_price }}</td>
        <td></td>
    </tr>`
})
