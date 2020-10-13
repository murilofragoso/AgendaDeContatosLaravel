<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Services\Contracts\UsuarioServiceInterface', 'App\Services\UsuarioService');
        $this->app->bind('App\Services\Contracts\ContatoServiceInterface', 'App\Services\ContatoService');
    }
}
