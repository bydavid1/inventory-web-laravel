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
                //get data object fron json
                const data = response.product;
                const id = data[0].id
                const price = Number(data[0].first_price.price_incl_tax).toFixed(2);

                const count = Number(document.getElementById('items').childElementCount) + 1

                const itemrow = document.getElementById('item' + id) ///Element could exist or not

                //verify if exist item
                if (!itemrow) {
                    let item = `<div class="list-group-item pr-3" id="item${id}" item="${count}">
                                    <div class="row p-0">
                                        <div class="col-md-1 py-0 h-100 my-auto">
                                            <span>
                                                <i class="fa fa-trash fa-2x"></i>
                                            </span>
                                        </div>
                                        <input type="hidden" id="productId" value="${id}"/>
                                        <div class="col-md-4 py-0 h-100 my-auto">
                                            <h6><span id="quantity${count}">1</span> ${data[0].name}<h6>
                                            <input type="hidden" value="1" id="quantityValue${count}"/>
                                        </div>
                                        <div class="col-md-3 py-0 h-100 my-auto"> 
                                            <h6>$${price}</h6>
                                            <input type="hidden" value="${price}" id="priceValue${count}"/>
                                        </div>
                                        <div class="col-md-3 py-0 h-100 my-auto"> 
                                            <h6 id="total${count}">$${price}</h6>
                                            <input type="hidden" value="${price}" id="totalValue${count}"/>
                                        </div>
                                        <input type="hidden" id="taxValue" value="0.00"/>
                                        <div class="col-md-1 py-0 h-100 my-auto"> 
                                            <button class="btn btn-primary" onclick="editItem(${id})"><i class="fa fa-edit"></i></button>
                                        </div>
                                    </div>
                                </div>`

                    document.getElementById('items').insertAdjacentHTML('beforeend', item)
                }else{

                    const count = itemrow.getAttribute('item')

                    let quantity = document.getElementById('quantityValue' + count)
                    let qtyValue = Number(quantity.value) + 1
                    let totalValue = (qtyValue * price).toFixed(2)

                    quantity.value = qtyValue
                    document.getElementById('quantity' + count).textContent = qtyValue
                    document.getElementById('quantityValue' + count).value = qtyValue
                    document.getElementById('total' + count).textContent = `$${totalValue}`
                    document.getElementById('totalValue' + count).value = totalValue
                }

                calculate()

            },
            204: function () {

            },
            500: function () {
                Swal.fire({
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

//----------------------------------------------------------------
//--------------------Pagination----------------------------------
//----------------------------------------------------------------

document.addEventListener('click', function(event){
    if (event.target.matches('.pagination a')) {
        event.preventDefault()
        const target = event.target;
        console.log(target)
        const page = target.getAttribute('href').split('page=')[1]

        $.ajax({
            url:"/pagination/fetch?page=" + page,
            success:function(data){
                document.getElementById('products').innerHTML = data
            },
            error:function(xhr, textStatus, errorMessage){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Error en el servidor ' + xhr.responseText,
                    button: false,
                });
            }
        });
    }
})

//----------------------------------------------------------------
//--------------------Calculate----------------------------------
//----------------------------------------------------------------

function calculate(){
    const childs = document.getElementById('items').childElementCount
    let subtotal = 0
    let grandQuantity = 0

    //seting trcount value
    document.getElementById('itemsCount').value = childs
    //sum all items
    for (let i = 1; i <= childs; i++) {
        grandQuantity += Number(document.getElementById('quantityValue' + i).value)
        subtotal += Number(document.getElementById('totalValue' + i).value)
    }

    //seting values
    document.getElementById('grandquantity').textContent = grandQuantity
    document.getElementById('grandquantityvalue').value = grandQuantity
    document.getElementById('subtotal').textContent = "$" + subtotal
    document.getElementById('subtotalvalue').value = subtotal

    calculateAdditionalData(subtotal)
}


function calculateAdditionalData(subtotal){
    const discounts =  Number(document.getElementById('additionalDiscounts').value).toFixed(2)
    const payments =  Number(document.getElementById('additionalPayments').value).toFixed(2)

    const total = (Number(subtotal) + payments - discounts).toFixed(2)

    document.getElementById('grandtotal').textContent = "$" + total
    document.getElementById('grandtotalvalue').value = total
    document.getElementById('discounts').textContent = "$" + discounts
    document.getElementById('additionalpayments').textContent = "$" + payments

}