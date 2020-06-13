<script>
const Table = "#productTable";
const PRICE = "#price";
const PRODUCTNAME = "#pname";
const PRODUCTCODE = "#pcode";
const QUANTITY = "#quantity";
const TOTAL = "#total";
const PRICEVALUE = "#pricevalue";
const PRODUCTNAMEVALUE = "#pnamevalue";
const PRODUCTCODEVALUE = "#pcodevalue";
const QUANTITYVALUE = "#quantityvalue";
const TOTALVALUE = "#totalvalue";
const IDVALUE = "#idvalue";

//Alert
const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: true,
      timer: 3000
    });

$(document).ready(function () {

    var typingTimer; 
    var doneTypingInterval = 400;

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

    var tableLength = $(Table + " tbody tr").length;
    var tableRow;
    var arrayNumber;
    var count;
    var tr = '';
    var quantityvalue = $("#cantidad_" + id).val();
    var pricevalue = $("#precio_venta_" + id).val();
    console.log(pricevalue);

    if (tableLength > 0) {
        tableRow = $(Table + " tbody tr:last").attr('id');
        arrayNumber = $(Table + " tbody tr:last").attr('class');
        count = tableRow.substring(3);
        count = Number(count) + 1;
        arrayNumber = Number(arrayNumber) + 1;
    } else {
        count = 1;
        arrayNumber = 0;
    }

    var url = "{{ url('api/products/order', 'id') }}";
    url = url.replace("id", id);

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function (objeto) {

        },
        statusCode: {
            200: function (response) {
                var data = response.data;
                pricevalue = parseFloat(pricevalue);
                pricevalue = pricevalue.toFixed(2);
                tr = `<tr id="row` + count + `" class="` + arrayNumber + `">
                        <input type="hidden" name="idvalue` + count + `" id="idvalue` + count + `" value="` + data[0].id + `"/>
                        <td>
                            <input type="text" name="pcode` + count + `" id="pcode` + count + `" value="` + data[0].code + `" class="invoice-control"
                                autocomplete="off" onchange="getProductData(` + count + `)" placeholder="Ingrese un codigo" />
                            <input type="hidden" name="pcodevalue` + count + `" id="pcodevalue`  + count + `" value="` + data[0].code + `"/>
                        </td>
                        <td>
                            <input type="text" name="pname` + count + `" id="pname` + count + `" value="` + data[0].name + `" class="invoice-control"
                                autocomplete="off" disabled />
                            <input type="hidden" name="pnamevalue` + count + `" id="pnamevalue` + count + `" value="` + data[0].name + `"/>
                        </td>
                        <td>
                            <input type="number" name="price` + count + `" id="price` + count + `" value="` + pricevalue + `" class="invoice-control"
                                autocomplete="off" step='0.01' min='0' onchange="totalValue(` + count + `)" disabled />
                            <input type="hidden" name="pricevalue` + count + `" id="pricevalue` + count + `" value="` + pricevalue + `"/>
                        </td>
                        <td>
                            <input type="number" name="quantity` + count + `" id="quantity` + count + `" value="` + quantityvalue + `" class="invoice-control"
                            autocomplete="off" min='1' onchange="totalValue(` + count + `)" disabled />
                            <input type="hidden" name="quantityvalue` + count + `" id="quantityvalue` + count + `" value="` + quantityvalue + `"/>
                        </td>
                        <td>
                            <input type="text" value="13%" disabled="true" class="invoice-control" />
                        </td>
                        <td>
                            <input type="text" name="total` + count + `" id="total` + count + `" value="` + pricevalue + `" class="invoice-control"
                                autocomplete="off" step='0.01' min='0' disabled="true" />
                            <input type="hidden" name="totalvalue` + count + `" id="totalvalue` + count + `" value="` + pricevalue + `"/>
                        </td>
                        <td class="text-center">
                            <a class="btn" onclick="removeProductRow(` + count + `)"><i class="fa fa-trash text-primary"></i></a>
                        </td>
                    </tr>`;

                if (tableLength > 1) {
                    $(Table + " tbody tr:last").after(tr);
                } else if (tableLength == 1 && $(PRODUCTNAME + 1).val() == "") {
                    $(PRODUCTCODE + 1).val(data[0].code);
                    $(PRODUCTNAME + 1).val(data[0].name);
                    $(PRICE + 1).val(pricevalue);
                    $(QUANTITY + 1).val(quantityvalue);
                    $(TOTAL + 1).val(pricevalue);
                    $(PRODUCTCODEVALUE + 1).val(data[0].code);
                    $(PRODUCTNAMEVALUE + 1).val(data[0].name);
                    $(PRICEVALUE + 1).val(pricevalue);
                    $(QUANTITYVALUE + 1).val(quantityvalue);
                    $(TOTALVALUE + 1).val(pricevalue);
                    $(IDVALUE + 1).val(data[0].id );
                    $(PRICE + 1).prop('disabled', false);
                    $(QUANTITY + 1).prop('disabled', false);
                } else {
                    $(Table + " tbody").append(tr);
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
    console.log(code);
    url = url.replace("identify", code);

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function (objeto) {

        },
        statusCode: {
            200: function (response) {
                var data = response.data;

                    $(PRODUCTNAME + row).val(data[0].name);
                    $(PRICE + row).val(data[0].price);
                    $(PRODUCTNAMEVALUE + row).val(data[0].name);
                    $(PRICEVALUE + row).val(data[0].price);
                    $(PRICE + row).prop('disabled', false);
                    $(QUANTITY + row).prop('disabled', false);
                    $(QUANTITY + row).val(1);
                    $(QUANTITYVALUE + row).val(1);

                calculateProductsValues();
                countRow();
            },
            404: function () {
                Toast.fire({
        type: 'error',
        title: 'Producto no encontrado.'
         })
            },
            500: function () {
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
    var url = "{{ route('showProduct', 'id') }}";
    url = url.replace('id', id);
    window.open(url, '_blank');
}

//----------------------------------------------------------------------
//-------------------------Add row to table---------------------------------
//----------------------------------------------------------------------

function addRow() {
    $("#addRowBtn").button("loading");

    var tableLength = $(Table + " tbody tr").length;

    var tableRow;
    var arrayNumber;
    var count;

    if (tableLength > 0) {
        tableRow = $(Table + " tbody tr:last").attr('id');
        arrayNumber = $(Table + " tbody tr:last").attr('class');
        count = tableRow.substring(3);
        count = Number(count) + 1;
        arrayNumber = Number(arrayNumber) + 1;
    } else {
        // no table row
        count = 1;
        arrayNumber = 0;
    }

    $("#addRowBtn").button("reset");

    var tr = `<tr id="row` + count + `" class="` + arrayNumber + `">
                <input type="hidden" name="idvalue` + count + `" id="idvalue` + count + `"/>
                <td>
                    <input type="text" name="pcode` + count + `" id="pcode` + count + `" class="invoice-control"
                        autocomplete="off" onchange="getProductData(` + count + `)" placeholder="Ingrese un codigo" />
                    <input type="hidden" name="pcodevalue` + count + `" id="pcodevalue`  + count + `"/>
                </td>
                <td>
                    <input type="text" name="pname` + count + `" id="pname` + count + `" class="invoice-control"
                        autocomplete="off" disabled />
                    <input type="hidden" name="pnamevalue` + count + `" id="pnamevalue` + count + `"/>
                </td>
                <td>
                    <input type="number" name="price` + count + `" id="price` + count + `" class="invoice-control"
                        autocomplete="off" step='0.01' min='0' onchange="totalValue(` + count + `)" disabled />
                    <input type="hidden" name="pricevalue` + count + `" id="pricevalue` + count + `"/>
                </td>
                <td>
                    <input type="number" name="quantity` + count + `" id="quantity` + count + `" class="invoice-control"
                    autocomplete="off" min='1' onchange="totalValue(` + count + `)" disabled />
                    <input type="hidden" name="quantityvalue` + count + `" id="quantityvalue` + count + `"/>
                </td>
                <td>
                    <input type="text" value="13%" disabled="true" class="invoice-control" />
                </td>
                <td>
                    <input type="text" name="total` + count + `" id="total` + count + `" class="invoice-control"
                        autocomplete="off" step='0.01' min='0' disabled="true" />
                    <input type="hidden" name="totalvalue` + count + `" id="totalvalue` + count + `"/>
                </td>
                <td class="text-center">
                    <a class="btn" onclick="removeProductRow(` + count + `)"><i class="fa fa-trash text-primary"></i></a>
                </td>
             </tr>`;
    if (tableLength > 0) {
        $(Table + " tbody tr:last").after(tr);
    } else {
        $(Table + " tbody").append(tr);
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


//----------------------------------------------------------------------
//-------------------------Triggers---------------------------------
//----------------------------------------------------------------------
document.getElementById('discount').addEventListener('input', function(){
    document.getElementById('discounts').textContent = "$" + Number(this.value).toFixed(2);
    document.getElementById('discountsvalue').value = Number(this.value).toFixed(2);
    calculateTotals();
});

//----------------------------------------------------------------------
//-------------------------Calc values on change data---------------------------------
//----------------------------------------------------------------------
function totalValue(row = null) {
    let rate = Number($(PRICE + row).val());
    let quantity = Number($(QUANTITY + row).val());
    $(QUANTITYVALUE).val(quantity);

    total = rate * quantity;
    total = total.toFixed(2);

    $(TOTAL + row).val(total);
    $(TOTALVALUE + row).val(total);

    calculateProductsValues();
}

function calculateProductsValues(){
    let tableProductLength = $(Table + " tbody tr").length;
    let grandsubtotal = 0;
    let grandquantity = 0;
    for (x = 0; x < tableProductLength; x++) {
        let tr = $(Table + " tbody tr")[x];
        let count = $(tr).attr('id');
        count = count.substring(3);

        grandsubtotal = Number(grandsubtotal) + Number($(TOTALVALUE + count).val());
        grandquantity = Number(grandquantity) + Number($(QUANTITYVALUE + count).val());
    }

    grandsubtotal = grandsubtotal.toFixed(2);
    document.getElementById('subtotal').textContent = "$" + grandsubtotal;
    document.getElementById('subtotalvalue').value = grandsubtotal;
    document.getElementById('grandquantity').textContent = grandquantity + " items";
    document.getElementById('grandquantityvalue').value = grandquantity;

    calculateTotals()
}

//----------------------------------------------------------------------
//-------------------------Calc total values---------------------------------
//----------------------------------------------------------------------

function calculateTotals() {
    let subtotalvalueInput = document.getElementById('subtotalvalue');
    let discountvalueInput = document.getElementById('discountsvalue');

    let tax = subtotalvalueInput.value * 0.13;
    let taxvalueInput = document.getElementById('taxvalue');
    let taxInput = document.getElementById('tax');
    taxInput.textContent = "$" + tax.toFixed(2);
    taxvalueInput.value = tax.toFixed(2);

    let total = Number(subtotalvalueInput.value) - Number(discountvalueInput.value)  + tax;
    total = total.toFixed(2);
    document.getElementById('grandtotal').textContent = "$" + total;
    document.getElementById('grandtotalvalue').value = total;
}


function changeprice(id, value) {
    $("#precio_venta_" + id).val(value);
}

function countRow(){
    var tableLength = $(Table + " tbody tr").length;
    console.log(tableLength);
    $("#trCount").val(tableLength);
}

//----------------------------------------------------------------------
//-------------------------Search Product---------------------------------
//----------------------------------------------------------------------

function searchProduct() {

let query = $("#searchInput").val();
let url = "{{ url('api/products/order/search', 'query') }}";
url = url.replace("query", query);
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
                let data = response.products;
                let output = "";
                for (let i = 0; i < data.length; i++) {
                    output += `<div class="row mb-2">
                        <div class="col-sm-2"><img class="img-round" src="{{ asset("` + data[i].image + `") }}"
                                style="max-height:50px; max-width:70px;" /></div>
                        <div class="col-sm-2 my-auto">` + data[i].code + `</div>
                        <div class="col-sm-3 my-auto">` + data[i].name + `</div>
                        <div class="col-sm-2 my-auto">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">` + data[i].quantity + `</span></div>
                                    <input type="text" class="form-control" value="1" id="cantidad_` + data[i].id + `"/>
                            </div>
                        </div>
                        <div class="col-sm-2 my-auto">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">
                                        ` + data[i].price1 + `
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item" onclick="changeprice(` + data[i].id + `,` + data[i].price1 + `)">
                                            ` + data[i].price1 + `</li>
                                        <li class="dropdown-item" onclick="changeprice(` + data[i].id + `,` + data[i].price2 + `)">
                                            ` + data[i].price2 + `</li>
                                        <li class="dropdown-item" onclick="changeprice(` + data[i].id + `,` + data[i].price3 + `)">
                                            ` + data[i].price3 + `</li>
                                        <li class="dropdown-item" onclick="changeprice(` + data[i].id + `,` + data[i].price4 + `)">
                                            ` + data[i].price4 + `</li>
                                    </ul>
                                </div><input type="text" class="form-control" value="` + data[i].price1 + `"
                                    id="precio_venta_` + data[i].id + `" />
                            </div>
                        </div>
                        <div class="col-sm-1 my-auto btn-group float-center">
                            <button class="btn btn-primary btn-sm mr-1" onclick="add(` + data[i].id + `)"><i
                                    class="fas fa-plus"></i></button>
                            <button class="btn btn-secondary btn-sm mr-1" onclick="view(` + data[i].id + `)"><i
                                    class="fas fa-external-link-alt"></i></button>
                        </div>
                    </div>`;
                }
                $("#results").html(output);
            }else{
                $("#results").html(`No hay productos que coincidan`);
            }
        },
        404: function () {
            $("#results").html(`Recurso no encontrado`);
        },
        500: function () {
            $("#results").html(`<div class="alert alert-danger mt-2">Ocurrió un problema en el servidor, intentelo despues</div>`);
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