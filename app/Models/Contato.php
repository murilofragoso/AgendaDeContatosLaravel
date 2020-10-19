<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contatos';

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'idContato', 'id');
    }

    public function telefones()
    {
        return $this->hasMany(Telefone::class, 'idContato', 'id');
    }
}
