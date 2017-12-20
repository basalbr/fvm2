<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpostoRenda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imposto_renda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
            $table->string('exercicio');
            $table->string('status')->default('Novo');
            $table->string('recibo_anterior')->nullable();
            $table->string('declaracao_anterior')->nullable();
            $table->string('recibo')->nullable();
            $table->string('declaracao')->nullable();
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
        Schema::dropIfExists('imposto_renda');
    }
}
