<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTributacaoIsencaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tributacao_isencao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tributacao')->unsigned();
            $table->foreign('id_tributacao')->references('id')->on('tributacao')->onDelete('cascade');
            $table->integer('id_imposto_faixa_simples_nacional')->unsigned();
            $table->foreign('id_imposto_faixa_simples_nacional')->references('id')->on('imposto_faixa_simples_nacional')->onDelete('cascade');
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
        Schema::dropIfExists('tributacao_isencao');
    }
}
