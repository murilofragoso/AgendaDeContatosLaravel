<?php

namespace App\Services;

use App\Repositories\Contracts\ContatoRepository;
use App\Repositories\Contracts\EnderecoRepository;
use App\Repositories\Contracts\TelefoneRepository;
use App\Services\Contracts\ContatoServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class ContatoService implements ContatoServiceInterface
{
    private $contatoRepository;
    private $telefoneRepository;
    private $enderecoRepository;

    public function __construct(
        ContatoRepository $contatoRepository,
        TelefoneRepository $telefoneRepository,
        EnderecoRepository $enderecoRepository
    ) {
        $this->contatoRepository = $contatoRepository;
        $this->telefoneRepository = $telefoneRepository;
        $this->enderecoRepository = $enderecoRepository;
    }

    public function index($idUsuarioLogado)
    {
        // Buscando contatos de um usuário
        return $this->contatoRepository->buscar($idUsuarioLogado);
    }

    public function store($inputs)
    {
        DB::beginTransaction();

        // Criando contato e salvando seu ID
        $idContato = $this->contatoRepository->store([
            "nome"      => $inputs["nome"],
            "idUsuario" => $inputs["idUsuario"]
        ]);

        if (!$idContato) {
            DB::rollback();
            return response('Erro ao cadastrar contato', 500);
        };

        // Salvando telefones deste contato
        foreach ($inputs["telefones"] as $tel) {
            $idTel = $this->telefoneRepository->store([
                "numero"    => $tel["numero"],
                "idContato" => $idContato
            ]);

            if (!$idTel) {
                DB::rollback();
                return response('Erro ao cadastrar telefone' + $tel->numero, 500);
            };
        };

        // Salvando enderecos deste contato
        foreach ($inputs["enderecos"] as $end) {
            $idEnd = $this->enderecoRepository->store(
                [
                    "cep"           => $end["cep"],
                    "logradouro"    => $end["logradouro"],
                    "numero"        => $end["numero"],
                    "bairro"        => $end["bairro"],
                    "complemento"   => $end["complemento"] ?? "",
                    "cidade"        => $end["cidade"],
                    "uf"            => $end["uf"],
                    "idContato"     => $idContato
                ]
            );

            if (!$idEnd) {
                DB::rollback();
                return response('Erro ao cadastrar endereco', 500);
            };
        };

        DB::commit();

        return response('Contato Cadastrado com sucesso!');
    }

    public function destroy($idContato)
    {
        DB::beginTransaction();
        try {
            // Deletando telefones do contato
            $this->telefoneRepository->destroyByContato($idContato);

            // Deletando enderecos do contato
            $this->enderecoRepository->destroyByContato($idContato);

            // Deletando contato
            $this->contatoRepository->destroy($idContato);
        } catch (Exception $error) {
            DB::rollback();
            return response('Erro ao excluir contato! ' + $error->getMessage(), 500);
        }

        DB::commit();

        return response('Contato Excluido com sucesso!');
    }

    public function show($idContato)
    {
        // Buscando contato especifico
        return $this->contatoRepository->get($idContato);
    }

    public function update($inputs)
    {
        $idContato = $inputs["id"];

        if (!$idContato) {
            return response('ID não encontrado!', 500);
        }

        DB::beginTransaction();
        try {
            // Atualizando contato
            $this->contatoRepository->store(
                [
                    "nome"      => $inputs["nome"],
                    "id"        => $idContato
                ]
            );

            // Deletando telefones deste contato e adicionando os telefones que vieram
            $this->telefoneRepository->destroyByContato($idContato);
            foreach ($inputs["telefones"] as $tel) {
                $idTel = $this->telefoneRepository->store(
                    [
                        "numero"    => $tel["numero"],
                        "idContato" => $idContato
                    ]
                );

                if (!$idTel) {
                    DB::rollback();
                    return response('Erro ao atualizar telefone' + $tel->numero, 500);
                };
            };

            // Deletando enderecos deste contato e adicionando os enderecos que vieram
            $this->enderecoRepository->destroyByContato($idContato);
            foreach ($inputs["enderecos"] as $end) {
                $idEnd = $this->enderecoRepository->store([
                    "cep"           => $end["cep"],
                    "logradouro"    => $end["logradouro"],
                    "numero"        => $end["numero"],
                    "bairro"        => $end["bairro"],
                    "complemento"   => $end["complemento"],
                    "cidade"        => $end["cidade"],
                    "uf"            => $end["uf"],
                    "idContato"     => $idContato
                ]);

                if (!$idEnd) {
                    DB::rollback();
                    return response('Erro ao atualizar endereco', 500);
                };
            };

        } catch (Exception $error) {
            DB::rollback();
            return response('Erro ao atualizar contato! ' + $error->getMessage(), 500);
        }

        DB::commit();

        return response('Contato Atualizado com sucesso!');
    }
}
