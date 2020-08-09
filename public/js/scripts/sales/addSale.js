$('#createOrderForm').unbind('submit').bind('submit', function (event) {
    event.preventDefault();
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
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                });
                //Clear all fields
                $('#createOrderForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
                print(response.data);
            },
            error: function (xhr, textStatus, errorMessage) {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
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

    const invalidfields = document.getElementsByClassName('is-invalid')
    const messages = document.getElementsByClassName('error')
    const messageslength = messages.length

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

    //Items count
    if (document.getElementById('items').childElementCount < 1) {
        handler++
        Swal.fire({
            icon: 'error',
            text: 'Debe haber al menos 1 producto',
            showConfirmButton: true,
        });
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