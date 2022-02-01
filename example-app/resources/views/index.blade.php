<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <div class="flex">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Pet</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($values as $value)
                    <tr>
                        <td><input type="checkbox" onclick="onlyOneCheck( {{$value->id}},this.checked )" id="check" value="{{$value->id}}"></td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->age}}</td>
                        <td>{{$value->pet}}</td>
                        <td>
                            <button onclick="Delete( {{ $value->id }} )">Delete</button>
                            <button onclick="Edit( {{$value->id}} )">Edit</button>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div class="itens_selectAll">
                <input type="checkbox" id="check_allCheckbox" onclick="check_all(this.checked)">marcar todos
            apagar selecionados editar selecionados
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script >



        var check_allCheckbox =$("#check_allCheckbox")
        var checkInputs = document.querySelectorAll('#check')
        var values = new Map()
        var checkbox_lenght = checkInputs.length
        var selecionado =false

        /**
         *
         */
        function onlyOneCheck(id,checked){

            if(checked){
                values.set(`CheckBoxValue=${id}`,id)
            }else{
                values.delete(`CheckBoxValue=${id}`)
            }
            if(values.sizes > 1)selecionado = true
            if(values.size < checkbox_lenght +1){
                check_allCheckbox.checked = false
            }
            if(values.size  === checkbox_lenght ){
                check_allCheckbox.checked = true
            }
            console.log(values.size,selecionado)
        }
        /**
         *
         */


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

        function Delete(id){
            const data = values.values()
            const ids = [...data]

            const div = document.querySelector('.flex')
            const token = document.querySelector('input[name=_token]').value
             fetch(`http://localhost:8000/persons/${ids}`,{
                method:'DELETE',
                headers:{
                    'X-CSRF-TOKEN':token
                }
            })
            .then((data)=>data.text())
                .then((datas)=>{

                })

                .catch((err)=>{
                    console.log('err',err)
                })
        }

    </script>
</body>
</html>
