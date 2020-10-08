<?php

namespace App\Repositories;

use App\Models\Contato;

class ContatoRepositoryEloquent
{
    protected $contato;

    public function __construct(Contato $contato)
    {
        $this->contato = $contato;
    }

    public function buscar($idUsuarioLogado)
    {
        return $this->contato->where('idUsuario', $idUsuarioLogado)->orderBy('nome')->get();
    }

    public function store(array $request)
    {
        $cont = new Contato;

        $cont->nome = $request["nome"];
        $cont->idUsuario = $request["idUsuario"];

        $cont-> save();

        return $cont->id;
    }
}
