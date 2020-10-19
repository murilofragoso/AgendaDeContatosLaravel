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
        return $this->usuarioService->store($request->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id != session('idUsuarioLogado')){
            return abort(404);
        }
        $usuario = $this->usuarioService->show($id);
        return view('usuarios.show')->with('usuario', $usuario);
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
        return $this->usuarioService->update($req);
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
        $usuarioId = $this->usuarioService->login($request->toArray());
        if($usuarioId){
            session(['idUsuarioLogado' => $usuarioId->id]);

            return response('Login efetuado com sucesso!');
        }
        return response('Usuário ou senha incorretos', 400);
    }

    public function logout(){
        session()->flush();
        return response('Logout efetuado com sucesso!');
    }
}
