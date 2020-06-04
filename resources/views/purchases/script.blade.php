<script>
const Table = "#productTable";
const PRICEVALUE = "#pricevalue";
const PRODUCTNAMEVALUE = "#pnamevalue";
const PRODUCTCODEVALUE = "#pcodevalue";
const QUANTITYVALUE = "#quantityvalue";
const TOTALVALUE = "#totalvalue";

function addNewProduct() {
    let name = $('#pname').val();
    let code = $('#pcode').val();
    let quantity = $('#pquantity').val();
    let purchase = $('#ppurchase').val();
    let price = $('#price').val();
    let category = $('#category').val();
    let provider = $('#pprovider').val();
    if (name == "" || code == "" || quantity == "" || purchase == "" || price == "") {
        Swal.fire({
			type: 'error',
			title: 'Faltan datos importantes',
		   });
    }else{
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

        tr = `<tr id="row` + count + `" class="` + arrayNumber + `">
                <input type="hidden" name="provider` + count + `" id="provider` + count + `" value="` + provider + `"/>
                <input type="hidden" name="category` + count + `" id="category` + count + `" value="` + category + `"/>
                <input type="hidden" name="price` + count + `" id="price` + count + `" value="` + price + `"/>
                <td>
                ` + code + `
                <input type="hidden" name="pcodevalue` + count + `" id="pcodevalue` + count + `" value="` + code + `"/>
                </td>
                <td>
                ` + name + `
                <input type="hidden" name="pnamevalue` + count + `" id="pnamevalue` + count + `" value="` + name + `"/>
                </td>
                <td>
                <small class="badge badge-primary">Nuevo</small>
                <input type="hidden" name="status` + count + `" id="status` + count + `" value="nuevo"/>
                </td>
                <td>
                $` + purchase + `
                <input type="hidden" name="purchasevalue` + count + `" id="purchasevalue` + count + `" value="` + purchase + `"/>
                </td>
                <td>
                ` + quantity + `
                <input type="hidden" name="quantityvalue` + count + `" id="quantityvalue` + count + `" value="` + quantity + `"/>
                </td>
                <td>
                $` + total + `
                <input type="hidden" name="totalvalue` + count + `" id="totalvalue` + count + `" value="` + total + `"/>
                </td>
                <td>
                <a onclick="removeProductRow(` + count + `)"><i class="fa fa-trash"></i></a>
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

function add(id) {
    $('#setInfo').modal('show');

    $('#AddProduct').click(function () {
        var tableLength = $(Table + " tbody tr").length;
        var tableRow;
        var arrayNumber;
        var count;
        var tr = '';
        var quantityvalue = $("#quantity").val();
        var pricevalue = $("#purchase").val();
        var total = pricevalue * quantityvalue;
                    pricevalue = parseFloat(pricevalue);
                    pricevalue = pricevalue.toFixed(2);

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
            //Row
            tr = `<tr id="row` + count + `" class="` + arrayNumber + `">
                <td>
                ` + data[0].code + `
                <input type="hidden" name="pcodevalue` + count + `" id="pcodevalue` + count + `" value="` + data[0].code + `"/>
                </td>
                <td>
                ` + data[0].name + `
                <input type="hidden" name="pnamevalue` + count + `" id="pnamevalue` + count + `" value="` + data[0].name + `"/>
                </td>
                <td>
                <small class="badge badge-danger">Existente</small>
                <input type="hidden" name="status` + count + `" id="status` + count + `" value="existente"/>
                </td>
                <td>
                $` + pricevalue + `
                <input type="hidden" name="purchasevalue` + count + `" id="purchasevalue` + count + `" value="` + pricevalue + `"/>
                </td>
                <td>
                ` + quantityvalue + `
                <input type="hidden" name="quantityvalue` + count + `" id="quantityvalue` + count + `" value="` + quantityvalue + `"/>
                </td>
                <td>
                $` + total + `
                <input type="hidden" name="totalvalue` + count + `" id="totalvalue` + count + `" value="` + total + `"/>
                </td>
                <td>
                <a onclick="removeProductRow(` + count + `)"><i class="fa fa-trash"></i></a>
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


function countRow() {
    var tableLength = $(Table + " tbody tr").length;
    console.log(tableLength);
    $("#trCount").val(tableLength);
}
</script>