<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $this->get('/usuarios/create')->assertStatus(200);
    }

    public function testLogin()
    {
        $this->get('/usuarios/login')->assertStatus(200);
    }
}
