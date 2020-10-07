@extends('layouts.layout')

@section('content')

    <div class="container my-4" id="containerCadastro">
        <div class="content text-center">
            <h1>Cadastro</h1>
        </div>
        <form id="formCadastro">
            <div class="form-group">
                <label for="inputNomeCadastro">Nome</label>
                <input type="text" class="form-control" id="inputNomeCadastro">
            </div>
            <div class="form-group">
                <label for="inputEmail">E-mail</label>
                <input type="email" class="form-control" id="inputEmail">
            </div>
            <div class="form-group">
                <label for="inputSenha">Senha</label>
                <input type="password" class="form-control" id="inputSenha">
            </div>
            <div class="form-group">
                <label for="inputConfirmarSenha">Confirme sua senha</label>
                <input type="password" class="form-control" id="inputConfirmarSenha">
            </div>
            <div class="btn-toolbar justify-content-between" role="toolbar">
                <button type="reset" class="btn btn-danger" id="btnCancelarCadastro">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>

    <script type="application/javascript">

        $(document).ready(function () {

            $("#formCadastro").submit(function(event){

                let usuario = {
                    nome: $("#inputNomeCadastro").val(),
                    email: $("#inputEmail").val(),
                    senha: $("#inputSenha").val(),
                    repetirSenha: $("#inputConfirmarSenha").val()
                }

                $.ajax({
                    url: "http://127.0.0.1:8000/usuarios",
                    type: 'POST',
                    data: usuario
                }).done(function(){
                    alert("Cadastro efetuado com sucesso")
                    redirecionarLogin();
                }).fail(function(jqXHR, textStatus, msg){
                    alert("Erro ao cadastrar: " + msg)
                });
            })

            $("#btnCancelarCadastro").click(function(){
                redirecionarLogin();
            })
        })

    </script>
@endsection
