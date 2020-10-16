@extends('layouts.layout')

@section('content')

    <div class="container my-4" id="containerCadastro">
        <input type="hidden" id="hddnIdUsuario" value="{{$usuario->id ?? ''}}">
        <div class="content text-center">
            <h1>Editar Usuário</h1>
        </div>
        <form id="formCadastro">
            <div class="form-group">
                <label for="inputNomeCadastro">Nome</label>
                <input type="text" class="form-control" id="inputNomeCadastro" value="{{$usuario->nome ?? ''}}">
            </div>
            <div class="form-group">
                <label for="inputEmail">E-mail</label>
                <input type="email" class="form-control" id="inputEmail" value="{{$usuario->email ?? ''}}">
            </div>
            <div class="form-group">
                <label for="inputSenhaAtual">Senha Atual</label>
                <input type="password" class="form-control" id="inputSenhaAtual">
            </div>
            <div class="form-group">
                <label for="inputNovaSenha">Nova Senha</label>
                <input type="password" class="form-control" id="inputNovaSenha">
            </div>
            <div class="btn-toolbar justify-content-between" role="toolbar">
                <button type="reset" class="btn btn-danger" id="btnCancelarEdit">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>

    <script type="application/javascript">

        $(document).ready(function () {

            $("#formCadastro").submit(function(event){
                event.preventDefault();

                if(($("#inputSenhaAtual").val() && !$("#inputNovaSenha").val()) || (!$("#inputSenhaAtual").val() && $("#inputNovaSenha").val())){
                   alert("Para alterar a senha, preencha ambos os campos!")
                   return;
                }

                let usuario = {
                    nome: $("#inputNomeCadastro").val(),
                    email: $("#inputEmail").val(),
                    senhaAtual: $("#inputSenhaAtual").val(),
                    novaSenha: $("#inputNovaSenha").val()
                }

                let idUsuario = $("#hddnIdUsuario").val()

                $.ajax({
                    url: "http://127.0.0.1:8000/usuarios/" + idUsuario,
                    type: 'PUT',
                    data: usuario
                }).done(function(response){
                    alert("Atualização efetuada com sucesso")
                    //redirecionarLogin();
                }).fail(function(jqXHR, textStatus, msg){
                    alert("Erro ao atualizar: " + jqXHR.responseText)
                });
            })

            $("#btnCancelarEdit").click(function(){
                window.location.href = '/contatos'
            })
        })

    </script>
@endsection
