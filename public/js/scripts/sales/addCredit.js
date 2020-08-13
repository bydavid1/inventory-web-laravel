$(document).ready(function () {

    var typingTimer; 
    var doneTypingInterval = 200;

    $('#costumer').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(searchCostumer, doneTypingInterval);
    });
});


$('#createOrderForm').unbind('submit').bind('submit', function (stay) {
    stay.preventDefault();
    let formdata = $(this).serialize();
    let url = route('storeCredit');
    let ajaxTime= new Date().getTime();
    $.ajax({
        type: 'POST',
        url: url,
        data: formdata,
        beforeSend: function () {
            Swal.fire({
                title: 'Registrando',
                html: 'Por favor espere...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            })
        },
        success: function (response) {
            let totalTime = new Date().getTime()-ajaxTime;
            console.log("Response time:" + totalTime);
            console.log(response)
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
            });
            removeAllItems()
            document.getElementById('createOrderForm').reset()

            print(response.data);
        },
        error: function (xhr, textStatus, errorMessage) {
            Swal.fire({
                position: 'top',
                icon: 'error',
                html: 'Error crítico: ' + xhr.responseJSON.message,
                showConfirmButton: true,
            });
        }
    });
});

function print(data) {
    var target = window.open('', 'PRINT', 'height=800,width=800');
    target.document.write(data.invoice);
    target.print();
    target.close();
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

    let url = '../api/costumers/search/' + input.value;

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

