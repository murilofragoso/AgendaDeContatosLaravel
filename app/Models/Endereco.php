<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enderecos';

    public function contato()
    {
        return $this->belongsTo(Contato::class, 'idContato', 'id');
    }
}
