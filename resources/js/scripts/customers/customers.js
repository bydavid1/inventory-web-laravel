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
            url: '/api/customers',
            type: 'GET',
        },
        columns: [
            {
                data: 'code'
            },
            {
                data: 'name'
            },
            {
                data: 'nit'
            },
            {
                data: 'phone'
            },
            {
                data: 'email'
            },
            {
                data: 'address'
            },
            {
                data: 'created_at'
            },
            {
                data: 'actions',
                orderable: false,
                searchable: false
            },
        ]
    });
});


    //----------------------------------------------------------------------
    //-------------------------Store customer---------------------------------
    //----------------------------------------------------------------------


    $('#createForm').unbind('submit').bind('submit', function (stay) {
        stay.preventDefault();

        if (validate()) {
            var formdata = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: route('storeCustomer'),
                data: formdata,
                beforeSend: function () {
                    Swal.fire({
                        title: 'Guardando',
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
                        title: 'Registrado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    //Clear all fields
                    document.getElementById('createForm').reset();
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
    });

    //-----------------Validate function-------------------

    function validate(){

        let handler = 0

        //reset all fields messages
        const invalidfields = document.getElementsByClassName('is-invalid')
        const posterror = document.getElementById('posterror')

        const messageslength = invalidfields.length

        if (messageslength > 0) {
            posterror.classList.add('d-none')
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

        if(!document.getElementById('phone').value){
            document.getElementById('phone').classList.add('is-invalid')
            handler++
        }
        if(!document.getElementById('nit').value){
            document.getElementById('nit').classList.add('is-invalid')
            handler++
        }

        if(!document.getElementById('address').value){
            document.getElementById('address').classList.add('is-invalid')
            handler++
        }

        if(handler == 0){
            return true
        }else{
            posterror.classList.remove('d-none')
            return false
        }
    }


    //----------------------------------------------------------------------
    //-------------------------Update customer---------------------------------
    //----------------------------------------------------------------------


    function update(id){
        $.ajax({
            url: '/api/customer/' + id,
            type: 'get',
            dataType: 'json',
            serverSide : true,
            beforeSend : function() {
                if (!document.getElementById('puterror').classList.contains('d-none')) {
                    document.getElementById('puterror').classList.add('d-none')
                }

                document.getElementById('editform').reset();
            },
            statusCode: {
                200: function(response) {
                    //set data
                    document.getElementById('uemail').value = response[0].email
                    document.getElementById('uphone').value = response[0].phone
                    document.getElementById('uaddress').value = response[0].address
                    document.getElementById('put_id').value = response[0].id
                },
                404: function(){
                    //show error
                    document.getElementById('puterror').classList.remove('d-none')
                    table.ajax.reload()
                    //disable all elements
                    document.getElementById('uemail').disabled = true
                    document.getElementById('uphone').disabled = true
                    document.getElementById('uaddress').disabled = true
                    document.getElementById('editCostumer').disabled = true //<--------------------------------------fix it (not working)
                    console.clear() //temporaly
                }
            }
        })
    }

    document.getElementById('editform').addEventListener('submit', function(e){
        e.preventDefault()
        if (updateValidation() == true) {
            var formdata = $(this).serialize();
            $.ajax({
                url: route('updateCustomer', {id: document.getElementById('put_id').value}),
                type: 'POST',
                data: formdata,
                beforeSend : function() {
                    Swal.fire({
                        title: 'Actualizando',
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
                        title: 'Registrado',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    //Clear all fields
                    document.getElementById('editform').reset();
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
    });

    //-----------------Validate function-------------------

    function updateValidation(){
        let handler = 0

        //reset all fields messages
        const invalidfields = document.getElementsByClassName('is-invalid')
        const puterror = document.getElementById('puterror')

        const messageslength = invalidfields.length

        if (messageslength > 0) {
            puterror.classList.add('d-none')
            for (let x = 0; x < messageslength; x++) {
                invalidfields[0].classList.remove('is-invalid')
            }
        }

        if(!document.getElementById('uphone').value){
            document.getElementById('uphone').classList.add('is-invalid')
            handler++
        }

        if(!document.getElementById('uaddress').value){
            document.getElementById('uaddress').classList.add('is-invalid')
            handler++
        }

        if(handler == 0){
            return true
        }else{
            puterror.classList.remove('d-none')
            return false
        }
    }


    //----------------------------------------------------------------------
    //-------------------------Delete customer---------------------------------
    //----------------------------------------------------------------------


    function remove(id){
        Swal.fire({
            title: '¿Está seguro de eliminar a este cliente?',
            text: "Se enviará a la papelera",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Borrar'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: route('deleteCustomer', {id: id}),
                    type: 'POST',
                    data: $('#destroyform').serialize(),
                    success: function (response) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
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
