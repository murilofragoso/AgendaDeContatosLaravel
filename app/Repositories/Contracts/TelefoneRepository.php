<?php

namespace App\Repositories\Contracts;

interface TelefoneRepository
{
    public function store(array $request);

    public function destroyByContato($idContato);
}
