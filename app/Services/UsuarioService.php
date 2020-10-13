<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Models\Usuario;
use App\Repositories\Contracts\UsuarioRepository;
use App\Services\Contracts\UsuarioServiceInterface;
use Illuminate\Support\Facades\Mail;

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

        $emailsJaCadastrados = $this->usuarioRepository->buscarPorEmail($inputs["email"]);

        if (count($emailsJaCadastrados)){
            return response('Email já cadastrado', 400);
        }

        if ($this->usuarioRepository->salvar([
            "nome"  => $inputs["nome"],
            "email" => $inputs["email"],
            "senha" => $inputs["senha"]
        ])){
            Mail::to($inputs["email"])->send(new WelcomeMail());
            return response('Usuário cadastrado com sucesso!');
        }

        return response('Erro ao cadastrar o usuário!', 500);
    }

    public function login($inputs)
    {
        return $this->usuarioRepository->login($inputs["email"], $inputs["senha"]);
    }
}
