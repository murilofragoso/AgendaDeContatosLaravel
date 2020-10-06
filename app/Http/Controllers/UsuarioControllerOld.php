<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreRequest;
use App\Services\Contracts\UsuarioServiceInterface;
use App\Services\Params\Usuario\RegisterUsuarioServiceParams;

class UsuarioController extends Controller
{

    protected $usuarioService;

    public function __construct(UsuarioServiceInterface $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store(StoreRequest $request)
    {

        return response('Deu certo!' + $request);
        /*$params = new RegisterUsuarioServiceParams(
            $request->nome,
            $request->email,
            $request->senha,
            $request->repetirSenha
        );

        $registerUserResponse = $this->usuarioService->register($params);
        return $registerUserResponse;*/
    }
}
