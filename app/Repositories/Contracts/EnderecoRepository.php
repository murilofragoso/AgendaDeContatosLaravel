<?php

namespace App\Repositories\Contracts;

interface EnderecoRepository
{
    public function store(array $request);

    public function destroyByContato($idContato);
}
