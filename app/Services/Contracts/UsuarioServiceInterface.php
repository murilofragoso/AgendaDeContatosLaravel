<?php

namespace App\Services\Contracts;

interface UsuarioServiceInterface
{
    public function store($inputs);

    public function login($inputs);
}
