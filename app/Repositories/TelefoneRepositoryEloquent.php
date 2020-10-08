<?php

namespace App\Repositories;

use App\Models\Telefone;

class TelefoneRepositoryEloquent
{
    protected $telefone;

    public function __construct(Telefone $telefone)
    {
        $this->telefone = $telefone;
    }

    public function store(array $request)
    {
        $tel = new Telefone;

        $tel->numero = $request["numero"];
        $tel->idContato = $request["idContato"];

        $tel-> save();

        return $tel->id;
    }
}
