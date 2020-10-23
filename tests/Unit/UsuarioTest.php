<?php

namespace Tests\Unit;

use App\Models\Usuario;
use App\Services\Contracts\UsuarioServiceInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use DatabaseTransactions;

    private $usuarioService;

    public function setUp(): void
    {
        parent::setUp();
        $this->usuarioService = app(UsuarioServiceInterface::class);
    }

    public function testUserStoreReturnSuccess()
    {
        // Testando se o método store do service retorna sucesso (código 200)
        $usuario = [
            "nome" => "teste",
            "email" => "testEmailUsuario2541536@teste.com",
            "senha" => "teste123",
            "repetirSenha" => "teste123"
        ];
        $request = $this->usuarioService->store($usuario);
        $this->assertTrue($request->statusCode == 200);
    }

    public function testUserLoginReturnId()
    {
        // Testando se o método login do service retorna o ID do usuário após um login com sucesso
        $senha = bcrypt('teste123');
        $usuario = factory(Usuario::class)->create(["senha" => $senha])->toArray();
        $usuario["senha"] = 'teste123';
        $request = $this->usuarioService->login($usuario);
        $this->assertTrue($request->data->id == $usuario["id"]);
    }
}
