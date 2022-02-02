<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@csrf
<link rel="stylesheet" href="/css/styleform.css">
<div class="container">
        <header></header>
        <main>
            <div class="logs">
                @isset($name)
                @endisset
            </div>

            <div class="form">
                <form id="form">
                    <h1>Cadastro</h1>


                        <input type="text" name="name" id="name" placeholder="USERNAME">

                        <input type="text" name="senha" id="password" placeholder="PASSWORD">

                        <input type="text" id="repeatPassword" placeholder="REPEAT PASSWORD">
                        <button onclick="Submit()" name="enviar" id="enviar">Send</button>
                        <a href="/login">Login</a>
                </form>

            </div>
        </main>

        <footer></footer>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    var logs = document.querySelector(".logs")
    var form = $('#form').submit(function(e){
        e.preventDefault()
    })

    var token = $('input[name=_token]').val()
    async function callAJAX ({method,url,data}){
        $.ajax({
                method,
                url,
                headers:{'X-CSRF-TOKEN':token},
                data,
            statusCode:{
                401:function(){
                SetTimeuout(logs,'Usuario já existe')
                return
                },
                406:function(){
                    SetTimeuout(logs,'Dados invalidos')
                }
            },
            success:function(){
                window.location = "/login"
            }

        })

}
    function SetTimeuout(selector,msg){
        selector.innerHTML = msg
        setTimeout(()=>{
            selector.innerHTML = ""
        },3000)
    }
    function Submit(){

        var name = $('#name').val()
        var password = $('#password').val()
        var repeatPassword = $('#repeatPassword').val()
        if(name === '' ){
            SetTimeuout(logs,'Digite  um nome valido')
            return
        }
        if(password === '' ){
            SetTimeuout(logs,'Digite uma senha valida')
            return
        }
        if(repeatPassword === ''  ){
            SetTimeuout(logs,'Repita uma senha valida')
            return
        }
        if(password !== repeatPassword){
            SetTimeuout(logs,'Senhas não combinam')
            return
        }
        const objToAjax = {url:`http://localhost:8000/register`,method:"POST",data:{name,password}}
        callAJAX(objToAjax)

    }
</script>
</html>
