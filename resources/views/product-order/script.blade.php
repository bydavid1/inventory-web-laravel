<script>
const TABLE = "#productTable"
const PRICE = "#price"
const PRODUCTNAME = "#pname"
const PRODUCTCODE = "#pcode"
const QUANTITY = "#quantity"
const AMOUNT = "#amount"
const TOTAL = "#total"
const PRICEVALUE = "#pricevalue"
const PRODUCTNAMEVALUE = "#pnamevalue"
const PRODUCTCODEVALUE = "#pcodevalue"
const QUANTITYVALUE = "#quantityvalue"
const AMOUNTVALUE = "#amountvalue"
const TOTALVALUE = "#totalvalue"
const IDVALUE = "#idvalue"

//Alert
const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: true,
      timer: 3000
    });

$(document).ready(function () {

    var typingTimer; 
    var doneTypingInterval = 200;

    $('#searchInput').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(searchProduct, doneTypingInterval);
    });

    $('#costumer').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(searchCostumer, doneTypingInterval);
    });
});

//----------------------------------------------------------------------
//-------------------------Add to table---------------------------------
//----------------------------------------------------------------------
function add(id) {

    let tableLength = $(TABLE + " tbody tr").length;
    let tableRow, arrayNumber, count;
    let tr = '';
    let quantity = document.querySelector("#cantidad_" + id).value
    let price = document.querySelector("#precio_venta_" + id).value

    if (tableLength > 0) {
        tableRow = $(TABLE + " tbody tr:last").attr('id')
        arrayNumber = $(TABLE + " tbody tr:last").attr('class')
        count = tableRow.substring(3)
        count = Number(count) + 1
        arrayNumber = Number(arrayNumber) + 1
    } else {
        count = 1
        arrayNumber = 0
    }

    let url = "{{ url('api/products/order', 'id') }}".replace("id", id)

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function (objeto) {

        },
        statusCode: {
            200: function (response) {
                //get data object fron json
                let data = response.data;

                price = Number(price).toFixed(2)
                let amount = price * 0.13
                let total = ((Number(price) + amount) * Number(quantity)).toFixed(2);


                tr = `<tr id="row${count}" class="${arrayNumber}">
                        <input type="hidden" name="idvalue${count}" id="idvalue${count}" value="` + data[0].id + `"/>
                        <td>
                            <input type="text" name="pcode${count}" id="pcode${count}" value="` + data[0].code + `" class="invoice-control"
                                autocomplete="ñokiero:v" onchange="getProductData(${count})" placeholder="Ingrese un codigo" />
                                <div class="icon-container d-none" id="loader${count}">
                                    <i class="loader"></i>
                                </div>
                            <input type="hidden" name="pcodevalue${count}" id="pcodevalue${count}" value="` + data[0].code + `"/>
                        </td>
                        <td>
                            <input type="text" name="pname${count}" id="pname${count}" value="` + data[0].name + `" class="invoice-control"
                                autocomplete="off" disabled />
                            <input type="hidden" name="pnamevalue${count}" id="pnamevalue${count}" value="` + data[0].name + `"/>
                        </td>
                        <td>
                            <input type="number" name="quantity${count}" id="quantity${count}" value="${quantity}" class="invoice-control"
                                autocomplete="off" min='1' onchange="setToValues(${count})"/>
                            <input type="hidden" name="quantityvalue${count}" id="quantityvalue${count}" value="${quantity}"/>
                        </td>
                        <td>
                            <input type="decimal" name="price${count}" id="price${count}" value="${price}" class="invoice-control"
                                autocomplete="off" step='0.01' min='0' onchange="setToValues(${count})"/>
                            <input type="hidden" name="pricevalue${count}" id="pricevalue${count}" value="${price}"/>
                        </td>
                        <td>
                            <input type="text" value="13%" disabled="true" class="invoice-control" />
                        </td>
                        <td>
                            <input type="decimal" name="amount${count}" id="amount${count}" class="invoice-control"
                                autocomplete="off" step='0.01' min='0' disabled value="${amount}"/>
                            <input type="hidden" name="amountvalue${count}" id="amountvalue${count}" value="${amount}"/>
                        </td>
                        <td>
                            <input type="decimal" name="total${count}" id="total${count}" value="${total}" class="invoice-control"
                                autocomplete="off" step='0.01' min='0'/>
                            <input type="hidden" name="totalvalue${count}" id="totalvalue${count}" value="${total}"/>
                        </td>
                        <td class="text-center">
                            <a class="btn" onclick="removeProductRow(${count})"><i class="fa fa-trash text-primary"></i></a>
                        </td>
                    </tr>`;

                if (tableLength > 1) {
                    $(TABLE + " tbody tr:last").after(tr);
                } else if (tableLength == 1 && $(PRODUCTNAME + 1).val() == "") {
                    document.querySelector(PRODUCTCODE + 1).value = data[0].code
                    document.querySelector(PRODUCTCODEVALUE + 1).value = data[0].code
                    document.querySelector(PRODUCTNAME + 1).value = data[0].name
                    document.querySelector(PRODUCTNAMEVALUE + 1).value = data[0].name
                    document.querySelector(PRICE + 1).value = price
                    document.querySelector(PRICEVALUE + 1).value = price
                    document.querySelector(QUANTITY + 1).value = quantity;
                    document.querySelector(QUANTITYVALUE + 1).value = quantity
                    document.querySelector(AMOUNT + 1).value = amount
                    document.querySelector(AMOUNTVALUE + 1).value = amount
                    document.querySelector(TOTAL + 1).value = total
                    document.querySelector(TOTALVALUE + 1).value = total
                    document.querySelector(IDVALUE + 1).value = data[0].id
                    document.querySelector(PRICE + 1).disabled = false
                    document.querySelector(QUANTITY + 1).disabled = false
                } else {
                    $(TABLE + " tbody").append(tr);
                }

                calculateProductsValues();
                countRow();
            },
            204: function () {

            },
            500: function () {

            }
        }
    })

}

//----------------------------------------------------------------------
//-------------------------Code info product---------------------------------
//----------------------------------------------------------------------

function getProductData(row){
    var url = "{{ url('api/products/order/code', 'identify') }}";
    var code = $(PRODUCTCODE + row).val();
    url = url.replace("identify", code);

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function (objeto) {
            document.getElementById('loader' + row).classList.add('d-block');
        },
        statusCode: {
            200: function (response) {
                if (response.success == true) {
                    let data = response.product;
                    console.log(data)
                    //Hide Loader
                    document.getElementById('loader' + row).classList.remove('d-block');

                    //Set DOM
                    document.querySelector(PRODUCTCODEVALUE + row).value = data.code
                    document.querySelector(PRODUCTNAME + row).value = data.name
                    document.querySelector(PRODUCTNAMEVALUE + row).value = data.name
                    document.querySelector(PRICE + row).value = data.first_price.price
                    document.querySelector(PRICEVALUE + row).value = data.first_price.price
                    document.querySelector(QUANTITY + row).value = 1;
                    document.querySelector(QUANTITYVALUE + row).value = 1
                    document.querySelector(IDVALUE + row).value = data.id
                    document.querySelector(PRICE + row).disabled = false
                    document.querySelector(QUANTITY + row).disabled = false

                    unitValues(row);
                    countRow();
                }else{
                    Toast.fire({
                    type: 'warning',
                    title: 'No existe un producto con ese codigo'
                })
                }
            },
            404: function () {
                document.getElementById('loader' + row).classList.remove('d-block');
                Toast.fire({
                    type: 'error',
                    title: 'No encontrado'
                })
            },
            500: function () {
                document.getElementById('loader' + row).classList.remove('d-block');
                Toast.fire({
                    type: 'warning',
                    title: ' Error en el servidor.'
               })
            }
        }
    })
}

//----------------------------------------------------------------------
//-------------------------Open info product---------------------------------
//----------------------------------------------------------------------

function view(id) {
    var url = "{{ route('showProduct', 'id') }}".replace('id', id);
    window.open(url, '_blank');
}

//----------------------------------------------------------------------
//-------------------------Add row to table---------------------------------
//----------------------------------------------------------------------

function addRow() {
    $("#addRowBtn").button("loading");

    var tableLength = $(TABLE + " tbody tr").length;

    var tableRow;
    var arrayNumber;
    var count;

    if (tableLength > 0) {
        tableRow = $(TABLE + " tbody tr:last").attr('id');
        arrayNumber = $(TABLE + " tbody tr:last").attr('class');
        count = tableRow.substring(3);
        count = Number(count) + 1;
        arrayNumber = Number(arrayNumber) + 1;
    } else {
        // no table row
        count = 1;
        arrayNumber = 0;
    }

    $("#addRowBtn").button("reset");

    var tr = `<tr id="row${count}" class="${arrayNumber}">
                <input type="hidden" name="idvalue${count}" id="idvalue${count}"/>
                <td>
                    <input type="text" name="pcode${count}" id="pcode${count}" class="invoice-control"
                        autocomplete="ñokiero:v" onchange="getProductData(${count})" placeholder="Ingrese un codigo" />
                        <div class="icon-container d-none" id="loader${count}">
                            <i class="loader"></i>
                         </div>
                    <input type="hidden" name="pcodevalue${count}" id="pcodevalue${count}"/>
                </td>
                <td>
                    <input type="text" name="pname${count}" id="pname${count}" class="invoice-control"
                        autocomplete="off" disabled />
                    <input type="hidden" name="pnamevalue${count}" id="pnamevalue${count}"/>
                </td>
                <td>
                    <input type="number" name="quantity${count}" id="quantity${count}" class="invoice-control"
                    autocomplete="off" min='1' onchange="setToValues(${count})" disabled />
                    <input type="hidden" name="quantityvalue${count}" id="quantityvalue${count}"/>
                </td>
                <td>
                    <input type="decimal" name="price${count}" id="price${count}" class="invoice-control"
                        autocomplete="off" step='0.01' min='0' onchange="setToValues(${count})" disabled />
                    <input type="hidden" name="pricevalue${count}" id="pricevalue${count}"/>
                </td>
                <td>
                    <input type="text" value="13%" disabled="true" class="invoice-control" />
                </td>
                <td>
                    <input type="decimal" name="amount${count}" id="amount${count}" class="invoice-control"
                        autocomplete="off" step='0.01' min='0' disabled />
                    <input type="hidden" name="amountvalue${count}" id="amountvalue${count}"/>
                </td>
                <td>
                    <input type="decimal" name="total${count}" id="total${count}" class="invoice-control"
                        autocomplete="off" step='0.01' min='0' disabled="true" />
                    <input type="hidden" name="totalvalue${count}" id="totalvalue${count}"/>
                </td>
                <td class="text-center">
                    <a class="btn" onclick="removeProductRow(${count})"><i class="fa fa-trash text-primary"></i></a>
                </td>
             </tr>`;
    if (tableLength > 0) {
        $(TABLE + " tbody tr:last").after(tr);
    } else {
        $(TABLE + " tbody").append(tr);
    }
    countRow();
}

//----------------------------------------------------------------------
//-------------------------Remove row to table---------------------------------
//----------------------------------------------------------------------

function removeProductRow(row = null) {
    if (row) {
        $("#row" + row).remove();

    } else {
        alert('error! Refresh the page again');
    }
    countRow();
}

function changeprice(id, value) {
    $("#precio_venta_" + id).val(value.toFixed(2));
}

function countRow(){
    var tableLength = $(TABLE + " tbody tr").length;
    $("#trCount").val(tableLength);
}



//----------------------------------------------------------------------
//-------------------------Triggers---------------------------------
//----------------------------------------------------------------------
document.getElementById('discount').addEventListener('input', function(){
    document.getElementById('discounts').textContent = "$" + Number(this.value).toFixed(2);
    document.getElementById('discountsvalue').value = Number(this.value).toFixed(2);
    calculateTotals();
});

//----------------------------------------------------------------------
//-------------------------Set data to values---------------------------------
//----------------------------------------------------------------------
function setToValues(row) {
    //Change to JS Vanilla
    $(PRICEVALUE + row).val($(PRICE + row).val());
    $(QUANTITYVALUE + row).val($(QUANTITY + row).val());

    unitValues(row);
}

//----------------------------------------------------------------------
//-------------------------Calc values on change data---------------------------------
//----------------------------------------------------------------------
function unitValues(row) {
    //Change to JS Vanilla
    let price = Number(document.querySelector(PRICEVALUE + row).value)
    let quantity = Number(document.querySelector(QUANTITYVALUE + row).value)

    let amount = (price * 0.13).toFixed(2)
    let total = ((price + Number(amount)) * quantity).toFixed(2)

    document.querySelector(AMOUNTVALUE + row).value = amount
    document.querySelector(AMOUNT + row).value = amount
    document.querySelector(TOTALVALUE + row).value = total
    document.querySelector(TOTAL + row).value = total

    calculateProductsValues()
}

//----------------------------------------------------------------------
//-------------------------Calc totals rows---------------------------------
//----------------------------------------------------------------------
function calculateProductsValues(){
    let tableProductLength = $(TABLE + " tbody tr").length;
    let grandsubtotal = 0
    let grandquantity = 0
    let taxvalue = 0

    for (x = 0; x < tableProductLength; x++) {
        let tr = $(TABLE + " tbody tr")[x]
        let count = $(tr).attr('id').substring(3)

        grandsubtotal += Number(document.querySelector(TOTALVALUE + count).value)
        grandquantity += Number(document.querySelector(QUANTITYVALUE + count).value)
        taxvalue += Number(document.querySelector(AMOUNTVALUE + count).value)

    }

    document.getElementById('subtotal').textContent = "$" + grandsubtotal.toFixed(2)
    document.getElementById('subtotalvalue').value = grandsubtotal.toFixed(2)
    document.getElementById('grandquantity').textContent = grandquantity + " items"
    document.getElementById('grandquantityvalue').value = grandquantity
    document.getElementById('taxvalue').value = taxvalue.toFixed(2)
    document.getElementById('tax').textContent = "$" + taxvalue.toFixed(2)

    calculateTotals()
}

//----------------------------------------------------------------------
//-------------------------Calc total values---------------------------------
//----------------------------------------------------------------------

function calculateTotals() {
    let subtotalvalueInput = document.getElementById('subtotalvalue');
    let discountvalueInput = document.getElementById('discountsvalue');

    //let taxvalueInput = document.getElementById('taxvalue'); --- don't add the value again

    let total = (Number(subtotalvalueInput.value) - Number(discountvalueInput.value)  + Number(document.getElementById('interestvalue').value) ).toFixed(2);

    document.getElementById('grandtotal').textContent = "$" + total;
    document.getElementById('grandtotalvalue').value = total;

    if (document.getElementById('payment').value == 2) {
        calculateInterest();
    }
}

//----------------------------------------------------------------------
//-------------------------Hide/Show Additional Options---------------------------------
//----------------------------------------------------------------------

function moptions(){
    let value = document.getElementById('payment').value;

    if (value == 2) {
        document.getElementById('creditinfo').classList.add('d-block');
        document.getElementById('grandinterest').classList.add('d-flex');

        document.getElementById('interestper').addEventListener('input', calculateTotals);

        document.getElementById('numfees').addEventListener('input', calculateTotals);

    }else{
        document.getElementById('creditinfo').classList.remove('d-block');
        document.getElementById('grandinterest').classList.remove('d-flex');
    }
}

//----------------------------------------------------------------------
//-------------------------Calculate Interest---------------------------------
//----------------------------------------------------------------------

function calculateInterest(){
   let interest = Number(document.getElementById('interestper').value);
   let numfees = Number(document.getElementById('numfees').value);
   let total = Number(document.getElementById('grandtotalvalue').value);
   let percent = interest / 100;

   let result = total * percent * numfees;
   let grandtotal = total + result;

   grandtotal = grandtotal.toFixed(2);
   result = result.toFixed(2);

   document.getElementById('interest').textContent = "$" + result;
   document.getElementById('interestvalue').value = result;

   document.getElementById('grandtotalvalue').value = grandtotal;
   document.getElementById('grandtotal').textContent = "$" + grandtotal;
}

//----------------------------------------------------------------------
//-------------------------Search Product---------------------------------
//----------------------------------------------------------------------

function searchProduct() {

let query = document.querySelector('#searchInput').value
let url = "{{ url('api/products/order/search', 'query') }}".replace("query", query)

$.ajax({
    type: 'get',
    url: url,
    dataType: 'json',
    beforeSend: function (objeto) {
        $("#results").html(`<div class="d-flex justify-content-center mt-4"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>`);
    },
    statusCode: {
        200: function (response) {
            if (response.success == true) {
                const data = response.products
                const length = data.length
                let output = ""
                for (let i = 0; i < length; i++) {
                    const id = data[i].id
                    let prices = ""
                    for (let j = 0; j < 4; j++) {
                        const price = data[i].prices[j].price_incl_tax
                        prices += `<li class="dropdown-item" onclick="changeprice(${id}, ${price})">$${price.toFixed(2)}</li>`
                    }
                    
                    output += `<div class="row mb-2">
                        <div class="col-sm-2"><img class="img-round" src="{{ asset("`+data[i].images[0].src+`") }}"
                                style="max-height:50px; max-width:70px;" /></div>
                        <div class="col-sm-2 my-auto">${data[i].code}</div>
                        <div class="col-sm-3 my-auto">${data[i].name}</div>
                        <div class="col-sm-2 my-auto">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend"><span class="input-group-text">En stock: ${data[i].stock}</span></div>
                                    <input type="text" class="form-control" value="1" id="cantidad_${id}"/>
                            </div>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">  
                                    </button>
                                    <ul class="dropdown-menu">
                                        ${prices}
                                    </ul>
                                </div><input type="text" class="form-control" value="${data[i].prices[0].price_incl_tax.toFixed(2)}"
                                    id="precio_venta_${id}" />
                            </div>
                        </div>
                        <div class="col-sm-1 my-auto btn-group float-center">
                            <button class="btn btn-primary btn-sm mr-1" onclick="add(${id})"><i
                                    class="fas fa-plus"></i></button>
                            <button class="btn btn-secondary btn-sm mr-1" onclick="view(${id})"><i
                                    class="fas fa-external-link-alt"></i></button>
                        </div>
                    </div>`
                }
                $("#results").html(output)
            }else{
                $("#results").html(`No hay productos que coincidan`)
            }
        },
        404: function () {
            $("#results").html(`Recurso no encontrado`)
        },
        500: function () {
            $("#results").html(`<div class="alert alert-danger mt-2">Ocurrió un problema en el servidor, intentelo despues</div>`)
        }
    }
})
}

//----------------------------------------------------------------------
//-------------------------Search Costumer---------------------------------
//----------------------------------------------------------------------

function searchCostumer() {
    closeAllLists();
    let input = document.getElementById('costumer');
    let container, items;
        container = document.createElement("DIV");
        container.setAttribute("class", "autocomplete-items");
        input.parentNode.appendChild(container);

        document.addEventListener('click', function(){
            closeAllLists();
        });

    let url = "{{ url('api/costumers/search', 'query') }}";
    url = url.replace("query", input.value);
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function (objeto) {
            container.innerHTML = `<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>`;
        },
        statusCode: {
            200: function (response) {
                container.innerHTML = "";
                if (response.success == true) {
                    let data = response.data;
                    for (let i = 0; i < data.length; i++) {
                        items = document.createElement("DIV");
                        items.innerHTML = data[i].name;
                        items.addEventListener("click", function(e){
                            input.value = data[i].name;
                            document.getElementById('costumerid').value = data[i].id;
                            closeAllLists();
                        });
                        container.appendChild(items);
                    }
         
                }else{
                    container.innerHTML = `<div>No hay clientes que coincidan</div>`;
                }
            },
            404: function () {
                container.innerHTML = `Recurso no encontrado`;
            },
            500: function () {
                container.innerHTML = `Ocurrió un problema en el servidor`;
            }
        }
    })
}

function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
        x[i].parentNode.removeChild(x[i]);
    }
}


</script>