<?php

namespace App\Repositories\Contracts;

interface ContatoRepository
{
    public function buscar($idUsuarioLogado);

    public function store(array $request);

    public function destroy($idContato);

    public function get($idContato);
}
