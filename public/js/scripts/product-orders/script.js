
$(document).ready(function () {

    var typingTimer; 
    var doneTypingInterval = 200;

    $('#searchInput').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(searchProduct, doneTypingInterval);

    });
})

function add(id){

    let url =  '../api/products/order/' + id

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function (objeto) {

        },
        success: function(response){
                //get data object fron json
                const data = response.product;
                const id = data[0].id
                const price = Number(data[0].first_price.price_incl_tax).toFixed(2);
                const count = Number(document.getElementById('items').childElementCount) + 1 //add 1 to total items
                const itemrow = document.getElementById(id) ///Element could exist or not

                //verify if exist item
                if (!itemrow) {
                    let item = `<div class="list-group-item p-0" id="${id}" item="${count}">
                                    <div class="row p-0">
                                        <input type="hidden" id="productId${count}" name="productId${count}" value="${id}"/>
                                        <input type="hidden" id="amountValue${count}" name="amountValue${count}" value="0.00"/> 
                                        <div class="col-md-1 py-0 h-100 my-auto">
                                            <button type="button" class="btn bg-transparent" onclick="removeItem(${id})">
                                                <i class="fa fa-trash fa-2x"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-2 py-0 h-100 my-auto">
                                            <fieldset>
                                                <div class="input-group bootstrap-touchspin">
                                                    <input type="text" class="touchspin-vertical form-control" id="quantity${count}" value="1">
                                                    <span class="input-group-btn-vertical">
                                                        <button class="btn btn-primary bootstrap-touchspin-up" type="button">
                                                            <i class="fa fa-angle-up"></i>
                                                        </button>
                                                        <button class="btn btn-primary bootstrap-touchspin-down" type="button">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </fieldset>
                                            <input type="hidden" value="1" id="quantityValue${count}" name="quantityValue${count}"/>
                                        </div>
                                        <div class="col-md-4 py-0 h-100 my-auto">
                                            <h6>${data[0].name}<h6>
                                        </div>
                                        <div class="col-md-2 py-0 h-100 my-auto"> 
                                            <h6>$${price}</h6>
                                            <input type="hidden" value="${price}" id="priceValue${count}" name="priceValue${count}"/>
                                        </div>
                                        <div class="col-md-2 py-0 h-100 my-auto"> 
                                            <h6 id="total${count}">$${price}</h6>
                                            <input type="hidden" value="${price}" id="totalValue${count}" name="totalValue${count}"/>
                                        </div>
                                        <div class="col-md-1 py-0 h-100 my-auto"> 
                                            <button class="btn btn-primary" onclick="editItem(${id})"><i class="fa fa-edit"></i></button>
                                        </div>
                                    </div>
                                </div>`

                    document.getElementById('items').insertAdjacentHTML('beforeend', item)
                }else{

                    const count = itemrow.getAttribute('item') //get count value from existing element

                    let quantity = document.getElementById('quantityValue' + count)
                    let qtyValue = Number(quantity.value) + 1
                    let totalValue = (qtyValue * price).toFixed(2)

                    quantity.value = qtyValue
                    document.getElementById('quantity' + count).value = qtyValue
                    document.getElementById('quantityValue' + count).value = qtyValue
                    document.getElementById('total' + count).textContent = `$${totalValue}`
                    document.getElementById('totalValue' + count).value = totalValue
                }

                calculate()
        },
        error: function(xhr, textStatus, errorMessage){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                text: 'Error en el servidor: ' + xhr.responseJSON.message,
                showConfirmButton: false,
                timer: 1700
            });
        },
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
                    text: 'Error en el servidor: ' + xhr.responseJSON.message,
                    showConfirmButton: false,
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

//----------------------------------------------------------------
//--------------------Remove Item----------------------------------
//----------------------------------------------------------------

function removeItem(id){
    try {
        document.getElementById(id).remove();
        reAssignCounts()
    } catch (error) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            text: 'Error' + error + ". Recargue el sitio",
            showConfirmButton: false,
        });
    }
}

function reAssignCounts(){
    const numOfItems = document.getElementById('items').childElementCount
    document.getElementById('itemsCount').value = numOfItems//set numOfitems to items count

    if (!numOfItems < 1) {
        const childs = document.getElementById('items').childNodes
        for (let i = 1; i <= numOfItems; i++) {
            let currentChild = childs[i].getAttribute('item')
            //rename ids
            changeIdAndName('productId' + currentChild, 'productId' + i)
            changeIdAndName('quantityValue' + currentChild, 'quantityValue' + i)
            changeIdAndName('priceValue' + currentChild, 'priceValue' + i)
            changeIdAndName('totalValue' + currentChild, 'totalValue' + i)
            changeIdAndName('amountValue' + currentChild, 'amountValue' + i)

            document.getElementById('quantity' + currentChild).id = 'quantity' + i
            document.getElementById('total' + currentChild).id = 'total' + i

            //rename item attribute
            childs[i].setAttribute('item', i)
        }
    }

    calculate()
}   

function changeIdAndName(identifier, nameOrId){
    const element = document.getElementById(identifier)
    element.tagName = nameOrId
    element.id = nameOrId
}


//----------------------------------------------------------------------
//-------------------------Search Product---------------------------------
//----------------------------------------------------------------------

function searchProduct() {
    
    let query = document.querySelector('#searchInput').value
    let url = '/pagination/fetch/search/' + query

    $.ajax({
        type: 'get',
        url: url,
        beforeSend: function (objeto) {
            
        },
        success: function(data) {
            document.getElementById('products').innerHTML = data
        },
        error: function(xhr, textStatus, errorMessage){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                text: 'Error en el servidor: ' + xhr.responseJSON.message,
                showConfirmButton: false,
            });
        }
    })
}

