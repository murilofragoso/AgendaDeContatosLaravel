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
        if($request["id"]){
            $cont = $this->contato->find($request["id"]);
        }else{
            $cont = new Contato;
            $cont->idUsuario = $request["idUsuario"];
        }

        $cont->nome = $request["nome"];

        $cont-> save();

        return $cont->id;
    }

    public function destroy($idContato)
    {
        return $this->contato->where('id', $idContato)->delete();
    }

    public function get($idContato)
    {
        return $this->contato->find($idContato);
    }
}
