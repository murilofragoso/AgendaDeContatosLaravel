<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Models\Usuario;
use App\Repositories\Contracts\UsuarioRepository;
use App\Services\Contracts\UsuarioServiceInterface;
use Illuminate\Support\Facades\Hash;
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

        if ($inputs["senha"] != $inputs["repetirSenha"]) {
            return response('Senhas não conferem!', 400);
        }

        $emailsJaCadastrados = $this->usuarioRepository->buscarPorEmail($inputs["email"]);

        if (count($emailsJaCadastrados)) {
            return response('Email já cadastrado', 400);
        }

        if (
            $this->usuarioRepository->salvar(
                [
                    "nome"  => $inputs["nome"],
                    "email" => $inputs["email"],
                    "senha" => $inputs["senha"]
                ]
            )
        ) {
            Mail::to($inputs["email"])->send(new WelcomeMail());
            return response('Usuário cadastrado com sucesso!');
        }

        return response('Erro ao cadastrar o usuário!', 500);
    }

    public function login($inputs)
    {
        return $this->usuarioRepository->login($inputs["email"], $inputs["senha"]);
    }

    public function show($idUsuario)
    {
        return $this->usuarioRepository->get($idUsuario);
    }

    public function update($inputs)
    {
        $usuario = $this->show($inputs["id"])->toArray();

        if ($usuario["email"] != $inputs["email"]) {
            $emailsJaCadastrados = $this->usuarioRepository->buscarPorEmail($inputs["email"]);

            if (count($emailsJaCadastrados)) {
                return response('Email já cadastrado', 400);
            }
        };

        $senhaAlterada = 0;
        if ($inputs["senhaAtual"] && $inputs["novaSenha"]) {
            if (!Hash::check($inputs["senhaAtual"], $usuario["senha"]))
                return response('Senha atual incorreta!', 400);

            $senhaAlterada = 1;
        }

        if (
            $this->usuarioRepository->salvar(
                [
                    "id"            => $inputs["id"],
                    "nome"          => $inputs["nome"],
                    "email"         => $inputs["email"],
                    "senha"         => $inputs["novaSenha"] ?? "",
                    "senhaAlterada" => $senhaAlterada
                ]
            )
        ) {
            return response('Usuário Atualizado com sucesso!');
        }

        return response('Erro ao atualizar o usuário!', 500);
    }
}
