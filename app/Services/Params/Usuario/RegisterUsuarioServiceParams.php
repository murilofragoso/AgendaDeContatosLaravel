<?php

namespace App\Services\Params\Usuario;

class RegisterUsuarioServiceParams
{
    public $nome;
    public $email;
    public $senha;
    public $repetirSenha;

    public function __construct(
        string $nome,
        string $email,
        string $senha,
        string $repetirSenha
    )
    {
        $this->nome         = $nome;
        $this->email        = $email;
        $this->senha        = $senha;
        $this->repetirSenha = $repetirSenha;
    }
}
