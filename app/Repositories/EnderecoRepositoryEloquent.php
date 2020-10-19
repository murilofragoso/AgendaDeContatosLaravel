<?php

namespace App\Repositories;

use App\Models\Endereco;
use App\Repositories\Contracts\EnderecoRepository;

class EnderecoRepositoryEloquent implements EnderecoRepository
{
    protected $endereco;

    public function __construct(Endereco $endereco)
    {
        $this->endereco = $endereco;
    }

    public function store(array $request)
    {
        $end = new Endereco();

        $end->cep = $request["cep"];
        $end->logradouro = $request["logradouro"];
        $end->numero = $request["numero"];
        $end->bairro = $request["bairro"];
        $end->complemento = $request["complemento"];
        $end->cidade = $request["cidade"];
        $end->uf = $request["uf"];
        $end->idContato = $request["idContato"];

        $end-> save();

        return $end->id;
    }

    public function destroyByContato($idContato)
    {
        return $this->endereco->where('idContato', $idContato)->delete();
    }
}
