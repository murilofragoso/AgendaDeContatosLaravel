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

    <script type="application/javascript">

        $(document).ready(function () {

            $("#addTelefone").click(function(){
                let numeroTelefone = $("#inputTelefone").val();

                if(!numeroTelefone){ // Validando se o telefone existe
                    alert("Adicione um número de telefone!");
                    return;
                }else if(isNaN(numeroTelefone)){ // Validando se o telefone tem apenas números
                    alert("O telefone deve conter apenas números")
                    return;
                }else if(numeroTelefone.toString().length < 9){ // Validando se o telefone tem pelo menos 9 digitos
                    alert("O telefone deve possuir no mínimo 9 dígitos");
                    return;
                }

                // Validando se o telefone ja foi adicionado para aquele contato
                let valid;
                $("#tableNovoContatoTelefones tbody tr").each(function(){
                    if($(this).children().first().text() == numeroTelefone){
                        valid = "Este número ja foi adicionado para este contato";
                    }
                })

                if(valid){
                    alert(valid);
                    return;
                }

                $("#tableNovoContatoTelefones").show();
                $("#tableNovoContatoTelefones tbody").append("<tr><td>"+ numeroTelefone + "</td><td class='btnTableExcluir'>Excluir</td></tr>")
                $("#inputTelefone").val("").focus();
            })

            $("#tableNovoContatoTelefones").on("click", ".btnTableExcluir", function(){
                if(confirm("Deseja excluir esse telefone?")){
                    $(this).closest('tr').remove();
                }
                if($("#tableNovoContatoTelefones tbody td").length == 0)
                    $("#tableNovoContatoTelefones").hide();
            })

            $("#buscaCep").click(function(){
                let cep = $("#inputCep").val();

                // Validando o cep
                if(isNaN(cep)){
                    alert("CEP deve possuir apenas números")
                    return;
                }else if(cep.length != 8){
                    alert("CEP deve possuir 8 dígitos")
                    return;
                }

                $.ajax({
                    url: "https://viacep.com.br/ws/"+ cep +"/json/",
                    type: 'get'
                }).done(function(end){
                    if(end.erro){
                        alert("CEP não encontrado")
                        return;
                    }

                    $("#inputLogradouro").val(end.logradouro)
                    $("#inputBairro").val(end.bairro)
                    $("#inputComp").val(end.complemento)
                    $("#inputCidade").val(end.localidade)
                    $("#inputUF").val(end.uf)
                    $("#inputNumero").focus();
                })
            })

            $("#btnNovoEndereco").click(function(){
                if($("#inputNumero").val() && isNaN($("#inputNumero").val())){
                    alert("O número da casa deve conter apenas números")
                    return;
                }

                let linhaEndereco =
                "<tr>" +
                    "<td class='tdCep'>"+ $("#inputCep").val() + "</td>" +
                    "<td class='tdLogradouro'>"+ $("#inputLogradouro").val() + "</td>" +
                    "<td class='tdNumero'>"+ $("#inputNumero").val() + "</td>" +
                    "<td class='tdBairro'>"+ $("#inputBairro").val() + "</td>" +
                    "<td class='tdComp'>"+ $("#inputComp").val() + "</td>" +
                    "<td class='tdCidade'>"+ $("#inputCidade").val() + "</td>" +
                    "<td class='tdUf'>"+ $("#inputUF").val() + "</td>" +
                    "<td class='btnTableExcluir'>Excluir</td>" +
                "</tr>"

                $("#tableNovoContatoEnderecos").show();
                $("#tableNovoContatoEnderecos tbody").append(linhaEndereco)
                limparCamposEndereco();
            });

            function limparCamposEndereco(){
                $("#inputCep").val("");
                $("#inputLogradouro").val("");
                $("#inputNumero").val("");
                $("#inputBairro").val("");
                $("#inputComp").val("");
                $("#inputCidade").val("");
                $("#inputUF").val("");
            }

            //Excluir um endereço da lista de endereços do contato
            $("#tableNovoContatoEnderecos").on("click", ".btnTableExcluir", function(){
                if(confirm("Deseja excluir esse endereço?")){
                    $(this).closest('tr').remove();
                }
                if($("#tableNovoContatoEnderecos tbody td").length == 0)
                    $("#tableNovoContatoEnderecos").hide();
            })

            // Submit do form de cadastro de contato
            $("#formCadastroContato").submit(function(event){
                event.preventDefault();
                let idUsuarioLogado = window.localStorage.getItem('idUsuarioLogado');

                if(!idUsuarioLogado){
                    redirecionarLogin();
                    return;
                }

                //Verificando nome
                if(!$("#inputNome").val()){
                    alert("É necessário adicionar um nome ao contato");
                    return;
                }

                //Verificando se existe algum telefone pendende te cadastro
                if($("#inputTelefone").val()){
                    alert("Para cadastrar um telefone, clique em 'Cadastrar Telefone'");
                    return;
                }

                //Verificando se existe algum endereço pendente de cadastro
                if( $("#inputCep").val() || $("#inputLogradouro").val() || $("#inputNumero").val() || $("#inputBairro").val() ||
                    $("#inputComp").val() || $("#inputCidade").val() || $("#inputUF").val()){
                    alert("Para cadastrar um endereço, clique em 'Cadastrar Endereço'");
                    return;
                }

                let tel = [];
                let end = [];

                //Recuperando telefones
                $("#tableNovoContatoTelefones tbody tr").each(function(){
                    tel.push({numero: $(this).children().first().text()})
                })

                //Recuperando endereço
                $("#tableNovoContatoEnderecos tbody tr").each(function(){
                    end.push(
                        {
                            cep: $(this).children().filter($(".tdCep")).text(),
                            logradouro: $(this).children().filter($(".tdLogradouro")).text(),
                            numero: $(this).children().filter($(".tdNumero")).text(),
                            bairro: $(this).children().filter($(".tdBairro")).text(),
                            complemento: $(this).children().filter($(".tdComp")).text(),
                            cidade: $(this).children().filter($(".tdCidade")).text(),
                            uf: $(this).children().filter($(".tdUf")).text(),
                        }
                    )
                })

                let contato = {
                    nome: $("#inputNome").val(),
                    telefones: tel,
                    enderecos: end
                }

                /*if($("#hddnIdContato").val())
                    contato._id = $("#hddnIdContato").val()*/

                $.ajax({
                    url: "http://127.0.0.1:8000/contatos",
                    type: 'POST',//contato._id ? 'PUT': 'POST',
                    data: contato
                }).done(function(retorno){
                    limpaListaTelefonesEndereco();
                    window.location.href = '/contatos';
                }).fail(function(jqXHR, textStatus, msg){
                    alert("Erro ao salvar contato: " + msg)
                });
            })

            function limpaListaTelefonesEndereco(){
                $("#inputNome").val("");
                $("#tableNovoContatoTelefones tbody").html("");
                $("#tableNovoContatoTelefones").hide();
                $("#tableNovoContatoEnderecos tbody").html("");
                $("#tableNovoContatoEnderecos").hide();
            }

            $("#btnCancelarNovoContato").click(function(){
                window.location.href = '/contatos';
            })
        })

    </script>

@endsection
