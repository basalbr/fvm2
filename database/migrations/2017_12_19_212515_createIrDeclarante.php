<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrDeclarante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ir_declarante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imposto_renda')->unsigned();
            $table->foreign('id_imposto_renda')->references('id')->on('imposto_renda')->onDelete('cascade');
            $table->integer('id_ir_tipo_ocupacao')->unsigned();
            $table->foreign('id_ir_tipo_ocupacao')->references('id')->on('ir_tipo_ocupacao')->onDelete('cascade');
            $table->string('nome')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('titulo_eleitor')->nullable();
            $table->string('ocupacao')->nullable();
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
        Schema::dropIfExists('ir_declarante');
    }
}
