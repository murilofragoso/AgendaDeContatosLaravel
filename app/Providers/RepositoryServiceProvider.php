<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Repositories\Contracts\UsuarioRepository', 'App\Repositories\UsuarioRepositoryEloquent');

        $this->app->bind('App\Repositories\Contracts\ContatoRepository', 'App\Repositories\ContatoRepositoryEloquent');

        $this->app->bind('App\Repositories\Contracts\EnderecoRepository', 'App\Repositories\EnderecoRepositoryEloquent');

        $this->app->bind('App\Repositories\Contracts\TelefoneRepository', 'App\Repositories\TelefoneRepositoryEloquent');
    }
}
