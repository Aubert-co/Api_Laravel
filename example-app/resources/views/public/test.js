function check_all(checked){
    console.log('here')
    if(checked){

        checkInputs.forEach((val)=>{
            val.checked = true
            const ids = val.value
            values.set(`CheckBoxValue=${ids}`,ids)
        })
       return selecionado = true
    }
    checkInputs.forEach((val)=>{
            val.checked = false
        })
        values.clear()
        selecionado = false
}
export default  check_all
