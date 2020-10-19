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
        $contatos = $this->contatoService->index($idUsuarioLogado);
        $contatos->idUsuarioLogado = $idUsuarioLogado;
        return view('contatos.index')->with('contatos', $contatos);
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
        return $this->contatoService->store($req);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contato = $this->contatoService->show($id);
        if($contato->idUsuario != session('idUsuarioLogado')){
            return abort(404);
        }
        return view('contatos.create')->with('contato', $contato);
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
        return $this->contatoService->update($req);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->contatoService->destroy($id);
    }
}
