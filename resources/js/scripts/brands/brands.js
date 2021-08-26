var table = "";

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//----------------------------------------------------------------------
//-------------------------Get all items---------------------------------
//----------------------------------------------------------------------


$(document).ready(function () {
   table = $('#items').DataTable({
        serverSide: true,
        ajax: {
            url: '/api/brands',
            type: 'GET',
        },
        columns: [{
                data: 'image'
            },
            {
                data: 'name'
            },
            {
                data: 'available'
            },
            {
                data: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    })
}) //Ready Document


//----------------------------------------------------------------------
//-------------------------Store data---------------------------------
//----------------------------------------------------------------------


document.getElementById('createform').addEventListener('submit', function(e){
    e.preventDefault()

    if (validation('name', 'posterror') == true) {
        let formData = new FormData(this)
        let url = route('storeBrand')

        sendData(url, formData, this, table)
    }
})


//----------------------------------------------------------------------
//-------------------------Update data---------------------------------
//----------------------------------------------------------------------


function update(id) {
    $.ajax({
        type: 'GET',
        url: '/api/brands/' + id,
        beforeSend: function () {
            if (!document.getElementById('puterror').classList.contains('d-none')) {
                document.getElementById('puterror').classList.add('d-none')
            }

            document.getElementById('editform').reset();
        },
        statusCode: {
            200: function (response) {
                console.log(response)
                document.getElementById('uname').value = response.name
                document.getElementById('put_id').value = response.id
                document.getElementById('previewlogo').src = response.logo

                document.getElementById('uname').disabled = false
                document.getElementById('ulogo').disabled = false
                document.getElementById('editManufacturer').disabled = false
            },
            404: function(){
                console.clear() //temporaly
                table.ajax.reload()
                //show error
                document.getElementById('puterror').classList.remove('d-none')
                document.getElementById('puterror').textContent = "Al parecer ya no está disponible"
            }
        }
    });
}

document.getElementById('editform').addEventListener('submit', function(e){
    e.preventDefault();
    if (validation('uname', 'puterror') == true) {
        var formData = new FormData(this)
        var url = route('updateBrand', {id: document.getElementById('put_id').value})

        sendData(url, formData, this, table)
    }
})



//----------------------------------------------------------------------
//-------------------------Custom validation---------------------------------
//----------------------------------------------------------------------

    function validation(field, error){
        let handler = 0

        //reset all fields messages
        const invalidfields = document.getElementsByClassName('is-invalid')
        const errormessage = document.getElementById(error)

        const messageslength = invalidfields.length

        if (messageslength > 0) {
            errormessage.classList.add('d-none')
            for (let x = 0; x < messageslength; x++) {
                invalidfields[0].classList.remove('is-invalid')
            }
        }

        if(!document.getElementById(field).value){
            document.getElementById(field).classList.add('is-invalid')
            handler++
        }

        if(handler == 0){
            return true
        }else{
            errormessage.classList.remove('d-none')
            errormessage.textContent = 'Hay datos importantes que faltan'
            return false
        }
    }


//----------------------------------------------------------------------
//-------------------------Ajax function to send data---------------------------------
//----------------------------------------------------------------------


function sendData(url, formdata, form, table) {
    $.ajax({
        type: 'POST',
        url: url,
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
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
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Guardado',
                showConfirmButton: false,
                timer: 1500
            });
            //Clear all fields
            form.reset()
            table.ajax.reload();
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


//----------------------------------------------------------------------
//-------------------------Delete supplier---------------------------------
//----------------------------------------------------------------------


function remove(id){
    Swal.fire({
        title: '¿Está seguro de eliminar a este proveedor?',
        text: "Se enviará a la papelera",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Borrar'
        }).then((result) => {
        if (result.value) {
            $.ajax({
                url: route('deleteBrand', {id: id}),
                type: 'POST',
                data: $('#destroyform').serialize(),
                success: function (response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Eliminado',
                        timer: 1500
                    });

                    table.ajax.reload();
                },
                error: function (xhr, textStatus, errorMessage) {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        html: 'Error crítico: ' + xhr.responseText,
                        showConfirmButton: true,
                    });
                }
            })
        }
    })
}
