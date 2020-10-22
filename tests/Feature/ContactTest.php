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

    public function testContactCreateReturnSuccessAndView()
    {
        // Testando se a request create retorna sucesso e a view correta
        $this->get('/contatos/create')
            ->assertStatus(200)
            ->assertViewIs('contatos.create');
    }

    public function testContactStoreReturnSuccess()
    {
        // Testando se a request store retorna sucesso
        $this->post('/contatos', $this->contato)->assertStatus(200);
    }

    public function testContactIndexReturnSuccessAndView()
    {
        // Testando se a request index retorna sucesso e a view correta
        $this->get('/contatos')
            ->assertStatus(200)
            ->assertViewIs('contatos.index');
    }

    public function testContactShowReturnSuccessAndView()
    {
        // Testando se a request show retorna sucesso e a view correta
        $contato = factory(Contato::class)->create();
        session(session(['idUsuarioLogado' => $contato->idUsuario]));
        $this->get(route('contatos.show', $contato->id))
            ->assertStatus(200)
            ->assertViewIs('contatos.create');
    }

    public function testContactUpdateReturnSuccess()
    {
        // Testando se a request update retorna sucesso
        $contato = factory(Contato::class)->create();
        session(session(['idUsuarioLogado' => $contato->idUsuario]));
        $this->put(route('contatos.update', $contato->id), $this->contato)->assertStatus(200);
    }

    public function testContactDestroyReturnSuccess()
    {
        // Testando se a request destroy retorna sucesso
        $contato = factory(Contato::class)->create();
        session(session(['idUsuarioLogado' => $contato->idUsuario]));
        $this->delete(route('contatos.destroy', $contato->id))->assertStatus(200);
    }
}
