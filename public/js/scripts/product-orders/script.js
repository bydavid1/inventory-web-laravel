

function add(id){

    let url =  domain.getDomain('api/products/order/' + id)

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function (objeto) {

        },
        statusCode: {
            200: function (response) {
                console.log(response)
                //get data object fron json
                const data = response.product;
                const id = data[0].id
                const price = Number(data[0].first_price.price_incl_tax).toFixed(2);
                //verify if exist item

                if (!document.getElementById('item' + data[0].id)) {
                    let item = `<div class="list-group-item pr-3" id="item${id}">
                                    <div class="row p-0">
                                        <div class="col-md-1 py-0 h-100 my-auto">
                                            <span>
                                                <i class="fa fa-trash fa-2x"></i>
                                            </span>
                                        </div>
                                        <div class="col-md-5 py-0 h-100 my-auto">
                                            <h5><span id="qty${id}">1</span> ${data[0].name}<h5>
                                            <input type="hidden" value="1" id="quantity${id}"/>
                                        </div>
                                        <div class="col-md-3 py-0 h-100 my-auto"> 
                                            <h5>$${price}</h5>
                                        </div>
                                        <div class="col-md-3 py-0 h-100 my-auto"> 
                                            <h5 id="total${id}">$${(price * 1).toFixed(2)}</h5>
                                        </div>
                                    </div>
                                </div>`

                    document.getElementById('items').insertAdjacentHTML('beforeend', item)
                }else{
                    let quantity = document.getElementById('quantity' + data[0].id)
                    let qtyValue = Number(quantity.value) + 1

                    quantity.value = qtyValue
                    document.getElementById('qty' + id).textContent = qtyValue
                    document.getElementById('total' + id).textContent = `$${(qtyValue * price).toFixed(2)}`
                }

            },
            204: function () {

            },
            500: function () {
                swal({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Error en el servidor',
                    button: false,
                    timer: 1500
                });
            }
        }
    })
}