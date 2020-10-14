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

    public function testStore()
    {
        $user = [
            "nome" => "teste",
            "email" => "teste@teste.com",
            "senha" => "senha",
            "repetirSenha" => "senha"
        ];
        $this->post('/usuarios', $user)->assertStatus(200);

        $usuarioSenhaNaoConfere = [
            "nome" => "teste",
            "email" => "teste@teste.com",
            "senha" => "senha",
            "repetirSenha" => "senhaNaoConfere"
        ];
        $this->post('/usuarios', $usuarioSenhaNaoConfere)->assertStatus(400);

        $usuarioEmailJaCadastrado = [
            "nome" => "teste",
            "email" => "teste@teste.com",
            "senha" => "senha",
            "repetirSenha" => "senha"
        ];
        $this->post('/usuarios', $usuarioEmailJaCadastrado)->assertStatus(400);
    }
}
