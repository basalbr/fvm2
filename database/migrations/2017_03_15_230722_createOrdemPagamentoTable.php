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
            $table->string('referencia');
            $table->integer('id_referencia')->unsigned();
            $table->string('status')->default('Pendente');
            $table->dateTime('vencimento');
            $table->double('valor');
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
