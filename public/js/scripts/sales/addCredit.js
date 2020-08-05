$('#createForm').unbind('submit').bind('submit', function (stay) {
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
            Swal.fire({
                position: 'top-end',
                type: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
            });
            document.getElementById('createForm').reset();

            print(response.data);
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
    var target = window.open('', 'PRINT', 'height=800,width=800');
    target.document.write(data.invoice);
    target.print();
    target.close();
}