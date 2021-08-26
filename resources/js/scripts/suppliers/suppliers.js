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
            url: '/api/suppliers',
            type: 'GET',
        },
        columns: [{
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
                data: 'address'
            },
            {
                data: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });
})


    //----------------------------------------------------------------------
    //-------------------------Store customer---------------------------------
    //----------------------------------------------------------------------


    document.getElementById('createForm').addEventListener('submit', function(e){
        e.preventDefault()
        if (validate() == true) {
            let formdata = $(this).serialize()
            let url = route('storeSupplier')

            sendData(url, formdata, this)
        }
    })

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
            url: '/api/suppliers/' + id,
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
                    document.getElementById('uname').value = response.name
                    document.getElementById('uphone').value = response.phone
                    document.getElementById('unit').value = response.nit
                    document.getElementById('uaddress').value = response.address
                    document.getElementById('put_id').value = response.id
                },
                404: function(){
                    //show error
                    document.getElementById('puterror').classList.remove('d-none')
                    table.ajax.reload()
                    //disable all elements
                    document.getElementById('uname').disabled = true
                    document.getElementById('uphone').disabled = true
                    document.getElementById('unit').disabled = true
                    document.getElementById('uaddress').disabled = true
                    document.getElementById('editSupplier').disabled = true //<--------------------------------------fix it (not working)
                    console.clear() //temporaly
                }
            }
        })
    }

    document.getElementById('editform').addEventListener('submit', function(e){
        e.preventDefault()
        if (updateValidation() == true) {
            let formdata = $(this).serialize()
            let url = route('updateSupplier', {id: document.getElementById('put_id').value})

            sendData(url, formdata, this)
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

        if(!document.getElementById('uname').value){
            document.getElementById('uname').classList.add('is-invalid')
            handler++
        }

        if(!document.getElementById('uphone').value){
            document.getElementById('uphone').classList.add('is-invalid')
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
    //-------------------------Ajax function to send data---------------------------------
    //----------------------------------------------------------------------


    function sendData(url, formdata, form) {
        $.ajax({
            type: 'POST',
            url: url,
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
                    url: route('deleteSupplier', {id: id}),
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
