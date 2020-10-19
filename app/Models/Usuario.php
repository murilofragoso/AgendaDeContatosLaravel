<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    public function contatos()
    {
        return $this->hasMany(Contato::class, 'idUsuario', 'id');
    }
}
