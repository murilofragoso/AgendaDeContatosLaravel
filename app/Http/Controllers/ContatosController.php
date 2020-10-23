<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contato\StoreRequestContato;
use App\Services\Contracts\ContatoServiceInterface;

class ContatosController extends Controller
{

    protected $contatoService;

    public function __construct(ContatoServiceInterface $contatoService)
    {
        $this->contatoService = $contatoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUsuarioLogado = session('idUsuarioLogado');
        $response = $this->contatoService->index($idUsuarioLogado);
        $response->data->idUsuarioLogado = $idUsuarioLogado;
        return view('contatos.index')->with('contatos', $response->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contatos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestContato $request)
    {
        $req = $request->toArray();
        $req['idUsuario'] = session('idUsuarioLogado');
        $response = $this->contatoService->store($req);
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
        $response = $this->contatoService->show($id);
        if ($response->data->idUsuario != session('idUsuarioLogado')) {
            return abort(404);
        }
        return view('contatos.create')->with('contato', $response->data);
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
    public function update(StoreRequestContato $request, $id)
    {
        $req = $request->toArray();
        $req["id"] = $id;
        $response = $this->contatoService->update($req);
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
        $response = $this->contatoService->destroy($id);
        return response($response->message, $response->statusCode);
    }
}
