//import domain
const domain = new PATH();

//----------------------------------------------------------------------
//-------------------------Store data---------------------------------
//----------------------------------------------------------------------


document.getElementById('submitProductForm').addEventListener('submit', function(e){
    e.preventDefault()
    if (validate() == true) {
        const request = new XMLHttpRequest();
        const url = route('storeProduct')
        const formdata = new FormData(this);
    
        request.addEventListener('progress', function(){
            Swal.fire({
                title: 'Guardando',
                title: 'Por favor espere...',
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
                        icon: 'success',
                        title: 'Guardado',
                        button: false,
                        timer: 1500
                    });
    
                    //Clear all fields
                    document.getElementById('submitProductForm').reset()
    
                } else {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        text: 'Ocurrio un error en el servidor',
                        button: false,
                        timer: 1500
                    });
                }
            }
        }
    
        request.open('POST', url)
        request.send(formdata)
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

    if(!document.getElementById('quantity').value){
        document.getElementById('quantity').classList.add('is-invalid')
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
//-----------Validate purchase price input is not null------------------
//----------------------------------------------------------------------


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


//----------------------------------------------------------------------
//-------------------------Validate prices--------------------------------
//----------------------------------------------------------------------


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
