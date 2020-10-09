<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'telefones';

    public function contato()
    {
        return $this->belongsTo(Contato::class, 'idContato', 'id');
    }
}
