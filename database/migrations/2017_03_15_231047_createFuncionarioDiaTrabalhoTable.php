<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioDiaTrabalhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario_dia_trabalho', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato_trabalho')->unsigned();
            $table->foreign('id_contrato_trabalho')->references('id')->on('contrato_trabalho')->onDelete('cascade');
            $table->string('hora1')->nullable();
            $table->string('hora2')->nullable();
            $table->string('hora3')->nullable();
            $table->string('hora4')->nullable();
            $table->integer('dia');
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
        Schema::dropIfExists('funcionario_dia_trabalho');
    }
}
