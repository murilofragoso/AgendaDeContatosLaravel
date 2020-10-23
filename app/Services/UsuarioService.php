<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Models\Usuario;
use App\Repositories\Contracts\UsuarioRepository;
use App\Services\Contracts\UsuarioServiceInterface;
use App\Services\Responses\ServiceResponse;
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

        // Validando senha
        if ($inputs["senha"] != $inputs["repetirSenha"]) {
            return new ServiceResponse('Senhas não conferem!', 400);
        }

        // Buscando emails cadastrados com este e-mail
        $emailsJaCadastrados = $this->usuarioRepository->buscarPorEmail($inputs["email"]);

        // Verificando se existem emails ja cadastrados com este e-mail
        if (count($emailsJaCadastrados)) {
            return new ServiceResponse('Email já cadastrado', 400);
        }

        if (
            // Salvando usuário
            $this->usuarioRepository->salvar(
                [
                    "nome"  => $inputs["nome"],
                    "email" => $inputs["email"],
                    "senha" => $inputs["senha"]
                ]
            )
        ) {
            // Enviando e-mail de boas vindas
            Mail::to($inputs["email"])->send(new WelcomeMail());
            return new ServiceResponse('Usuário cadastrado com sucesso!');
        }

        return new ServiceResponse('Erro ao cadastrar o usuário!', 500);
    }

    public function login($inputs)
    {
        // Buscando ID do usuário pelo e-mail e senha para validar login
        $response = $this->usuarioRepository->login($inputs["email"], $inputs["senha"]);
        return new ServiceResponse(
            $response
                ? 'Login efetuado com sucesso'
                : 'Usuário ou senha incorretos',
            $response
                ? 200
                : 404,
            $response
        );
    }

    public function show($idUsuario)
    {
        // Buscando usuário
        $response = $this->usuarioRepository->get($idUsuario);
        return new ServiceResponse('Busca efetuada com sucesso', 200, $response);
    }

    public function update($inputs)
    {
        // Buscando usuário atual
        $usuario = $this->show($inputs["id"])->toArray();

        // Caso o e-mail seja diferente do atual, validar se ja foi cadastrado
        if ($usuario["email"] != $inputs["email"]) {
            $emailsJaCadastrados = $this->usuarioRepository->buscarPorEmail($inputs["email"]);

            if (count($emailsJaCadastrados)) {
                return new ServiceResponse('Email já cadastrado', 400);
            }
        };

        // Verificando se a senha foi alterada
        $senhaAlterada = 0;
        if ($inputs["senhaAtual"] && $inputs["novaSenha"]) {
            if (!Hash::check($inputs["senhaAtual"], $usuario["senha"]))
                return new ServiceResponse('Senha atual incorreta!', 400);

            $senhaAlterada = 1;
        }

        // Atualizando usuário
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
            return new ServiceResponse('Usuário Atualizado com sucesso!');
        }

        return new ServiceResponse('Erro ao atualizar o usuário!', 500);
    }
}
