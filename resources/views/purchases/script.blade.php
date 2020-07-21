<script>
const Table = "#productTable";
const PRICEVALUE = "#pricevalue";
const PRODUCTNAMEVALUE = "#pnamevalue";
const PRODUCTCODEVALUE = "#pcodevalue";
const QUANTITYVALUE = "#quantityvalue";
const TOTALVALUE = "#totalvalue";

$(document).ready(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    //setup before functions
    var typingTimer; //timer identifier
    var doneTypingInterval = 500;

    //on keyup, start the countdown
    $('#searchInput').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(searchProduct, doneTypingInterval);
    });

});

//----------------------------------------------------------------------
//-------------------------Add new product---------------------------------
//----------------------------------------------------------------------


function addNewProduct() {
    let name = document.querySelector('#pname').value
    let code = document.querySelector('#pcode').value 
    let quantity = document.querySelector('#pquantity').value  
    let purchase = document.querySelector('#ppurchase').value 
    let price = document.querySelector('#price').value
    let category = document.querySelector('#category')
    let provider = document.querySelector('#pprovider')
    if (name == "" || code == "" || quantity == "" || purchase == "" || price == "") {
        Swal.fire({
            type: 'error',
            title: 'Faltan datos importantes',
        });
    } else {
        let tableLength = $(Table + " tbody tr").length;
        let tableRow;
        let arrayNumber;
        let count;
        let tr = '';
        let total = quantity * purchase;

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

        tr = `<tr id="row${count}" class="${arrayNumber}">
                <input type="hidden" name="provider${count}" id="provider${count}" value="${provider}"/>
                <input type="hidden" name="category${count}" id="category${count}" value="${category}"/>
                <input type="hidden" name="price${count}" id="price${count}" value="${price}"/>
                <td>
                ${code}
                <input type="hidden" name="pcodevalue${count}" id="pcodevalue${count}" value="${code}"/>
                </td>
                <td>
                ${name}
                <input type="hidden" name="pnamevalue${count}" id="pnamevalue${count}" value="${name}"/>
                </td>
                <td>
                <small class="badge badge-primary">Nuevo</small>
                <input type="hidden" name="status${count}" id="status${count}" value="nuevo"/>
                </td>
                <td>
                $${purchase}
                <input type="hidden" name="purchasevalue${count}" id="purchasevalue${count}" value="${purchase}"/>
                </td>
                <td>
                ${quantity}
                <input type="hidden" name="quantityvalue${count}" id="quantityvalue${count}" value="${quantity}"/>
                </td>
                <td>
                $${total}
                <input type="hidden" name="totalvalue${count}" id="totalvalue${count}" value="${total}"/>
                </td>
                <td>
                <a onclick="removeProductRow(${count})"><i class="fa fa-trash"></i></a>
                </td>
                </tr>`;

        if (tableLength > 1) {
            $(Table + " tbody tr:last").after(tr);
        } else {
            $(Table + " tbody").append(tr);
        }

        subAmount();
        countRow();
        $('#newProductForm').trigger("reset");
    }
}

//----------------------------------------------------------------------
//-------------------------Add listing product---------------------------------
//----------------------------------------------------------------------


function add(id) {
    $('#setInfo').modal('show');

    $('#AddProduct').click(function () {
        let tableLength = $(Table + " tbody tr").length;
        let tableRow, arrayNumber, count;
        var tr = '';
        var quantityvalue = document.querySelector('#quantity').value
        var pricevalue = (document.querySelector('#purchase').value).toFixed(2)
        var total = pricevalue * quantityvalue;

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

        var url = "{{ url('api/products/order', 'id') }}".replace("id", id);

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            beforeSend: function (objeto) {

            },
            statusCode: {
                200: function (response) {
                    var data = response.data;
                    //Row
                    tr = `<tr id="row${count}" class="${arrayNumber}">
                        <input type="hidden" name="idvalue${count}" id="idvalue${count}" value="${data[0].id}"/>
                        <td>
                        ${data[0].code}
                        <input type="hidden" name="pcodevalue${count}" id="pcodevalue${count}" value="${data[0].code}"/>
                        </td>
                        <td>
                        ${data[0].name}
                        <input type="hidden" name="pnamevalue${count}" id="pnamevalue${count}" value="${data[0].name}"/>
                        </td>
                        <td>
                        <small class="badge badge-danger">Existente</small>
                        <input type="hidden" name="status${count}" id="status${count}" value="existente"/>
                        </td>
                        <td>
                        $${pricevalue}
                        <input type="hidden" name="purchasevalue${count}" id="purchasevalue${count}" value="${pricevalue}"/>
                        </td>
                        <td>
                        ${quantityvalue}
                        <input type="hidden" name="quantityvalue${count}" id="quantityvalue${count}" value="${quantityvalue}"/>
                        </td>
                        <td>
                        $${total}
                        <input type="hidden" name="totalvalue${count}" id="totalvalue${count}" value="${total}"/>
                        </td>
                        <td>
                        <a onclick="removeProductRow(${count})"><i class="fa fa-trash"></i></a>
                        </td>
                        </tr>`;

                    if (tableLength > 1) {
                        $(Table + " tbody tr:last").after(tr);
                    } else {
                        $(Table + " tbody").append(tr);
                    }

                    subAmount();
                    countRow();
                    $('#setInfo').modal('hide');
                    $("#quantity").val("");
                    $("#purchase").val("");
                },
                204: function () {

                },
                500: function () {

                }
            }
        })
    })
}

//----------------------------------------------------------------------
//-------------------------Calc total values---------------------------------
//----------------------------------------------------------------------

function subAmount() {
    var tableProductLength = $(Table + " tbody tr").length;
    var total = 0;
    var quantity = 0;
    for (x = 0; x < tableProductLength; x++) {
        var tr = $(Table + " tbody tr")[x];
        var count = $(tr).attr('id');
        count = count.substring(3);

        total = Number(total) + Number($(TOTALVALUE + count).val());
        quantity = Number(quantity) + Number($(QUANTITYVALUE + count).val());
    }


    total = total.toFixed(2);
    $("#grandtotal").text(total);
    $("#grandtotalvalue").val(total);


    $("#grandquantity").text(quantity);
    $("#grandquantityvalue").val(quantity);
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
    subAmount();
}

//----------------------------------------------------------------------
//-------------------------Count rows table---------------------------------
//----------------------------------------------------------------------

function countRow() {
    var tableLength = $(Table + " tbody tr").length;
    console.log(tableLength);
    $("#trCount").val(tableLength);
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
                    let outputitems = ''
                    for (let i = 0; i < length; i++) {
                        const id = data[i].id
                        let prices = ""
                        for (let j = 0; j < 4; j++) {
                            const price = data[i].prices[j].price_incl_tax
                            prices += `<li class="dropdown-item" onclick="changeprice(${id}, ${price})">$${price.toFixed(2)}</li>`
                        }
                        
                        outputitems += `
                            <tr>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="collapse(${i})"> 
                                        <i class="fa fa-plus" id="collapse_icon_${i}"></i>
                                    </button>
                                </td>
                                <td>${data[i].code}</td>
                                <td>${data[i].name}</td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">${data[i].stock}</span>
                                        </div>
                                        <input type="text" class="form-control" value="1" id="cantidad_${id}"/>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-primary"
                                                data-toggle="dropdown"> 
                                                <i class="fa  fa-angle-down"></i> 
                                            </button>
                                            <ul class="dropdown-menu">
                                                ${prices}
                                            </ul>
                                        </div>
                                        <input type="text" class="form-control" value="${data[i].prices[0].price_incl_tax.toFixed(2)}" id="precio_venta_${id}" />
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-1 my-auto btn-group btn-group-sm float-center">
                                        <button class="btn btn-primary" onclick="add(${id})"><i
                                                class="fa fa-plus"></i></button>
                                        <button class="btn btn-secondary" onclick="view(${id})"><i
                                                class="fa fa-external-link"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="collapse" id="ex_row_${i}">
                                <td colspan="6">
                                    <img class="img-round" src="{{ asset("`+data[i].images[0].src+`") }}" style="max-height:50px; max-width:70px;" />
                                </td>
                            </tr>`
                    }

                    let output = `  
                        <table class="table table-sm table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 1%;"></th>
                                    <th style="width: 20%;">Codigo</th>
                                    <th style="width: 30%;">Producto</th>
                                    <th style="width: 20%;">Stock</th>
                                    <th style="width: 20%;">Precios</th>
                                    <th style="width: 9%;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>  
                                ${outputitems}
                            </tbody>
                        </table>`;

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
//-------------------------Expand button search product form---------------------------------
//----------------------------------------------------------------------
function collapse(number){
    let row = document.getElementById('ex_row_' + number)
    let icon = document.getElementById('collapse_icon_' + number)

    if(row.classList.contains('collapse')){
        row.classList.remove('collapse')
        icon.classList.remove('fa-plus')
        icon.classList.add('fa-minus')
    }else{
        row.classList.add('collapse')
        icon.classList.remove('fa-minus')
        icon.classList.add('fa-plus')
    }
}
</script>