$('#createOrderForm').unbind('submit').bind('submit', function (stay) {
    stay.preventDefault();
    if(validate() == 0){
        var formdata = $(this).serialize();
        var url = route('storeSale');
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
                console.log(response);
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                //Clear all fields
                $('#createOrderForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
                //print(response.data);
            },
            error: function (xhr, textStatus, errorMessage) {
                Swal.fire({
                    position: 'top',
                    type: 'error',
                    html: 'Error crítico: ' + xhr.responseText,
                    showConfirmButton: true,
                });
            }
        });
    }
});

function validate(){
    let handler = 0
    //reset all fields messages

    const fields = document.getElementsByClassName('invoice-control-invalid')
    const invalidfields = document.getElementsByClassName('is-invalid')
    const messages = document.getElementsByClassName('error')
    const fieldslength = fields.length
    const messageslength = messages.length
    if (fieldslength > 0) {
        for (let x = 0; x < fieldslength; x++) {
            fields[0].classList.remove('invoice-control-invalid') 
        }
    }

    if (messageslength > 0) {
        for (let x = 0; x < messageslength; x++) {
            messages[0].parentNode.removeChild(messages[x]);
            invalidfields[0].classList.remove('is-invalid')  
        }
    }

    //error message
    const spanerror = document.createElement('span')
    spanerror.classList.add('error', 'invalid-feedback')
    spanerror.textContent = 'No puede quedar vacío'

    const nameInput = document.getElementById('name') //input name

    if(!nameInput.value){
        nameInput.after(spanerror)
        nameInput.classList.add('is-invalid')
        handler++
    }

    //table fields
    const tableLenght = document.getElementById('trCount').value

    for (let i = 0; i < tableLenght; i++) {
        

        if (document.getElementById('pnamevalue' + i).value != '') {

            let quantity = document.getElementById('quantity' + i)
            let code = document.getElementById('pcode' + i)
            let price = document.getElementById('price' + i)
            
            if (!document.getElementById('quantityvalue' + i).value) {
                quantity.parentNode.classList.add('invoice-control-invalid')
                handler++
            }

            if (!document.getElementById('pcodevalue' + i).value) {
                code.parentNode.classList.add('invoice-control-invalid')
                handler++
            }


            if (!document.getElementById('pricevalue' + i).value) {
                price.parentNode.classList.add('invoice-control-invalid')
                handler++
            }
        }
    }

    return handler;
}


function print(data) {
    var invoice = data.invoice;
    var target = window.open('', 'PRINT', 'height=800,width=800');
    target.document.write(invoice);
    target.print();
    target.close();
}