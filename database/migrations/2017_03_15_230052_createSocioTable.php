<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pessoa')->unsigned();
            $table->foreign('id_pessoa')->references('id')->on('pessoa')->onDelete('cascade');
            $table->string('nome');
            $table->boolean('principal');
            $table->string('cpf');
            $table->string('rg');
            $table->string('titulo_eleitor');
            $table->string('recibo_ir')->nullable();
            $table->string('endereco');
            $table->string('bairro');
            $table->string('cidade');
            $table->integer('id_uf')->unsigned();
            $table->foreign('id_uf')->references('id')->on('uf')->onDelete('cascade');
            $table->string('cep');
            $table->string('pis');
            $table->float('pro_labore')->nullable();
            $table->string('orgao_expedidor');
            $table->date('data_nascimento')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('socio');
    }
}
