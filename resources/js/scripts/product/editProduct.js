<<<<<<< HEAD
//----------------------------------------------------------------------
//-------------------------Validate prices--------------------------------
//----------------------------------------------------------------------


function calculate(input, type){

    let purchase = document.getElementById('purchase').value
    
    if (input.slice(0, -1) == "price") {

        let price = document.getElementById(input).value
        let identifier = input.slice(-1);
        if (price) {
            document.getElementById('utility' + identifier).value = (price - purchase).toFixed(2)
        }else{
            document.getElementById('utility' + identifier).value = ""
        }

    }else if(input.slice(0, -1) == "utility"){

        let value = document.getElementById(input).value
        let identifier = input.slice(-1);
        if (value) {
            document.getElementById('price' + identifier).value = (Number(value) + Number(purchase)).toFixed(2)
        }else{
            document.getElementById('price' + identifier).value = ""
        }
    }
=======
function updateProduct() {
    if (validate() == true) {
        const url = document.getElementById('submitProductForm').action
        const formdata = new FormData(document.getElementById('submitProductForm'));

        $.ajax({
            type: 'POST',
            url: url,
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: 'Guardando',
                    title: 'Por favor espere...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                })
            },
            success: function (response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    timer: 1500
                });

                //Clear all fields
                document.getElementById('submitProductForm').reset()
            },
            error: function (xhr, textStatus, errorMessage) {
                //creating errors
                let errorsLog = ""
                let responseText = JSON.parse(xhr.responseText)
                if (responseText.hasOwnProperty('errors')) {
                    let err = Object.values(responseText.errors);
                    err = err.flat()
                    err.forEach(value => {
                        errorsLog += `<p>${value}</p>`
                    });
                }else{
                    errorsLog = "<p>No errors registered</p>"
                }

                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Error: ' + xhr.responseJSON.message,
                    html: errorsLog,
                });
            }
        });
    }
}

//-----------------Validate function-------------------

function validate(){

    let handler = 0

    //reset all fields messages
    const invalidfields = document.getElementsByClassName('is-invalid')

    const messageslength = invalidfields.length

    if (messageslength > 0) {
        for (let x = 0; x < messageslength; x++) {
            invalidfields[0].classList.remove('is-invalid')
        }
    }

    if(!document.getElementById('name').value){
        document.getElementById('name').classList.add('is-invalid')
        handler++
    }

    if(!document.getElementById('code').value){
        document.getElementById('code').classList.add('is-invalid')
        handler++
    }

    if (handler === 0) {
            return true
    } else {
        toastr.error('Faltan datos importantes', 'Error');
        return false
    }
>>>>>>> database
}
