//----------------------------------------------------------------------
//-------------------------Validate prices--------------------------------
//----------------------------------------------------------------------


function calculate(input, type){

    let purchase = document.getElementById('purchase').value
    
    if (input.slice(0, -1) == "price") {

        let price = document.getElementById(input).value
        let identifier = input.slice(-1);
        if (price) {
            document.getElementById('utility' + identifier).value = (price - purchase).toFixed(2)
        }else{
            document.getElementById('utility' + identifier).value = ""
        }

    }else if(input.slice(0, -1) == "utility"){

        let value = document.getElementById(input).value
        let identifier = input.slice(-1);
        if (value) {
            document.getElementById('price' + identifier).value = (Number(value) + Number(purchase)).toFixed(2)
        }else{
            document.getElementById('price' + identifier).value = ""
        }
    }
}
