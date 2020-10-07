@extends('layouts.layout')

@section('content')

    <div class="container my-4" id="containerCadastroContato">
            <input type="hidden" id="hddnIdContato">
            <div class="content text-center" id="divTituloCadastroContato">
                <h1>Novo Contato</h1>
            </div>
            <form id="formCadastroContato">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNome">Nome</label>
                        <input type="text" class="form-control" id="inputNome">
                    </div>
                </div>
                <!--Telefone-->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputTelefone">Telefone</label>
                        <div class="input-group mb-3" aria-describedby="ajudaTelefone">
                            <input type="text" class="form-control" id="inputTelefone" >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addTelefone">Cadastrar telefone</button>
                            </div>
                        </div>
                        <small id="ajudaTelefone" class="form-text text-muted">
                            Apenas números, no mínimo 9 dígitos
                        </small>
                    </div>
                </div>
                <div class="form-row">
                    <table class="table col-md-6" id="tableNovoContatoTelefones" style="display: none;">
                        <thead>
                            <tr>
                                <th class="col-4" scope="col">Telefones</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!--Endereço-->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCep">CEP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inputCep">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="buscaCep">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputLogradouro">Logradouro</label>
                        <input type="text" class="form-control" id="inputLogradouro">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNumero">Número</label>
                        <input type="text" class="form-control" id="inputNumero">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputBairro">Bairro</label>
                        <input type="text" class="form-control" id="inputBairro">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputComp">Complemento</label>
                        <input type="text" class="form-control" id="inputComp">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCidade">Cidade</label>
                        <input type="text" class="form-control" id="inputCidade">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputUF">UF</label>
                        <input type="text" class="form-control" id="inputUF">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button type="button" class="btn btn-outline-secondary" id="btnNovoEndereco" style="margin-bottom: 5px;">Cadastrar Endereço</button>
                    </div>
                </div>
                <div class="form-row">
                    <table class="table" id="tableNovoContatoEnderecos" style="display: none;">
                        <thead>
                            <tr>
                                <th scope="col">CEP</th>
                                <th scope="col">Logradouro</th>
                                <th scope="col">Número</th>
                                <th scope="col">Bairro</th>
                                <th scope="col">Complemento</th>
                                <th scope="col">Cidade</th>
                                <th scope="col">UF</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="btn-toolbar justify-content-between" role="toolbar">
                    <button type="reset" class="btn btn-danger" id="btnCancelarNovoContato">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>

    {{-- <script type="application/javascript">

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

    </script> --}}

@endsection
