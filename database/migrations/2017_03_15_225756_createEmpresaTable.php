<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
            $table->integer('id_natureza_juridica')->unsigned();
            $table->foreign('id_natureza_juridica')->references('id')->on('natureza_juridica')->onDelete('cascade');
            $table->integer('id_tipo_tributacao')->unsigned();
            $table->foreign('id_tipo_tributacao')->references('id')->on('tipo_tributacao')->onDelete('cascade');
            $table->string('cnpj');
            $table->string('inscricao_estadual')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('iptu')->nullable();
            $table->string('telefone',15);
            $table->string('nome_fantasia');
            $table->string('razao_social');
            $table->integer('ramal')->nullable();
            $table->string('endereco');
            $table->string('bairro');
            $table->integer('numero')->nullable();
            $table->string('cep',9);
            $table->string('cidade');
            $table->integer('id_uf')->unsigned();
            $table->foreign('id_uf')->references('id')->on('uf')->onDelete('cascade');
            $table->string('codigo_acesso_simples_nacional');
            $table->string('nacionalidade')->nullable();
            $table->string('crc')->nullable();
            $table->string('status')->default('Em Análise');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
