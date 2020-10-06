<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreRequest;
use Illuminate\Http\Request;
use App\Services\UsuarioService;

class UsuariosController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //dd('teste');
        //$validated = $request->validate();
        return $this->usuarioService->store($request->toArray());

        //app(UsuarioService::class)->store($request->toArray());

        // $usuario = new Usuario();

        // $usuario->nome = $request->nome;
        // $usuario->email = $request->email;
        // $usuario->senha = $request->senha;
        // $usuario->repetirSenha = $request->repetirSenha;
        // $usuario->save();

        // $registerUserResponse = $this->usuarioService->register($params);
        // return $registerUserResponse;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
