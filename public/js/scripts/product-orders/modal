//import domain
const domain = new PATH();

//----------------------------------------------------------------------
//-------------------------Search Product---------------------------------
//----------------------------------------------------------------------

function searchProduct() {
    
    let query = document.querySelector('#searchInput').value
    let url = domain.getDomain('api/products/order/search/' + query)

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
                                    <div class="row">
                                        <div class="col-3">
                                            <img class="img-round" src="${domain.getDomain(data[i].images[0].src)}" style="max-height:110px; max-width:110px;" />
                                        </div>
                                        <div class="col-9">
                                            <p>${data[i].description}</p>
                                        </div>
                                    </div>
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