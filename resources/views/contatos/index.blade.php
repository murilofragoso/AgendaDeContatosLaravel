@extends('layouts.layout')

@section('content')
    <div class="container my-4" id="containerContatos">
        <input type="hidden" value="{{$contatos->idUsuarioLogado}}" id="hddnUsuarioLogado">
        <div class="content text-center">
            <h1>Contatos</h1>
            <div class="btn-toolbar justify-content-between" role="toolbar">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-outline-danger" id="btnLogOut" style="margin-bottom: 10px;">Sair</button>
                    <button type="button" class="btn btn-outline-dark" id="btnEditarPerfil" style="margin-bottom: 10px;">Editar Perfil</button>
                </div>
                <button type="button" class="btn btn-outline-dark" id="btnNovoContato" style="margin-bottom: 10px;">Novo Contato</button>
            </div>
        </div>
        <form id="formBuscaContatos">
            <div class="input-group mb-3">
                <input type="search" class="form-control" aria-describedby="btnBuscaContato" list="datalistBuscaContato" id="inputBusca">
                <div class="input-group-append">
                    <button class="btn btn-outline-dark" type="button" id="btnBuscaContato">Buscar</button>
                </div>
                </div>
                <datalist id="datalistBuscaContato">
                    @if (count($contatos ?? []) > 0)
                        @foreach ($contatos as $contato)
                            <option value="{{$contato->nome}}"></option>
                        @endforeach
                    @endif
                </datalist>
            </form>
        <table class="table table-hover" id="tableContatos">
            <thead>
                <tr>
                    <th class="col-4" scope="col">Contato</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if (count($contatos ?? []) > 0)
                    @php
                        $grupoAtual = '';
                    @endphp

                    @foreach ($contatos as $contato)
                        @php
                            $inicialContato = strtoupper($contato->nome[0]);
                        @endphp

                        @if ($inicialContato != $grupoAtual)
                            @php
                                $grupoAtual = $inicialContato;
                            @endphp

                            <tr>
                                <th>{{$grupoAtual}}</th>
                                <th></th>
                            </tr>

                        @endif

                        <tr data-id="{{$contato->id}}" class="linhaTabelaContatos">
                            <td>{{$contato->nome}}</td>
                            <td class="btnTableExcluir">Excluir</td>
                        </tr>

                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <script type="application/javascript">

        $(document).ready(function () {

            $("#btnBuscaContato").click(function(){
                let linhasFiltradas = "";
                let valorBusca = $("#inputBusca").val().toUpperCase();

                // Caso não exista valor na busca, refazer o get e voltar com o agrupamento
                if(!valorBusca){
                    location.reload();
                }

                let contatos = @json($contatos);

                contatos.forEach(element =>{
                    if(element.nome.toUpperCase().indexOf(valorBusca) != -1)
                        linhasFiltradas +=
                            "<tr data-id=" + element._id + " class='linhaTabelaContatos'>" +
                                "<td>"+ element.nome + "</td>" +
                                "<td class='btnTableExcluir'>Excluir</td>" +
                            "</tr>";
                })
                $("#tableContatos tbody").html(linhasFiltradas);
            })

            $("#btnNovoContato").click(function(){
                window.location.href = '/contatos/create';
            })

            $("#btnLogOut").click(function(){
                $.ajax({
                    url: "http://127.0.0.1:8000/usuarios/logout",
                    type: 'POST'
                }).done(function(result){
                    alert(result);
                    window.location.href = '/usuarios';
                })
            });

            $("#tableContatos").on("click", ".btnTableExcluir", function(){
                if(confirm("Deseja excluir esse contato?")){
                    let linha = $(this).closest('tr');
                    $.ajax({
                        url: "http://127.0.0.1:8000/contatos/" + linha.attr("data-id"),
                        type: 'delete'
                    }).done(function(data){
                        alert(data);
                        location.reload();
                    }).fail(function(jqXHR, textStatus, msg){
                        alert("Erro ao excluir contato: " + msg)
                    });
                }
            })

            $("#tableContatos").on("click", ".linhaTabelaContatos", function(event){
                // não abrir caso o local da linha clicado for o botão de excluir
                if($(event.target).is(".btnTableExcluir")){
                    event.stopPropagation();
                    return;
                }

                let id = $(this).attr("data-id");
                window.location.href = "/contatos/" + id;
            })

            $("#btnEditarPerfil").click(function(){
                let idUsuarioLogado = $("#hddnUsuarioLogado").val()
                window.location.href = '/usuarios/' + idUsuarioLogado
            })

        })

    </script>

@endsection
