<?php

namespace App\Services;

use App\Models\Usuario;
use App\Repositories\UsuarioRepository;
use App\Services\Contracts\UsuarioServiceInterface;

class UsuarioService implements UsuarioServiceInterface
{
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function store($inputs)
    {

        if ($inputs["senha"] != $inputs["repetirSenha"]){
            return response('Senhas não conferem!', 400);
        }

        $emails = $this->usuarioRepository->buscarPorEmail($inputs["email"]);
        dd($emails);

        if (!is_null($emails)){
            return response('Email já cadastrado', 400);
        }

        if ($this->usuarioRepository->salvar([
            "nome"  => $inputs["nome"],
            "email" => $inputs["email"],
            "senha" => $inputs["senha"]
        ])){
            return response('Usuário cadastrado com sucesso!');
        }

        return response('Erro ao cadastrar o usuário!', 500);
    }
}
