@extends('layouts.layout')

@section('content')
    <div class="container my-4" id="containerLogin">
        <div class="content text-center">
            <h1>Login</h1>
        </div>
        <form id="formLogin">
            <div class="form-group">
                <label for="inputEmailLogin">E-mail</label>
                <input type="email" class="form-control" id="inputEmailLogin">
            </div>
            <div class="form-group">
                <label for="inputSenhaLogin">Senha</label>
                <input type="password" class="form-control" id="inputSenhaLogin">
            </div>
            <button type="submit" class="btn btn btn-primary btn-lg btn-block">Enviar</button>
        </form>
        <div class="content text-center" style="margin-top: 10px;">
            <button type="button" class="btn btn btn-secondary btn-lg btn-block" id="btnCreateUsuario">Cadastre-se</button>
        </div>
    </div>

    <script type="application/javascript">

        $(document).ready(function () {

            $("#btnCreateUsuario").click(function(){
                window.location.href = '/usuarios/create';
            })

            $("#formLogin").submit(function(event){
                event.preventDefault();

                let usuario = {
                    email: $("#inputEmailLogin").val(),
                    senha: $("#inputSenhaLogin").val()
                }

                $.ajax({
                    url: "http://127.0.0.1:8000/usuarios/login",
                    type: 'POST',
                    data: usuario
                }).done(function(result){
                    if(result)
                        window.location.href = '/contatos';
                    else
                        alert('Usuário ou senha incorretos');
                }).fail(function(jqXHR, textStatus, msg){
                    alert("Erro ao logar: " + msg)
                });
            })

        })

    </script>

@endsection
