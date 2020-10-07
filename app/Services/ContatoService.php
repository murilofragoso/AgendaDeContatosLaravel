<?php

namespace App\Services;

use App\Models\Contato;
use App\Repositories\ContatoRepositoryEloquent;

class ContatoService
{
    private $contatoRepository;

    public function __construct(ContatoRepositoryEloquent $contatoRepository)
    {
        $this->contatoRepository = $contatoRepository;
    }

    public function index($idUsuarioLogado)
    {
        return $this->contatoRepository->buscar($idUsuarioLogado);
    }
}
