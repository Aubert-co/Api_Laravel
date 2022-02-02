<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

    <main>
        @csrf

        <div class="flex">
            <div class="logs"></div>
            <div class="search_persons">
                <input type="text" id="inputSearch" placeholder="faça uma busca">
                <i  id="search_icons" class="material-icons"onclick="searchValues(this)">search</i>
            </div>

            <div class="createHide">
                <i id="showCreateItem" class="material-icons" onclick="showCreate()">add</i>
            </div>
            <div class="create">
                <input type="text"id="name"placeholder="name">
                <input type="text" id="age" placeholder="age">
                <input type="text" id="pet" placeholder="pet">
                <button class="button-10" role="button" id="confirmCreate" onclick="createPersons()">confirmar</button>
                    <button class="button-10 cancel" id="cancelCreate" onclick="cancelCreatePersons()"> cancelar</button>
            </div>
            <div class="table">
            <table>
        <thead>
            <tr>
                <th>Select</th>
                <th>Name</th>
                <th>Age</th>
                <th>Pet</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach($values as $value)
            <tr >
                <td><input type="checkbox" onclick="onlyOneCheck( '{{$value->id}}',this.checked )" id="check" value="{{$value->id}}"></td>
                <td>{{$value->name}}</td>
                <td>{{$value->age}}</td>
                <td>{{$value->pet}}</td>
                <td>
                    <i class="material-icons" id="delete_icons" onclick="Delete( '{{ $value->id }} ')">delete</i>
                    <i class="material-icons" id="edit_icons" onclick="Edit('{{$value->id}}','{{$value->name}}','{{$value->age}}','{{$value->pet}}' )">edit</i>

                </td>
            </tr>
        @endforeach

        </tbody>
</table>



            <div class="itens_selectAll">
                <div class="markselect">
                    <input type="checkbox" id="check_allCheckbox" onclick="check_all(this.checked)">
                    <div class="checkAllDiv">
                        marcar todos total:0
                    </div>
                </div>

                    <button class="btnDelAll" onclick="Delete_All()">Apagar Selecionados</button>


            </div>
        </div>
</div>

<div class="edition">
    <div class="itensEdition">
        <input id="editionName"  type="text" placeholder="name">
        <input id="editionAge"   type="text" placeholder="age">
        <input id="editionPet"   type="text" placeholder="pet">
        <button id="confirmEdition"  onclick="UpdateElementsConfirm()" class="button-10">confirmar</button>
        <button id="cancelEdition" onclick="UpdateElementsCancel()" class="button-10">cancelar</button>
    </div>
</div>

    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="/js/app.js" type="module"></script>
    <script >


        /*
        *OBSERVAÇÕES
        *DEIXEI TODOS OS ITENS NO MESMO SCRIPT PARA FACILITAR A VIDA DE QUEM TA LENDO E NÃO PRECISA
        *FICAR MUDANDO DE ARQUIVO, CADA PARTE DAS FUNÇÕES ESTÁ DESCREVENDO O QUE A MESMA FAZ
        *USEI JS PURO COM JQUERY PQ ALGUMAS VEZES BUGAVA USAR JQUERY PURO
        *O ARQUIVO CSS NÃO É FLEXIVEL
        */

        //Objeto para esconder a div de criação
        var objHideDiv = {divCreate:$('.create'),editionDiv:$('.edition'),showCreateItem:$('.createHide') }
        objHideDiv.divCreate.hide()
        objHideDiv.editionDiv.hide()

        //token da aplicação
        var token = $('input[name=_token]').val()

        var editionName = document.querySelector('#editionName')
        var editionAge = document.querySelector('#editionAge')
        var editionPet = document.querySelector('#editionPet')

        var checkInputs = document.querySelectorAll('#check')

        //Values para guardar os ids dos checkboxes
        var values = new Map()
        var objEditUsers = {name:editionName,age:editionAge,pet:editionPet}

        //Objetos necessarios para marcar os inputs
        var objCheckBoxes = {selecionado:false ,checkbox_lenght:checkInputs.length,checkAllDiv:$('.checkAllDiv'),
            check_allCheckbox:document.querySelector("#check_allCheckbox"),}

        //Chamadas ajax
        function callAJAX ({method,url,data}){
            $.ajax({
                method,
                url,
                headers:{'X-CSRF-TOKEN':token},
                data,
                success:function(data){
                $('body').html( data )
                }
            })
        }

        //DIV na parte de cima aonde aparece as mensagens de erros
        function SetTimeuout(msg){
            let selector = document.querySelector(".logs")
            selector.innerHTML = msg
            setTimeout(()=>{
                selector.innerHTML = ""
            },3000)

        }

        /**
         *Parte de logia de seleção unica de checkbox
         */

        function onlyOneCheck(id,checked){
            let {checkbox_lenght,selecionado,checkAllDiv,check_allCheckbox} = objCheckBoxes
            if(checked){
                values.set(`CheckBoxValue=${id}`,id)
                checkAllDiv.html(`desmarcar todos total:${values.size}`)
                check_allCheckbox.checked = true
            }else{
                values.delete(`CheckBoxValue=${id}`)
                checkAllDiv.html(`desmarcar todos total:${values.size}`)
            }
            if(values.sizes > 1)selecionado = true

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
         *Parte de logica de checkbox onde clicando marca todas as checkboxes
         */
        function check_all(checked){
            let {checkbox_lenght,selecionado,checkAllDiv} = objCheckBoxes
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

        /** Parte de delete unico por id */
        function Delete(id){
            const objToAjax = {url:`http://localhost:8000/deleteone/${id}`,method:"DELETE"}
            callAJAX(objToAjax)
        }
        /**Parte de multiplos deletes */
        function Delete_All(){
            const datas = values.values()
            const ids = [...datas]
            if(ids.length ===0){
                SetTimeuout('Selecione pelo menos 1 item')
                return
            }
            $.ajax({
                method:"DELETE",
                url:`http://localhost:8000/deletemany`,
                headers:{'X-CSRF-TOKEN':token},
                data:{ids},
                success:function(data){
                $('body').html( data )
                }
            })
          /*
          não funcionou
          const objToAjax = {method:"DELETE",url:"http://localhost:8000/deletemany",data:ids}
            callAJAX(objToAjax)*/
        }
        //confirmar a atualização de um elemento
        function UpdateElementsConfirm(){
            const {id,name,age,pet} = objEditUsers
            const data = {name:name.value,age:age.value,pet:pet.value,id}
            const objToAjax = {url:`http://localhost:8000/editone`,method:"PUT",data}
            callAJAX(objToAjax)

        }
        var editValuesInputs = (id,name,age,pet)=>{
            editionName.value = name
            editionAge.value = age
            editionPet.value = pet
            objEditUsers.id = id
        }
        //cancelar a edição e esconder a div
        function UpdateElementsCancel(){
            let {editionDiv} = objHideDiv
            editionDiv.hide()
            editValuesInputs("","","","")
        }
        //botão de edição onde abre a div para editar os valores
        function Edit(id,name,age,pet){
            let {editionDiv} = objHideDiv
            editionDiv.show()
            editValuesInputs(id,name,age,pet)
        }
        /*Parte de buscas tanto por usuario , pet ou idade
         Observação eu teria usado o search com o evento com busca sem precisar clicar pra busca
         mas o jquery ainda é um pouco misterioso pra mim.
        */
        function searchValues(){
            const text = $('#inputSearch').val()
            if(text === ''){
                SetTimeuout('digite pelo menos uma letra')
                return
            }
            const objToAjax = {url:`http://localhost:8000/find/${text}`,method:"GET"}
            callAJAX(objToAjax)
        }

        // Parte de adicionar valoeres na tabela

        function createPersons(){
            const data = {name:$("#name").val(),age:$("#age").val(),pet:$("#pet").val()}
            const objToAjax = {url:`http://localhost:8000/createpersons`,method:'POST',data}
            callAJAX(objToAjax)

        }

        //Parte onde mostra a div de inserção de valores na tabela
        function showCreate(){
            let {showCreateItem,divCreate} = objHideDiv
            showCreateItem.hide()
            divCreate.show()

        }
        //Parte onde esconde a div de inserção de valores na tabela
        function cancelCreatePersons(){
            let {showCreateItem,divCreate} = objHideDiv
            showCreateItem.show()
            divCreate.hide()
        }
    </script>
</body>
</html>
