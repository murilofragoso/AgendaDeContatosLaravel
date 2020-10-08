<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contato\StoreRequestContato;
use App\Services\ContatoService;
use Illuminate\Http\Request;

class ContatosController extends Controller
{

    protected $contatoService;

    public function __construct(ContatoService $contatoService)
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
