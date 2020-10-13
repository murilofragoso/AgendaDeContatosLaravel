<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = factory(Usuario::class)->create();
        session(session(['idUsuarioLogado' => $user->id]));
        $this->get('/contatos/create')->assertStatus(200);
    }
}
