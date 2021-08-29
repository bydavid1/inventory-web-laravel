function formatCurrency (value){
    let ret = 0;

    try {

        ret = new Intl.NumberFormat('en-US',{ style: 'currency', currency: 'USD' }).format(value)

        return ret

    } catch (error) {
        console.error(`Ha fallado el formato a USD: ${error}`)
    }
}

export default formatCurrency;
