// ------------------------------
//        vertical Wizard       //
// ------------------------------

let wizard = $(".product-wizard");
let form = wizard.show();
wizard.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Guardar',
        next: 'Siguiente',
        previous: 'Atras'
    },
    onStepChanging: function (event, currentIndex, newIndex) {
        return true;
    },
    onFinishing: function (event, currentIndex) {

    },
    onFinished: function (event, currentIndex) {
        storeProduct()
    }
});

// Icon color change on state change
$(document).ready(function () {
    $(".current").find(".step-icon").addClass("bx bx-time-five");
});
// Icon change on state
// if click on next button icon change
$(".actions [href='#next']").click(function () {
    $(".done").find(".step-icon").removeClass("bx bx-time-five").addClass("bx bx-check-circle");
    $(".current").find(".step-icon").removeClass("bx bx-check-circle").addClass("bx bx-time-five");
})


//----------------------------------------------------------------------
//-------------------------Store data---------------------------------
//----------------------------------------------------------------------

function storeProduct() {
    if (validate() == true) {
        const url = route('storeProduct')
        const formdata = new FormData(document.getElementById('submitProductForm'));

        //clear empty prices
        for (let i = 0; i < 4; i++) {
            if (formdata.get(`prices[${i}][price]`) == "") {
                formdata.delete(`prices[${i}][price]`)
                formdata.delete(`prices[${i}][utility]`)
            }
        }

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
    const posterror = document.getElementById('posterror')
    const posterrortitle = document.getElementById('posterrortitle')

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

    if(!document.getElementById('stock').value){
        document.getElementById('stock').classList.add('is-invalid')
        handler++
    }

    let j = 0
    for (let i = 1; i < 5; i++) {
        let input = document.getElementById(`price${i}`)
        if (input.value == "") {
            input.classList.add('is-invalid')
            j++
        }
    }

    if (handler === 0) {
        if (j != 4) {
            return true
        } else {
            posterrortitle.textContent = "Debe haber al menos un precio"
            posterror.classList.remove('d-none')
            return false
        }
    } else {
        posterrortitle.textContent = "Hay datos importantes que hacen falta"
        posterror.classList.remove('d-none')
        return false
    }
}


//----------------------------------------------------------------------
//-------------------------Validate prices--------------------------------
//----------------------------------------------------------------------


function calculate(target){
    if (target.id === "purchase") {
        let result = target.value != "" && isNaN(target.value) === false ? false : true
        for (let i = 1; i < 5; i++) {
            let price = document.getElementById('price' + i)
            let utility = document.getElementById('utility' + i)
            //toggle disabled property
            price.disabled = result
            utility.disabled = result
            //clear couple of inputs
            if (price.value != "") {
                calculateField(price, utility, "clear")
            }
        }
    } else {
        let input = target.id

        if (input.slice(0, -1) == "price")
        {
            let price = document.getElementById(input)
            const identifier = input.slice(-1);
            let utility = document.getElementById('utility' + identifier)

            if (price.value != "") {
                calculateField(price, utility, "sum")
            }else {
                calculateField(price, utility, "clear")
            }
        }
        else if(input.slice(0, -1) == "utility")
        {
            let utility = document.getElementById(input)
            const identifier = input.slice(-1);
            let price = document.getElementById('price' + identifier)

            if (utility.value != "") {
                calculateField(price, utility, "sub")
            } else {
                calculateField(price, utility, "clear")
            }
        }
    }
}

/**
 * @param {Object} price Input
 * @param {Object} utility Input
 * @param {string} action The string
 */
function calculateField(price, utility, action) {
    switch (action) {
        case "clear":
            price.value = ""; utility.value = "";
            break;
        case "sum":
            utility.value = (price.value - document.getElementById('purchase').value).toFixed(2)
        break;
        case "sub":
            price.value = (Number(utility.value) + Number(document.getElementById('purchase').value)).toFixed(2)
        break;
        default:
            console.error('Especify action: clear/sum/sub')
            break;
    }
}

//----------------------------------------------------------------------
//-------------------------Service toogle--------------------------------
//----------------------------------------------------------------------

function serviceToogle() {
    let switchService = document.getElementById("is_service")
    let stock = document.getElementById("stock").closest(".form-group");

    if (switchService.checked == true) {
        stock.classList.add("d-none")
    } else if (switchService.checked == false) {
        stock.classList.remove("d-none")
    }
}

