<?php

namespace App\Services\Contracts;

interface UsuarioServiceInterface
{
    public function store($inputs);

    public function login($inputs);

    public function show($idUsuario);

    public function update($inputs);
}
