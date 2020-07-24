//import domain
const domain = new PATH();
var table = "";


//-------------------------Ready document---------------------------------
$(document).ready(function () {

//----------------------------------------------------------------------
//-------------------------Get all items---------------------------------
//----------------------------------------------------------------------
     table = $('#items').DataTable({
        "serverSide": true,
        "ajax": domain.getDomain('api/customers'),
        "columns": [
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
                data: 'actions'
            },
        ]
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
                url: $(this).attr('action'),
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
                        type: 'success',
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
                        type: 'error',
                        html: 'Error crítico: ' + xhr.responseText,
                        showConfirmButton: true,
                    });
                }
            });
        }
    });    

    //----------------------------------------------------------------------
    //-------------------------Validate customer---------------------------------
    //----------------------------------------------------------------------

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
});//-------------------------End Ready document---------------------------------


 //----------------------------------------------------------------------
    //-------------------------Update customer---------------------------------
    //----------------------------------------------------------------------


    function update(id){
        $.ajax({
            url: domain.getDomain('api/customer/' + id),
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

    //----------------------------------------------------------------------
    //-------------------------Delete customer---------------------------------
    //----------------------------------------------------------------------

    function remove(id){
        //Get Id from data-destroy-id property
        var id = $(this).attr('data-destroy-id');
        var action = "{{ route('deleteCostumer', ':id') }}";
        action = action.replace(":id", id);
        $("#destroyform").attr("action", action);
    }