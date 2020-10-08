<?php

namespace App\Services;

use App\Models\Contato;
use App\Repositories\ContatoRepositoryEloquent;
use App\Repositories\EnderecoRepositoryEloquent;
use App\Repositories\TelefoneRepositoryEloquent;
use Illuminate\Support\Facades\DB;

class ContatoService
{
    private $contatoRepository;
    private $telefoneRepository;
    private $enderecoRepository;

    public function __construct(ContatoRepositoryEloquent $contatoRepository,
    TelefoneRepositoryEloquent $telefoneRepository, EnderecoRepositoryEloquent $enderecoRepository)
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
                "complemento"   => $end["complemento"],
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
}
