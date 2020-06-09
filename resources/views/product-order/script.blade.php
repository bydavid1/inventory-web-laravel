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
const Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: true,
      timer: 3000
    });

$(document).ready(function () {
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
                   <div class="form-group col-sm-12">
                   <input type="text" name="pcode` + count + `" id="pcode` + count + `" autocomplete="off" value="` + data[0].code + `" class="form-control" onchange="getProductData(` + count + `)"/>
                   <input type="hidden" name="pcodevalue` + count + `" id="pcodevalue`  + count + `" value="` + data[0].code + `"/>
                   </div>
                   </td>
                   <td>
                   <div class="form-group col-sm-12">
                   <input type="text" name="pname` + count + `" id="pname` + count + `" value="` + data[0].name + `" autocomplete="off" class="form-control" disabled />
                   <input type="hidden" name="pnamevalue` + count + `" id="pnamevalue` + count + `" value="` + data[0].name + `"/>
                   </div>
                   </td>
                   <td>
                    ' <div class="input-group col-sm-12">
                   <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                   <input type="number" name="price` + count + `" id="price` + count + `" autocomplete="off" value="` + pricevalue + `"  class="form-control" step="0.01"  min="0" onchange="totalValue(` + count + `)" />
                   <input type="hidden" name="pricevalue` + count + `" id="pricevalue` + count + `" value="` + pricevalue + `"/>
                   </div>
                   </td>
                   <td>
                   <div class="form-group col-sm-12">
                   <input type="number" name="quantity` + count + `" id="quantity` + count + `" autocomplete="off" value="` + quantityvalue + `" class="form-control" min="1" onchange="totalValue(` + count + `)" />
                   <input type="hidden" name="quantityvalue` + count + `" id="quantityvalue` + count + `" value="` + quantityvalue + `"/>
                   </div>
                   </td>
                   <td>
                   <div class="form-group col-sm-12">
                   <input type="text" value="13%" class ="form-control" disabled="true"/>
                   </div>
                   </td>
                   <td>
                    ' <div class="input-group col-sm-12">
                   <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                   <input type="text" name="total` + count + `" id="total` + count + `" autocomplete="off" value="` + pricevalue + `" class="form-control" step="0.01"  min="0" disabled="true" />
                   <input type="hidden" name="totalvalue` + count + `" id="totalvalue` + count + `" value="` + pricevalue + `"/>
                   </div>
                   </td>
                   <td>
                   <button class="btn btn-primary" type="button" onclick="removeProductRow(` + count + `)"><i class="fa fa-trash"></i></button>
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

                subAmount();
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

                subAmount();
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
    $("#grandtotal").val(total);
    $("#grandtotalvalue").val(total);


    $("#grandquantity").val(quantity);
    $("#grandquantityvalue").val(quantity);
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
       <div class="form-group col-sm-12">
       <input type="text" name="pcode` + count + `" id="pcode` + count + `" autocomplete="off" class="form-control" onchange="getProductData(` + count + `)"/>
       <input type="hidden" name="pcodevalue` + count + `" id="pcodevalue` + count + `"/>
       </div>
       </td>
       <td>
       <div class="form-group col-sm-12">
       <input type="text" name="pname` + count + `" id="pname` + count + `" autocomplete="off" class="form-control" disabled />
       <input type="hidden" name="pnamevalue` + count + `" id="pnamevalue` + count + `"/>
       </div>
       </td>
       <td>
       <div class="input-group col-sm-12">
       <div class="input-group-prepend"><span class="input-group-text">$</span></div>
       <input type="number" name="price` + count + `" id="price` + count + `" autocomplete="off" disabled class="form-control" step="0.01"  min="0" onchange="totalValue(` + count + `)" />
       <input type="hidden" name="pricevalue` + count + `" id="pricevalue` + count + `"/>
       </div>
       </td>
       <td>
       <div class="form-group col-sm-12">
       <input type="number" name="quantity` + count + `" id="quantity` + count + `" autocomplete="off" disabled class="form-control" min="1" onchange="totalValue(` + count + `)" />
       <input type="hidden" name="quantityvalue` + count + `" id="quantityvalue` + count + `"/>
       </div>
       </td>
       <td>
       <div class="form-group col-sm-12">
       <input type="text" value="13%" class ="form-control" disabled="true"/>
       </div>
       </td>
       <td>
       <div class="input-group col-sm-12">
       <div class="input-group-prepend"><span class="input-group-text">$</span></div>
       <input type="text" name="total` + count + `" id="total` + count + `" autocomplete="off" class="form-control" step="0.01"  min="0" disabled="true" />
       <input type="hidden" name="totalvalue` + count + `" id="totalvalue` + count + `"/>
       </div>
       </td>
       <td>
       <button class="btn btn-primary" type="button" onclick="removeProductRow(` + count + `)"><i class="fa fa-trash"></i></button>
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
//-------------------------Calc values on change data---------------------------------
//----------------------------------------------------------------------
function totalValue(row = null) {
    var rate = Number($(PRICE + row).val());
    var quantity = Number($(QUANTITY + row).val());
    $(QUANTITYVALUE).val(quantity);

    total = rate * quantity;
    total = total.toFixed(2);

    $(TOTAL + row).val(total);
    $(TOTALVALUE + row).val(total);

    subAmount();
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
                    <div class="col-sm-2"><img class="img-round" src="{{ asset("` + data[i].image + `") }}" style="max-height:50px; max-width:70px;"/></div>
                    <div class="col-sm-2 my-auto">` + data[i].code + `</div>
                    <div class="col-sm-3 my-auto">` + data[i].name + `</div>
                    <div class="col-sm-2 my-auto">` + data[i].quantity + `</div>
                    <div class="col-sm-2 my-auto">` + data[i].price1 + `</div>
                    <div class="col-sm-1 my-auto"><button class="btn btn-primary btn-sm mr-1" onclick="add(` + data[i].id + `)"><i class="fas fa-plus"></i>Agregar</button></div>
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

</script>