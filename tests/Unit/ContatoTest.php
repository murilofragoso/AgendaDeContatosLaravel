<?php

namespace Tests\Unit;

use App\Models\Contato;
use App\Models\Usuario;
use App\Services\Contracts\ContatoServiceInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContatoTest extends TestCase
{

    use DatabaseTransactions;

    private $contatoService;
    private $contato;
    private $contatoManual;

    public function setUp(): void
    {
        parent::setUp();
        $this->contatoService = app(ContatoServiceInterface::class);
        $this->contato = factory(Contato::class)->create()->toArray();
        $this->contatoManual = [
            "nome" => "teste",
            "idUsuario" => $this->contato["idUsuario"],
            "telefones" => [
                ["numero" => 123654789],
                ["numero" => 789456123]
            ],
            "enderecos" => [
                [
                    "cep"           => "69090470",
                    "logradouro"    => "Rua Dona Arminda Mourão",
                    "numero"        => 123,
                    "bairro"        => "Cidade Nova",
                    "complemento"   => "proximo a praca",
                    "cidade"        => "Manaus",
                    "uf"            => "AM"
                ],
                [
                    "cep"           => "50960520",
                    "logradouro"    => "Rua Bernardim Ribeiro",
                    "numero"        => 323,
                    "bairro"        => "Várzea",
                    "cidade"        => "Recife",
                    "uf"            => "PE"
                ]
            ]
        ];
    }

    public function testIndex()
    {
        $request = $this->contatoService->index($this->contato["idUsuario"]);
        $this->assertTrue(count($request) == 1);
        $this->assertTrue($request[0]["id"] == $this->contato["id"]);
    }

    public function testStore()
    {
        $request = $this->contatoService->store($this->contatoManual);
        $this->assertTrue($request->status() == 200);
    }

    public function testShow()
    {
        $request = $this->contatoService->show($this->contato["id"])->toArray();
        $this->assertTrue($request["id"] == $this->contato["id"]);
        $this->assertTrue(array_key_exists("nome", $request));
    }

    public function testUpdate()
    {
        $this->contatoManual["id"] = $this->contato["id"];
        $request = $this->contatoService->update($this->contatoManual);
        $this->assertTrue($request->status() == 200);

        $requestIdNEncon = $this->contatoService->update(["id" => ""]);
        $this->assertTrue($requestIdNEncon->status() == 500);
    }

    public function testDestroy()
    {
        $request = $this->contatoService->destroy($this->contato["id"]);
        $this->assertTrue($request->status() == 200);
    }
}
