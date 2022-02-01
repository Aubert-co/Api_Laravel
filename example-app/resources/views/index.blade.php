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

            <div class="search_persons">
                <select name="" id="">

                </select>
                <input type="text">
            </div>
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
            <div class="create">
                <input type="text">
                <input type="text">
                <input type="text">
                <button>confirmar</button>
                <button>cancelar</button>
            </div>
            <div class="itens_selectAll">
                <div class="markselect">
                    <input type="checkbox" id="check_allCheckbox" onclick="check_all(this.checked)">
                    <div class="checkAllDiv">
                        marcar todos
                    </div>
                </div>

                <div class="deleteSelect">
                    <button onclick="Delete_All()">Apagar Selecionados</button>
                </div>
                <div class="editSelect" onclick="Edit_All()">
                    <button>Editar Selecionados</button>
                </div>

            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script >


        //Obeservação usei o selector do jquery mas bugou então usei os que o js fornece mesclado com jquery
        var check_allCheckbox =document.querySelector("#check_allCheckbox")
        var checkInputs = document.querySelectorAll('#check')
        var checkAllDiv = $('.checkAllDiv')
        var values = new Map()
        var checkbox_lenght = checkInputs.length
        var selecionado =false

        /**
         *
         */
        function onlyOneCheck(id,checked){

            if(checked){
                values.set(`CheckBoxValue=${id}`,id)
                checkAllDiv.html(`desmarcar todos total:${values.size}`)
                check_allCheckbox.checked = true
            }else{
                values.delete(`CheckBoxValue=${id}`)
                checkAllDiv.html(`desmarcar todos total:${values.size}`)
            }
            if(values.sizes > 1)selecionado = true
            if(values.size < checkbox_lenght +1){


            }
            if(values.size === 0 ){
                checkAllDiv.html(`marcar todos total:${values.size}`)
                check_allCheckbox.checked = false
            }
            if(values.size  === checkbox_lenght ){
                check_allCheckbox.checked = true
                checkAllDiv.html(`desmarcar todos total:${values.size}`)
            }
        }
        /**
         *
         */


        function check_all(checked){

            if(checked){
                checkInputs.forEach((val)=>{
                    val.checked = true
                    const ids = val.value
                    values.set(`CheckBoxValue=${ids}`,ids)
                })
                checkAllDiv.html(`desmarcar todos total:${values.size}`)
                return selecionado = true
            }
                checkInputs.forEach((val)=>{
                    val.checked = false
                })
                values.clear()
                selecionado = false
                checkAllDiv.html(`marcar todos total:${values.size}`)
        }

        function Delete(id){

            var token = document.querySelector('input[name=_token]').value

            $.ajax({
                method:"DELETE",
                url:`http://localhost:8000/deleteone/${id}`,
                headers:{'X-CSRF-TOKEN':token},
                success:function(data){
                $('body').html( data )
                }
            })
        }
        function Delete_All(){
            const data = values.values()
            const ids = [...data]

            var div = document.querySelector('.flex')
            var token = document.querySelector('input[name=_token]').value

            $.ajax({
                method:"DELETE",
                url:`http://localhost:8000/deletemany`,
                headers:{'X-CSRF-TOKEN':token},
                data:{ids},
                success:function(data){
                $('body').html( data )
                }
            })
        }
        function Edit_All(){

        }
    </script>
</body>
</html>
