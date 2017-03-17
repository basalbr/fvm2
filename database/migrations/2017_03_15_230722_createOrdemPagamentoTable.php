<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdemPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_pagamento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mensalidade')->unsigned()->nullable();
            $table->foreign('id_mensalidade')->references('id')->on('mensalidade')->onDelete('cascade');
            $table->integer('id_abertura_empresa')->unsigned()->nullable();
            $table->foreign('id_abertura_empresa')->references('id')->on('abertura_empresa')->onDelete('cascade');
            $table->string('status')->default('pendente');
            $table->dateTime('vencimento');
            $table->double('valor');
            $table->string('tipo')->default('mensalidade');
            $table->integer('codigo')->nullable();
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
        Schema::dropIfExists('ordem_pagamento');
    }
}
