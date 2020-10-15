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

    public function __construct(ContatoRepository $contatoRepository,
    TelefoneRepository $telefoneRepository, EnderecoRepository $enderecoRepository)
    {
        $this->contatoRepository = $contatoRepository;
        $this->telefoneRepository = $telefoneRepository;
        $this->enderecoRepository = $enderecoRepository;
    }

    public function index($idUsuarioLogado)
    {
        return $this->contatoRepository->buscar($idUsuarioLogado);
    }

    public function store($inputs)
    {
        DB::beginTransaction();

        $idContato = $this->contatoRepository->store([
            "nome"      => $inputs["nome"],
            "idUsuario" => $inputs["idUsuario"]
        ]);

        if (!$idContato){
            DB::rollback();
            return response('Erro ao cadastrar contato', 500);
        };

        foreach ($inputs["telefones"] as $tel){
            $idTel = $this->telefoneRepository->store([
                "numero"    => $tel["numero"],
                "idContato" => $idContato
            ]);

            if (!$idTel){
                DB::rollback();
                return response('Erro ao cadastrar telefone' + $tel->numero, 500);
            };
        };

        foreach ($inputs["enderecos"] as $end){
            $idEnd = $this->enderecoRepository->store([
                "cep"           => $end["cep"],
                "logradouro"    => $end["logradouro"],
                "numero"        => $end["numero"],
                "bairro"        => $end["bairro"],
                "complemento"   => $end["complemento"] ?? "",
                "cidade"        => $end["cidade"],
                "uf"            => $end["uf"],
                "idContato"     => $idContato
            ]);

            if (!$idEnd){
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
        try{

            $this->telefoneRepository->destroyByContato($idContato);

            $this->enderecoRepository->destroyByContato($idContato);

            $this->contatoRepository->destroy($idContato);

        }catch(Exception $error){
            DB::rollback();
            return response('Erro ao excluir contato! ' + $error->getMessage(), 500);
        }

        DB::commit();

        return response('Contato Excluido com sucesso!');
    }

    public function show($idContato)
    {
        return $this->contatoRepository->get($idContato);
    }

    public function update($inputs)
    {
        $idContato = $inputs["id"];

        if(!$idContato)
            return response('ID não encontrado!', 500);

        DB::beginTransaction();
        try{

            $this->contatoRepository->store([
                "nome"      => $inputs["nome"],
                "id"        => $idContato
            ]);

            $this->telefoneRepository->destroyByContato($idContato);
            foreach ($inputs["telefones"] as $tel){
                $idTel = $this->telefoneRepository->store([
                    "numero"    => $tel["numero"],
                    "idContato" => $idContato
                ]);

                if (!$idTel){
                    DB::rollback();
                    return response('Erro ao atualizar telefone' + $tel->numero, 500);
                };
            };

            $this->enderecoRepository->destroyByContato($idContato);
            foreach ($inputs["enderecos"] as $end){
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

                if (!$idEnd){
                    DB::rollback();
                    return response('Erro ao atualizar endereco', 500);
                };
            };

        }catch(Exception $error){
            DB::rollback();
            return response('Erro ao atualizar contato! ' + $error->getMessage(), 500);
        }

        DB::commit();

        return response('Contato Atualizado com sucesso!');
    }
}
