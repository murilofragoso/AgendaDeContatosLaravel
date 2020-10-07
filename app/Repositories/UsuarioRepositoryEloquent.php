<?php

namespace App\Repositories;

use App\Models\Usuario;
//use App\Repositories\Contracts\UsuarioRepository as UsuarioRepositoryInterface;

class UsuarioRepository //implements UsuarioRepositoryInterface
{
    protected $usuario;

    public function __construct(Usuario $user)
    {
        $this->usuario = $user;
    }

    public function salvar(array $request)
    {
        $usu = new Usuario;

        $usu->nome  = $request["nome"];
        $usu->email = $request["email"];
        $usu->senha = $request["senha"];

        return $usu->save();
    }

    public function buscarPorEmail($email)
    {
        return $this->usuario->where('email', $email)->get();
    }

    public function login($email, $senha)
    {
        return $this->usuario->where('email', $email)->where('senha', $senha)->first('id');
    }
}
