<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePontoInformacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponto_informacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ponto')->unsigned();
            $table->integer('id_funcionario')->unsigned();
            $table->string('nome');
            $table->text('descricao');
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
        Schema::dropIfExists('ponto_informacao');
    }
}
