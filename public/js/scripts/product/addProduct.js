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

document.getElementById('submitProductForm').addEventListener('submit', function(e){
    e.preventDefault()
    const request = new XMLHttpRequest();
    const url = route('storeProduct')
    const formdata = new FormData(this);

    request.addEventListener('progress', function(){
        Swal.fire({
            title: 'Guardando',
            html: 'Por favor espere...',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        })
    })

    request.onreadystatechange = function(){
        var DONE = 4; // readyState 4 means the request is done.
        var OK = 200; // status 200 is a successful return.

        if (request.readyState === DONE) {
            if (request.status === OK) {
                console.log(request.responseText); // 'This is the returned text.'
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: event.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                //Clear all fields
                document.getElementById('submitProductForm').reset()

            } else {
                Swal.fire({
                    position: 'top',
                    type: 'error',
                    html: 'Ocurrio un error en el servidor' + request.responseText,
                    showConfirmButton: true,
                });
            }
        }
    }

    request.open('POST', url)

    request.send(formdata)
})


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
