<?php

namespace App\Repositories\Contracts;

interface UsuarioRepository
{
    public function salvar(array $request);
    public function buscarPorEmail($email);
}
