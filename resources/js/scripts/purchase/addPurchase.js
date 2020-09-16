$('#createPurchaseForm').unbind('submit').bind('submit', function (stay) {
    stay.preventDefault();
    var formdata = $(this).serialize();
    var url = "{{ route('createPurchase') }}";
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
});

function print(data) {
    var invoice = data.invoice;
    var target = window.open('', 'PRINT', 'height=1000,width=1000');
    target.document.write(invoice);
    target.document.close();
    target.focus();
    target.onload = function () {
        target.print();
        target.close();
        //Clear all fields
        $('#createOrderForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
    };
}