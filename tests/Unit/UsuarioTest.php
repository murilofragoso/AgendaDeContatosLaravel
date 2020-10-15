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

    public function testStore()
    {
        $usuario = [
            "nome" => "teste",
            "email" => "testEmailUsuario2541536@teste.com",
            "senha" => "teste123",
            "repetirSenha" => "teste123"
        ];
        $request = $this->usuarioService->store($usuario);
        $this->assertTrue($request->status() == 200);
    }

    public function testLogin()
    {
        $senha = bcrypt('teste123');
        $usuario = factory(Usuario::class)->create(["senha" => $senha])->toArray();
        $usuario["senha"] = 'teste123';
        $request = $this->usuarioService->login($usuario);
        $this->assertTrue($request->id == $usuario["id"]);
    }
}
