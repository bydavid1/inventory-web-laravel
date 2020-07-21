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
        var pricevalue = Number(document.querySelector('#purchase').value).toFixed(2)
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
    let tableProductLength = $(Table + " tbody tr").length;
    let total = 0;
    let quantity = 0;
    for (x = 0; x < tableProductLength; x++) {
        let tr = $(Table + " tbody tr")[x];
        let count = $(tr).attr('id').substring(3);

        total = (Number(total) + Number(document.querySelector(TOTALVALUE + count).value)).toFixed(2);
        quantity = Number(quantity) + Number(document.querySelector(QUANTITYVALUE + count).value);
    }

    document.getElementById('grandtotal').textContent = total
    document.getElementById('grandtotalvalue').value = total

    document.getElementById('grandquantity').textContent = quantity
    document.getElementById('grandquantityvalue').value = quantity
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

    $("#trCount").val(tableLength);
}