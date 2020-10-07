@extends('layouts.layout')

@section('content')
    <div class="container my-4" id="containerContatos">
        <div class="content text-center">
            <h1>Contatos</h1>
            <div class="btn-toolbar justify-content-between" role="toolbar">
                <button type="button" class="btn btn-outline-danger" id="btnLogOut" style="margin-bottom: 10px;">Sair</button>
                <button type="button" class="btn btn-outline-secondary" id="btnNovoContato" style="margin-bottom: 10px;">Novo Contato</button>
            </div>
        </div>
        <form id="formBuscaContatos">
            <div class="input-group mb-3">
                <input type="search" class="form-control" aria-describedby="btnBuscaContato" list="datalistBuscaContato" id="inputBusca">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="btnBuscaContato">Buscar</button>
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

                let contatos = @json($contatos)

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
        })

    </script>

@endsection
