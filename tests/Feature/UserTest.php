<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $this->get('/usuarios/create')->assertStatus(200);
    }

    public function testUserStoreReturnSuccess()
    {
        // Testando se a request store retorna sucesso
        $user = [
            "nome" => "teste",
            "email" => "teste@teste.com",
            "senha" => "senha",
            "repetirSenha" => "senha"
        ];
        $this->post('/usuarios', $user)->assertStatus(200);
    }

    public function testUserStoreReturnErrorOnPasswordDontMatch()
    {
        // Testando se a request store retorna erro caso as senhas não coincidam
        $usuarioSenhaNaoConfere = [
            "nome" => "teste",
            "email" => "teste@teste.com",
            "senha" => "senha",
            "repetirSenha" => "senhaNaoConfere"
        ];
        $this->post('/usuarios', $usuarioSenhaNaoConfere)->assertStatus(400);
    }

    public function testUserStoreReturnErrorOnEmailAlreadyRegistered()
    {
        // Testando se a request store retorna erro caso o email ja esteja registrado
        // Cadastrando usuario com o email "teste@teste.com"
        $user = [
            "nome" => "teste",
            "email" => "teste@teste.com",
            "senha" => "senha",
            "repetirSenha" => "senha"
        ];
        $this->post('/usuarios', $user);

        // Cadastrando usuario com o mesmo email "teste@teste.com"
        $usuarioEmailJaCadastrado = [
            "nome" => "testeEmailJaCadastrado",
            "email" => "teste@teste.com",
            "senha" => "senhaEmailJaCadastrado",
            "repetirSenha" => "senhaEmailJaCadastrado"
        ];
        $this->post('/usuarios', $usuarioEmailJaCadastrado)->assertStatus(400);
    }
}
