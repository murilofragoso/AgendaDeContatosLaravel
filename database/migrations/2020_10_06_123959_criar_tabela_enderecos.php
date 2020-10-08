<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cep');
            $table->string('logradouro');
            $table->integer('numero');
            $table->string('bairro');
            $table->string('complemento')->nullable();
            $table->string('cidade');
            $table->string('uf');
            $table->integer('idContato')->unsigned();
            $table->foreign('idContato')->references('id')->on('contatos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
