<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\LoginRequest;
use App\Http\Requests\Usuario\StoreRequest;
use App\Http\Requests\Usuario\UpdateRequest;
use App\Services\Contracts\UsuarioServiceInterface;

class UsuariosController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioServiceInterface $usuarioService)
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
        return view('usuarios.index');
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
        $response = $this->usuarioService->store($request->toArray());
        return response($response->message, $response->statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id != session('idUsuarioLogado')) {
            return abort(404);
        }
        $response = $this->usuarioService->show($id);
        return view('usuarios.show')->with('usuario', $response->data);
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
    public function update(UpdateRequest $request, $id)
    {
        $req = $request->toArray();
        $req["id"] = $id;
        $response = $this->usuarioService->update($req);
        return response($response->message, $response->statusCode);
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

    public function login(LoginRequest $request)
    {
        $response = $this->usuarioService->login($request->toArray());
        if ($response->statusCode = 200) {
            session(['idUsuarioLogado' => $response->data->id]);
        }
        return response($response->message, $response->statusCode);
    }

    public function logout()
    {
        session()->flush();
        return response('Logout efetuado com sucesso!');
    }
}
