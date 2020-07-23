//import domain
const domain = new PATH();

document.getElementById('purchase').addEventListener('keyup', function (input) {
    if (input.target.value != "" && isNaN(input.target.value) == false) {
        for (let x = 1; x < 5; x++) {
            document.getElementById('price' + x).disabled = false
            document.getElementById('utility' + x).disabled = false
        }
    }else{
        for (let x = 1; x < 5; x++) {
            document.getElementById('price' + x).disabled = true
            document.getElementById('utility' + x).disabled = true
        }
    }
})

$('#submitProductForm').unbind('submit').bind('submit', function (stay) {
    stay.preventDefault();
    var formdata = $(this).serialize();
    var url = "{{ route('makeProduct') }}";
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
                type: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
            });
            //Clear all fields
            $('#submitProductForm').closest('form').find("input[type=text], input[type=number], textarea").val("");
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

function calculate(input, type){

    let purchase = document.getElementById('purchase').value
    
    if (input.slice(0, -1) == "price") {

        let price = document.getElementById(input).value
        let identifier = input.slice(-1);
        document.getElementById('utility' + identifier).value = (price - purchase).toFixed(2)

    }else if(input.slice(0, -1) == "utility"){

        let value = document.getElementById(input).value
        let identifier = input.slice(-1);
        document.getElementById('price' + identifier).value = (Number(value) + Number(purchase)).toFixed(2)

    }
}
