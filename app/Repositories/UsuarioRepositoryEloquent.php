<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Repositories\Contracts\UsuarioRepository;

class UsuarioRepositoryEloquent implements UsuarioRepository
{
    protected $usuario;

    public function __construct(Usuario $user)
    {
        $this->usuario = $user;
    }

    public function salvar(array $request)
    {
        $usu = new Usuario();

        if (array_key_exists("id", $request)) {
            $usu = $this->get($request["id"]);

            if ($request["senhaAlterada"] == 1) {
                $usu->senha = bcrypt($request["senha"]);
            }
        } else {
            $usu->senha = bcrypt($request["senha"]);
        }

        $usu->nome  = $request["nome"];
        $usu->email = $request["email"];

        return $usu->save();
    }

    public function buscarPorEmail($email)
    {
        return $this->usuario->where('email', $email)->get();
    }

    public function login($email, $senha)
    {
        $senhaEmail = $this->usuario->where('email', $email)->first('senha');
        $senhaCrypt = crypt($senha, $senhaEmail->senha);
        return $this->usuario->where('senha', $senhaCrypt)->first('id');
    }

    public function get($idUsuario)
    {
        return $this->usuario->find($idUsuario);
    }
}
