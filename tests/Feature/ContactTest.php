<?php

namespace Tests\Feature;

use App\Models\Contato;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(Usuario::class)->create();
        session(session(['idUsuarioLogado' => $this->user->id]));

        $this->contato = [
            "nome" => "Teste",
            "telefones" => [
                ["numero" => "994588813"]
            ],
            "enderecos" => [
                [
                    "cep" => "88133517",
                    "logradouro" => "Rua Victorino Lorenzetti",
                    "numero" => "123",
                    "bairro" => "Jardim Eldorado",
                    "complemento" => "teste",
                    "cidade" => "Palhoça",
                    "uf" => "SC"
                ]
            ]
        ];
    }

    public function testCreate()
    {
        $this->get('/contatos/create')
            ->assertStatus(200)
            ->assertViewIs('contatos.create');
    }

    public function testStore()
    {

        $this->post('/contatos', $this->contato)->assertStatus(200);
    }

    public function testIndex()
    {
        $this->get('/contatos')
            ->assertStatus(200)
            ->assertViewIs('contatos.index');
    }

    public function testShow()
    {
        $contato = factory(Contato::class)->create();
        session(session(['idUsuarioLogado' => $contato->idUsuario]));
        $this->get(route('contatos.show', $contato->id))
            ->assertStatus(200)
            ->assertViewIs('contatos.create');
    }

    public function testUpdate()
    {
        $contato = factory(Contato::class)->create();
        session(session(['idUsuarioLogado' => $contato->idUsuario]));
        $this->put(route('contatos.update', $contato->id), $this->contato)->assertStatus(200);
    }

    public function testDestroy()
    {
        $contato = factory(Contato::class)->create();
        session(session(['idUsuarioLogado' => $contato->idUsuario]));
        $this->delete(route('contatos.destroy', $contato->id))->assertStatus(200);
    }
}
