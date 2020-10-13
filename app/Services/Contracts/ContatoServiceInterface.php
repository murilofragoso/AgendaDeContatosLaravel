<?php

namespace App\Services\Contracts;

interface ContatoServiceInterface
{
    public function index($idUsuarioLogado);

    public function store($inputs);

    public function destroy($idContato);

    public function show($idContato);

    public function update($inputs);
}
